<?php

namespace Lib\Database;

class Database
{
    private static $connection;

    private static function connect(): \mysqli
    {
        if (self::$connection === null) {
            $host = database_host;
            $dbname = database_name;
            $username = database_username;
            $password = database_password;

            self::$connection = new \mysqli($host, $username, $password, $dbname);

            if (self::$connection->connect_error) {
                log_error("Connection failed\n\t\tError: " . self::$connection->connect_error);
                die("Connection failed: " . self::$connection->connect_error);
            }
        }

        return self::$connection;
    }

    public static function query($sql, $bindings = []): \mysqli_stmt|false
    {
        $connection = self::connect();

        /** @var \mysqli_stmt */
        $statement = $connection->prepare($sql);

        if ($statement === false) {
            die("Error in query preparation: " . $connection->error);
        }

        if (!empty($bindings)) {
            $types = '';
            $params = [];

            foreach ($bindings as $key => &$value) {
                $params[$key] = &$value;
                if (is_int($value)) {
                    $types .= 'i';
                } elseif (is_float($value)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
            }

            array_unshift($params, $types);
            call_user_func_array([$statement, 'bind_param'], $params);
        }

        $statement->execute();

        if ($statement->error) {
            log_error("Database error: \n\t\tError: $statement->error");
            return false;
        }

        return $statement;
    }

    public static function table($table): array|bool|string
    {
        $sql = "SELECT * FROM $table";
        $result = self::query($sql);

        if ($result === false)
            return false;

        $rows = [];
        $result->store_result();

        if ($result->num_rows > 0) {
            $row = [];
            $meta = $result->result_metadata();

            while ($field = $meta->fetch_field()) {
                $row[$field->name] = null;
                $bind_params[] = &$row[$field->name];
            }

            call_user_func_array([$result, 'bind_result'], $bind_params);

            while ($result->fetch()) {
                $rows[] = array_map(function ($value) {
                    return mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
                }, $row);
            }
        }

        return $rows;
    }

    public static function find($table, $id, $primary_key = 'id'): array|null|bool
    {
        $sql = "SELECT * FROM $table WHERE $primary_key = ?";
        $result = self::query($sql, [$id]);

        if ($result === false) {
            return false;
        }

        $result->store_result();

        if ($result->num_rows > 0) {
            $row = [];
            $meta = $result->result_metadata();

            while ($field = $meta->fetch_field()) {
                $row[$field->name] = null;
                $bind_params[] = &$row[$field->name];
            }

            call_user_func_array([$result, 'bind_result'], $bind_params);

            if ($result->fetch()) {
                return array_map(function ($value) {
                    return $value !== null ? mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1') : null;
                }, $row);
            }
        }

        return null;
    }

    public static function insert($table, $data): int|string|bool
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $bindings = array_values($data);

        $result = self::query($sql, $bindings);
        if ($result === false) {
            return false;
        }

        return $result->insert_id;
    }

    public static function update($table, $id, $data, $primary_key = 'id'): bool
    {
        $set_clause = implode(', ', array_map(function ($column) {
            return "$column = ?";
        }, array_keys($data)));

        $bindings = array_merge(array_values($data), [$id]);

        $sql = "UPDATE $table SET $set_clause WHERE $primary_key = ?";
        $result = self::query($sql, $bindings);

        if ($result === false) {
            return false;
        }

        return true;
    }

    public static function delete($table, $id, $primary_key = 'id'): bool
    {
        $sql = "DELETE FROM $table WHERE $primary_key = ?";
        $result = self::query($sql, [$id]);

        if ($result === false) {
            return false;
        }

        return true;
    }
}
