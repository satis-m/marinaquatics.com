<?php

namespace App\Http\Traits;

trait MethodPermissionTrait
{
    public function implementMethodPermission($permissionFor): void
    {
        $this->middleware(['permission:'.$permissionFor.'-access,admin'], ['only' => ['index', 'show', 'listAll']]);
        $this->middleware(['permission:'.$permissionFor.'-create,admin'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:'.$permissionFor.'-edit,admin'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:'.$permissionFor.'-delete,admin'], ['only' => ['delete']]);
    }
}
