<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SuperAdmin\RoleRepository;
class RoleController extends Controller
{
    //

    public function getAllRole(RoleRepository $roleRepository){
        return $roleRepository->allRoles();
    }
    public function singleRolePermission($id,RoleRepository $roleRepository){
        return $roleRepository->singleRolePermission($id);
    }
    public function createRolePermission(Request $request, RoleRepository $roleRepository){
        $request->validate([
            "role"=>['required','string'],
            "permission"=>['required','string']
        ]);
        return $roleRepository->createRole($request);
    }
}
