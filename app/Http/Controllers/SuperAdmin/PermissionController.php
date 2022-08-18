<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\Controller;
use App\Repositories\SuperAdmin\PermissionRepository;
use App\Http\Requests\Role\PermissionRequest;
use Illuminate\Http\Request;






class PermissionController extends Controller
{
    //
    public function getAllPermission(PermissionRepository $permissionRepository){
        return $permissionRepository->allPermission();
    }
    public function getSinglePermission(PermissionRepository $permissionRepository,$id){
        return $permissionRepository->singlePermission($id);
    }
    public function createNewPermission(Request $request, PermissionRepository $permissionRepository, ){
         $permissionRepository->createPermission($request);
    }
    public function editPermission($id,Request $request,PermissionRepository $permissionRepository){
         $permissionRepository->editPermission($id,$request);
         return[
            "status"=>true,
            "message"=>"Permission updated"
         ];
    }
    public function deletePermission($id,PermissionRepository $permissionRepository){
        $permissionRepository->deletePermission($id);
        return[
            "status"=>true,
            "message"=>'Permission was successfully deleted'
        ];
    }

}
