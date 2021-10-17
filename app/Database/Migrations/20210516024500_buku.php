<?php

namespace App\Database\Migrations;

use CodeIgniter\CodeIgniter;

class Buku extends \CodeIgniter\Database\Migration
{

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'judul' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'slug' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'penulis' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'penerbit' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'sinopsis' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            'sampul' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('buku');
    }

    public function down()
    {
        $this->forge->dropTable('buku');
    }
}
