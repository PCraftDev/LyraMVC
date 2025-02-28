<?php

namespace Lyramvc\Lyramvc\Models;

use Lyramvc\Lyramvc\Core\Database;

class Model
{
    protected $table;
    protected $db;

    // Constructor yang akan menerima Database
    public function __construct($table)
    {
        $database = new Database();
        // Pastikan objek database diinisialisasi dengan benar
        $this->db = $database->medoo(); // Dapatkan koneksi Medoo dari Database
        $this->table = $table; // Nama tabel yang akan digunakan di model
    }

    // Ambil semua data dari tabel
    public function getAll()
    {
        return $this->db->select($this->table, '*'); // Ambil semua data dari tabel
    }
    // Create a new record
    public function create(array $data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Read a record by ID
    public function getById($id)
    {
        return $this->db->get($this->table, '*', ['id' => $id]);
    }

    // Update a record by ID
    public function update($id, array $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    // Delete a record by ID
    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}
