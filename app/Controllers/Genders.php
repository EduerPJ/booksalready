<?php

namespace App\Controllers;

use App\Models\GenderModel;
use CodeIgniter\RESTful\ResourceController;

class Genders extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index() {
        try {
            $model = new GenderModel();
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
            $model = new GenderModel();
            $data  = $model->where('id', $id)->first();
            if (empty($data)) {
                return $this->failNotFound('No gender found');
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
            $model = new GenderModel();
            $data  = [
                'name' => $this->request->getVar('name'),
            ];
            $id    = $model->insert($data, true);
            if (!$id) {
                return (
                    $this
                        ->fail(
                            $model->errors(),
                            $this->codes['invalid_data'],
                            'Bad Request',
                            'Gender could not be created'
                        )
                );
            }
            $response = [
                'status'   => $this->codes['created'],
                'error'    => null,
                'messages' => [
                    'success' => 'Gender created successfully',
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
                'name' => $this->request->getVar('name'),
            ];
            $model  = new GenderModel();
            $result = $model->update($id, $data);
            if (!$result) {
                return $this->fail('Gender could not be updated');
            }
            $response = [
                'status'   => $this->codes['updated'],
                'error'    => null,
                'messages' => [
                    'success' => 'Gender updated successfully',
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
            $model = new GenderModel();
            $data  = $model->where('id', $id)->delete($id);
            if (!$data) {
                return $this->failNotFound('No gender deleted');
            }
            $model->delete($id);
            $response = [
                'status'   => $this->codes['deleted'],
                'error'    => null,
                'messages' => [
                    'success' => 'Gender successfully deleted',
                ],
            ];
            return $this->respondDeleted($response);
        }
        catch (\Throwable $th) {
            return $this->failServerError($th->getMessage(), $th->getCode());
        }
    }
}
