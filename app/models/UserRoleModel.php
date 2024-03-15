<?php

namespace App\Models;

use Lib\Systems\Models\Model;

class UserRoleModel extends Model
{
    protected string $primary_key = 'ROL_Id';

    public function __construct()
    {
        $this->table = 'userrole';
    }
}
