<?php

namespace App\Controllers;

use App\Models\BookModel;
use CodeIgniter\RESTful\ResourceController;

class Book extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index() {
        $model = new BookModel();
        $data  = $model->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null) {
        $model = new BookModel();
        $data  = $model->where('id', $id)->first();
        if (empty($data)) {
            return $this->failNotFound('No book found');
        }
        return $this->respond($data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create() {
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

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null) {
        if (!$id || !is_numeric($id)) {
            return $this->fail('No identifier');
        }
        $data   = [
            'author_id'   => $this->request->getVar('author_id'),
            'title'       => $this->request->getVar('title'),
            'description' => $this->request->getVar('description'),
            'image'       => $this->request->getVar('image'),
            'gender_id'   => $this->request->getVar('gender_id'),
            'category_id' => $this->request->getVar('category_id'),
            'language'    => $this->request->getVar('language'),
        ];
        $model  = new BookModel();
        $result = $model->update($id, $data);
        if (!$result) {
            return $this->fail('Book could not be updated');
        }
        $response = [
            'status'   => $this->codes['updated'],
            'error'    => null,
            'messages' => [
                'success' => 'Book updated successfully',
            ],
        ];
        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null) {
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
}
