<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'books';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    // Permitted fields
    protected $allowedFields = [
        'author_id',
        'title',
        'description',
        'image',
        'gender_id',
        'category_id',
        'language',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'author_id'   => 'required',
        'title'       => 'required|min_length[3]|max_length[255]',
        'description' => 'permit_empty|max_length[1000]',
        'image'       => 'permit_empty|valid_url|max_length[255]',
        'gender_id'   => 'required|integer',
        'category_id' => 'required|integer',
        'language'    => 'required|max_length[20]',
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
