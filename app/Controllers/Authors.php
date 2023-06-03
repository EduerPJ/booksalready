<?php

namespace App\Controllers;

use App\Models\AuthorModel;
use CodeIgniter\RESTful\ResourceController;

class Authors extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index() {
        try {
            $model = new AuthorModel();
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
            $model = new AuthorModel();
            $data  = $model->where('id', $id)->first();
            if (empty($data)) {
                return $this->failNotFound('No author found');
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
            $model = new AuthorModel();
            $data  = [
                'first_name'  => $this->request->getVar('first_name'),
                'last_name'   => $this->request->getVar('last_name'),
                'nationality' => $this->request->getVar('nationality'),
                'birth_date'  => $this->request->getVar('birth_date'),
                'death_date'  => $this->request->getVar('death_date'),
                'biography'   => $this->request->getVar('biography'),
                'avatar'      => $this->request->getVar('avatar'),
            ];
            $id    = $model->insert($data, true);
            if (!$id) {
                return (
                    $this
                        ->fail(
                            $model->errors(),
                            $this->codes['invalid_data'],
                            'Bad Request',
                            'Author could not be created'
                        )
                );
            }
            $response = [
                'status'   => $this->codes['created'],
                'error'    => null,
                'messages' => [
                    'success' => 'Author created successfully',
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
            $data   = [
                'first_name'  => $this->request->getVar('first_name'),
                'last_name'   => $this->request->getVar('last_name'),
                'nationality' => $this->request->getVar('nationality'),
                'birth_date'  => $this->request->getVar('birth_date'),
                'death_date'  => $this->request->getVar('death_date'),
                'biography'   => $this->request->getVar('biography'),
                'avatar'      => $this->request->getVar('avatar'),
            ];
            $model  = new AuthorModel();
            $result = $model->update($id, $data);
            if (!$result) {
                return $this->fail('Author could not be updated');
            }
            $response = [
                'status'   => $this->codes['updated'],
                'error'    => null,
                'messages' => [
                    'success' => 'Author updated successfully',
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
            $model = new AuthorModel();
            $data  = $model->where('id', $id)->delete($id);
            if (!$data) {
                return $this->failNotFound('No a deleted');
            }
            $model->delete($id);
            $response = [
                'status'   => $this->codes['deleted'],
                'error'    => null,
                'messages' => [
                    'success' => 'Author successfully deleted',
                ],
            ];
            return $this->respondDeleted($response);
        } catch (\Throwable $th) {
            return $this->failServerError($th->getMessage(), $th->getCode());
        }
    }
}
