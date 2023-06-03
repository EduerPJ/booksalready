<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuthorsTable extends Migration
{
    public function up() {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'first_name'  => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'last_name'   => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'nickname'    => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'nationality' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'birth_date'  => [
                'type' => 'DATE',
            ],
            'death_date'  => [
                'type' => 'DATE',
                'null' => true,
            ],
            'biography'   => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'avatar'      => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'created_at'  => [
                'type' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
                'null' => true,
            ],
            'updated_at'  => [
                'type' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                'null' => true,
            ],
            'deleted_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('authors');
    }

    public function down() {
        $this->forge->dropTable('authors');
    }
}
