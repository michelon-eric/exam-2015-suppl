<?php

namespace Lib\Database;

class QueryBuilder
{
    private $table;
    private $select = ['*'];
    private $where = [];
    private $group_by = '';
    private $having = [];
    private $joins = [];
    private $bindings = [];

    public function from($table)
    {
        $this->table = $table;
        return $this;
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

    public function join($table, $type = 'INNER')
    {
        $this->joins[] = compact('table', 'type', 'conditions');
        return $this;
    }

    public function on(array $conditions)
    {
        $lastJoin = end($this->joins);
        if ($lastJoin) {
            $lastJoin['conditions'] = $conditions;
        }
        return $this;
    }

    public function raw($sql, $bindings = [])
    {
        return Database::query($sql, $bindings);
    }

    public function get()
    {
        return Database::query($this->get_query());
    }
    public function get_query()
    {
        // Build the dynamic query without executing it
        $sql = "SELECT " . implode(', ', $this->select) . " FROM " . $this->table;

        if (!empty($this->joins)) {
            foreach ($this->joins as $join) {
                $sql .= " " . strtoupper($join['type']) . " JOIN " . $join['table'];

                if (!empty($join['conditions'])) {
                    $sql .= " ON " . implode(' AND ', $join['conditions']);
                    $this->bindings = array_merge($this->bindings, $join['conditions']);
                }
            }
        }

        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->where);
            $this->bindings = array_merge($this->bindings, $this->where);
        }

        if (!empty($this->group_by)) {
            $sql .= " GROUP BY " . $this->group_by;
        }

        if (!empty($this->having)) {
            $sql .= " HAVING " . implode(' AND ', $this->having);
            $this->bindings = array_merge($this->bindings, $this->having);
        }

        return $sql;
    }

    public function get_bindings()
    {
        return $this->bindings;
    }
}
