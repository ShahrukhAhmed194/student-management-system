<?php

namespace App\DAO\WebDao;

use Spatie\Permission\Models\Permission;

class PermissionDao
{
    public function getGroupByPermission()
    {
        return Permission::select('id', 'name', 'group_name')->get()->groupBy('group_name');
    }
}