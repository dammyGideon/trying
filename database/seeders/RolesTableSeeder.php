<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $addChild="add child";
       $editChild="edit child";
       $deleteChild="delete child";


       $addProject="add project";
       $editProject="edit project";
       $deleteProject="delete project";


    Permission::create(['name'=>$addChild]);
    Permission::create(['name'=>$editChild]);
    Permission::create(['name'=>$deleteChild]);

    Permission::create(['name'=>$addProject]);
    Permission::create(['name'=>$editProject]);
    Permission::create(['name'=>$deleteProject]);



    $parent="parent";
    $provider="provider";
    $admin="admin";

    $superAdminRole=Role::create(['name'=>$admin]);
        $superAdminRole->givePermissionTo(Permission::all());


        $admin_role=Role::create(['name'=>$provider]);
        $admin_role->givePermissionTo(Permission::all());

        $parent_role=Role::create(['name'=>$parent]);
        $parent_role->givePermissionTo([
           $addChild,
           $editChild,
           $deleteChild
        ]);
    }
}
