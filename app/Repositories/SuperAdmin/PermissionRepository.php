<?php

namespace App\Repositories\SuperAdmin;

use Illuminate\Http\JsonResponse;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
//use Your Model

/**
 * Class PermissionRepository.
 */
class PermissionRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
       return  Permission::class;
    }

    public function createPermission($permission){
       $response=Permission::create(['name'=>$permission->input('permission')]);
       return[
        "status"=>true,
        "message"=>$response
       ];
    }
    public function allPermission() {
        return DB::table('permissions')->get();
    }
    public function singlePermission($id){
        return DB::table('permissions')->where('id',$id)->get();
    }
    public function editPermission($id,$permission){
        return DB::table('permissions')->where('id',$id)->update(['name'=>$permission->input('permission')]);
    }
    public function deletePermission($id){
        return DB::table('permissions')->where('id',$id)->delete();
    }
}
