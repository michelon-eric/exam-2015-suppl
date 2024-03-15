<?php

namespace Lib\Systems\Models;

use \Lib\Database\Database;

class Model
{
    protected string $table;

    protected string $primary_key;
    protected array $where = [];
    protected string $last_query = '';

    public function __construct()
    {
        $class_name = str_replace('Model', '', substr(strrchr(get_class($this), '\\'), 1));
        $this->table = strtolower($class_name) . 's';
    }

    public function all(): array|bool|string
    {
        return Database::table($this->table);
    }

    public function find($id): array|bool|null
    {
        return Database::find($this->table, $id, $this->primary_key);
    }

    public function insert(array $data): bool|int|string
    {
        return Database::insert($this->table, $data);
    }

    public function update($id, array $data): bool
    {
        return Database::update($this->table, $id, $data, $this->primary_key);
    }

    public function delete($id): bool
    {
        return Database::delete($this->table, $id, $this->primary_key);
    }

    public function query($sql, array $bindings): bool|\mysqli_stmt
    {
        return Database::query($sql, $bindings);
    }

    public function select_where(array $conditions): array|bool
    {
        $sql = "SELECT * FROM `$this->table` WHERE ";

        $placeholders = [];
        $values = [];

        foreach ($conditions as $column => $value) {
            $placeholders[] = "`{$column}` = ?";
            $values[] = $value;
        }

        $sql .= implode(' AND ', $placeholders);

        $result = $this->query($sql, $values);
        if ($result === false)
            return false;

        $result = $result->get_result();
        if ($result === false)
            return false;

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function select_where_first(array $conditions): array|bool|null
    {
        $sql = "SELECT * FROM `$this->table` WHERE ";

        $placeholders = [];
        $values = [];

        foreach ($conditions as $column => $value) {
            $placeholders[] = "`{$column}` = ?";
            $values[] = $value;
        }

        $sql .= implode(' AND ', $placeholders);
        $sql .= ' LIMIT 1';

        $result = $this->query($sql, $values);
        if ($result === false)
            return false;

        $result = $result->get_result();
        if ($result === false)
            return false;

        return $result->fetch_assoc();
    }

    public function select_count(): int
    {
        $sql = "SELECT COUNT(*) FROM `$this->table`";
        $result = $this->query($sql, []);
        if ($result === false)
            return 0;

        $result = $result->get_result();
        if ($result === false)
            return 0;

        $row = $result->fetch_row();
        return $row[0];
    }

    public function select_count_where(array $conditions): int
    {
        $sql = "SELECT COUNT(*) FROM `$this->table` WHERE ";

        $placeholders = [];
        $values = [];

        foreach ($conditions as $column => $value) {
            $placeholders[] = "`{$column}` = ?";
            $values[] = $value;
        }

        $sql .= implode(' AND ', $placeholders);

        $result = $this->query($sql, $values);
        if ($result === false)
            return 0;

        $result = $result->get_result();
        if ($result === false)
            return 0;

        $row = $result->fetch_row();
        return $row[0];
    }

    public function get_last_query(): string
    {
        return $this->last_query;
    }

    public function get_table(): string
    {
        return $this->table;
    }
}
