<?php

namespace Lib\Systems\Models;

include  lib_url . 'Database/Database.php';
include lib_url . 'Database/QueryBuilder.php';

use \Lib\Database\Database as Database;
use \Lib\Database\QueryBuilder as QueryBuilder;

class Model
{
    protected $table;

    protected $primary_key;

    protected $select = ['*'];
    protected $where = [];
    protected $group_by = '';
    protected $having = [];
    protected $join = [];

    public function __construct()
    {
        $class_name = str_replace('Model', '', substr(strrchr(get_class($this), '\\'), 1));
        $this->table = strtolower($class_name) . 's';
    }

    public function select(array $columns)
    {
        $this->select = $columns;
        return $this;
    }

    public function where(array $conditions)
    {
        $this->where = $conditions;
        return $this;
    }

    public function group_by($column)
    {
        $this->group_by = $column;
        return $this;
    }

    public function having(array $conditions)
    {
        $this->having = $conditions;
        return $this;
    }

    public function join($table)
    {
        $this->join[] = compact('table', 'type', 'conditions');
        return $this;
    }

    public function on(array $conditions)
    {
        $lastJoin = end($this->join);
        if ($lastJoin) {
            $lastJoin['conditions'] = $conditions;
        }
        return $this;
    }

    public function get()
    {
        $query_builder = new QueryBuilder();

        $query_builder->from($this->table);

        $query_builder->select($this->select);

        if (!empty($this->where)) {
            $query_builder->where($this->where);
        }

        if (!empty($this->group_by)) {
            $query_builder->group_by($this->group_by);
        }

        if (!empty($this->having)) {
            $query_builder->having($this->having);
        }

        foreach ($this->join as $join) {
            $query_builder->join($join['table']);
            if (!empty($join['conditions'])) {
                $query_builder->on($join['conditions']);
            }
        }

        return $query_builder->get();
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
