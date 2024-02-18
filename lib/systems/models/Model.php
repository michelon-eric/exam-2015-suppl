<?php

namespace Lib\Systems\Models;

include  lib_url . 'Database/Database.php';

use \Lib\Database\Database as Database;

class Model
{
    protected $table;

    protected $primary_key;

    public function __construct()
    {
        $class_name = str_replace('Model', '', substr(strrchr(get_class($this), '\\'), 1));
        $this->table = strtolower($class_name) . 's';
    }

    public function all()
    {
        return Database::table($this->table);
    }

    public function find($id)
    {
        return Database::find($this->table, $id, $this->primary_key);
    }

    public function insert(array $data)
    {
        return Database::insert($this->table, $data);
    }

    public function update($id, array $data)
    {
        return Database::update($this->table, $id, $data, $this->primary_key);
    }

    public function delete($id)
    {
        return Database::delete($this->table, $id, $this->primary_key);
    }

    public function query($sql, array $bindings)
    {
        return Database::query($sql, $bindings);
    }
}
