<?php

namespace App\Controllers;

use App\Models\BookModel;
use CodeIgniter\RESTful\ResourceController;

class Books extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index() {
        try {
            $model = new BookModel();
            $data  = $model->orderBy('id', 'DESC')->findAll();
            return $this->respond($data);
        }
        catch (\Throwable $th) {
            return $this->failServerError($th->getMessage(), $th->getCode());
        }
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null) {
        try {
            $model = new BookModel();
            $data  = $model->where('id', $id)->first();
            if (empty($data)) {
                return $this->failNotFound('No book found');
            }
            return $this->respond($data);
        }
        catch (\Throwable $th) {
            return $this->failServerError($th->getMessage(), $th->getCode());
        }
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create() {
        try {
            $model = new BookModel();
            $data  = [
                'author_id'   => $this->request->getVar('author_id'),
                'title'       => $this->request->getVar('title'),
                'description' => $this->request->getVar('description'),
                'image'       => $this->request->getVar('image'),
                'gender_id'   => $this->request->getVar('gender_id'),
                'category_id' => $this->request->getVar('category_id'),
                'language'    => $this->request->getVar('language'),
            ];
            $id    = $model->insert($data, true);
            if (!$id) {
                return (
                    $this
                        ->fail(
                            $model->errors(),
                            $this->codes['invalid_data'],
                            'Bad Request',
                            'Book could not be created'
                        )
                );
            }
            $response = [
                'status'   => $this->codes['created'],
                'error'    => null,
                'messages' => [
                    'success' => 'Book created successfully'
                ],
            ];
            return $this->respondCreated($response);
        }
        catch (\Throwable $th) {
            return $this->failServerError($th->getMessage(), $th->getCode());
        }
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null) {
        try {
            if (!$id || !is_numeric($id)) {
                return $this->fail('No identifier');
            }
            $data  = [
                'author_id'   => $this->request->getVar('author_id'),
                'title'       => $this->request->getVar('title'),
                'description' => $this->request->getVar('description'),
                'image'       => $this->request->getVar('image'),
                'gender_id'   => $this->request->getVar('gender_id'),
                'category_id' => $this->request->getVar('category_id'),
                'language'    => $this->request->getVar('language'),
            ];
            $model = new BookModel();
            $model->update($id, $data);
            $response = [
                'status'   => $this->codes['updated'],
                'error'    => null,
                'messages' => [
                    'success' => 'Book updated successfully',
                ],
            ];
            return $this->respond($response);
        }
        catch (\Throwable $th) {
            return $this->failServerError($th->getMessage(), $th->getCode());
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null) {
        try {
            if (!$id || !is_numeric($id)) {
                return $this->fail('No identifier');
            }
            $model = new BookModel();
            $data  = $model->where('id', $id)->delete($id);
            if (!$data) {
                return $this->failNotFound('No book deleted');
            }
            $model->delete($id);
            $response = [
                'status'   => $this->codes['deleted'],
                'error'    => null,
                'messages' => [
                    'success' => 'Book successfully deleted',
                ],
            ];
            return $this->respondDeleted($response);
        }
        catch (\Throwable $th) {
            return $this->failServerError($th->getMessage(), $th->getCode());
        }
    }
}
