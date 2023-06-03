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
        $model = new GenderModel();
        $data  = $model->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null) {
        $model = new GenderModel();
        $data  = $model->where('id', $id)->first();
        if (empty($data)) {
            return $this->failNotFound('No gender found');
        }
        return $this->respond($data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create() {
        $model = new GenderModel();
        $data  = [
            'name'   => $this->request->getVar('name'),
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
            'name'   => $this->request->getVar('name'),
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

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null) {
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
}
