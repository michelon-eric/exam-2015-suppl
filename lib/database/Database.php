<?php

namespace Lib\Database;

class Database
{
    private static $connection;

    private static $last_query = '';


    private static function connect()
    {
        if (self::$connection === null) {
            $host = database_host;
            $dbname = database_name;
            $username = database_username;
            $password = database_password;

            self::$connection = new \mysqli($host, $username, $password, $dbname);

            if (self::$connection->connect_error) {
                die("Connection failed: " . self::$connection->connect_error);
            }
        }

        return self::$connection;
    }

    private static function execute_query(\mysqli_stmt $statement)
    {
        $statement->execute();

        if ($statement->error) {
            die("Error in query execution: " . $statement->error);
        }

        Database::$last_query = $statement;
        return $statement;
    }

    public static function query($sql, $bindings = [])
    {
        $connection = self::connect();

        if ($sql instanceof QueryBuilder) {
            $builtQuery = $sql->get_query();
            $bindings = $sql->get_bindings();

            $statement = $connection->prepare($builtQuery);
        } else {
            $statement = $connection->prepare($sql);
        }

        if ($statement === false) {
            die("Error in query preparation: " . $connection->error);
        }

        if (!empty($bindings)) {
            $types = '';

            foreach ($bindings as $value) {
                if (is_int($value)) {
                    $types .= 'i';
                } elseif (is_float($value)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
            }

            $statement->bind_param($types, ...$bindings);
        }

        return self::execute_query($statement);
    }

    public static function table($table)
    {
        $sql = "SELECT * FROM $table";
        $result = self::query($sql);

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

    public static function find($table, $id, $primary_key = 'id')
    {
        $sql = "SELECT * FROM $table WHERE $primary_key = ?";
        $result = self::query($sql, [$id]);

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
                    return mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
                }, $row);
            }
        }

        return null;
    }

    public static function insert($table, $data)
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $bindings = array_values($data);

        self::query($sql, $bindings);

        return self::connect()->insert_id;
    }

    public static function update($table, $id, $data, $primary_key = 'id')
    {
        $set_clause = implode(', ', array_map(function ($column) {
            return "$column = ?";
        }, array_keys($data)));

        $bindings = array_merge(array_values($data), [$id]);

        $sql = "UPDATE $table SET $set_clause WHERE $primary_key = ?";
        self::query($sql, $bindings);

        return true;
    }

    public static function delete($table, $id, $primary_key = 'id')
    {
        $sql = "DELETE FROM $table WHERE $primary_key = ?";
        self::query($sql, [$id]);

        return true;
    }

    public static function get_last_query()
    {
        return Database::$last_query;
    }
}
