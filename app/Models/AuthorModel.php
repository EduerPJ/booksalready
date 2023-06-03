<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthorModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'authors';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'first_name',
        'last_name',
        'nickname',
        'nationality',
        'birth_date',
        'death_date',
        'biography',
        'avatar',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'first_name'  => 'required|max_length[50]',
        'last_name'   => 'required|max_length[50]',
        'nationality' => 'required|max_length[50]',
        'birth_date'  => 'required|valid_date',
        'death_date'  => 'permit_empty|valid_date',
        'biography'   => 'permit_empty|max_length[500]',
        'avatar'      => 'permit_empty|valid_url',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];
}
