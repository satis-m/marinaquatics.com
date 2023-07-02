<?php

namespace App\Http\Traits;

trait MethodPermissionTrait
{
    public function implementMethodPermission($permissionFor): void
    {
        $this->middleware(
            'permission:'
            .$permissionFor.'-access|'
            .$permissionFor.'-create|'
            .$permissionFor.'-edit|'
            .$permissionFor.'-delete',
            ['only' => ['admin,index', 'admin,show', 'admin,listAll']]
        );
        $this->middleware('permission:'.$permissionFor.'-create', ['only' => ['admin,create', 'admin,store']]);
        $this->middleware('permission:'.$permissionFor.'-edit', ['only' => ['admin,edit', 'admin,update']]);
        $this->middleware('permission:'.$permissionFor.'-delete', ['only' => ['admin,delete']]);
    }
}
