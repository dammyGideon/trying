<?php

namespace App\Repositories\SuperAdmin;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
//use Your Model

/**
 * Class RoleRepository.
 */
class RoleRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Role::class;
    }
    public function createRole($role){ 
        $superAdminRole=Role::create(['name'=>$role->input('role')]);
        $superAdminRole->givePermissionTo([
            $role->input('permission')
        ]);
        return[
            "status"=>true,
            "message"=>"Roles and Permissions created"
        ];
    }
    public function allRoles(){
        $role=DB::table('roles')->get();
       return[
        "status"=>true,
        "message"=>$role
       ];
    }
    public function singleRolePermission($id){
        $role=DB::table('roles')->where('id',$id)->value('id');
        $permission_id=DB::table('role_has_permissions')->where('role_id',$role)->value('permission_id');
        $permission=DB::table('permissions')->where('id',$permission_id)->get();
        return [
            "status"=>true,
            "message"=>['roles'=>$role,'permissions'=>$permission]
        ];
    }
    public function editRole($id,$role){
        $superAdminRole=DB::table('roles')->where('id',$id)->update(['name'=>$role->input('role')]);

    }
    public function deleteRole(){

    }

}
