<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        $editMyProfile = 'edit my profile';
        $editAllProfile = 'edit all profile';
        $deleteMyProfile = 'delete my profile';
        $deleteAllProfile = 'delete all profile';
        $viewMyprofile = 'view my profile';
        $viewAllprofile = 'view all profile';

        $addProduct = 'add product';
        $editAllProduct = 'edit All product';
        $editMyProduct = 'edit My product';
        $deleteAllProduct = 'delete All product';
        $deleteMyProduct = 'delete My product';

        $addCategory = 'add category';
        $editCategory = 'edit category';
        $deleteCategory = 'delete category';
        $viewCategory = 'view category';

        $addRole = 'add role';
        $editRole = 'edit role';
        $changeRoleUser = 'change role user';
        $viewRole = 'view role';

        $permission = 'assign permission';

        Permission::create(['name' => $editMyProfile]);
        Permission::create(['name' => $editAllProfile]);
        Permission::create(['name' => $deleteMyProfile]);
        Permission::create(['name' => $deleteAllProfile]);
        Permission::create(['name' => $viewMyprofile]);
        Permission::create(['name' => $viewAllprofile]);

        Permission::create(['name' => $addProduct]);
        Permission::create(['name' => $editAllProduct]);
        Permission::create(['name' => $editMyProduct]);
        Permission::create(['name' => $deleteAllProduct]);
        Permission::create(['name' => $deleteMyProduct]);

        Permission::create(['name' => $addCategory]);
        Permission::create(['name' => $editCategory]);
        Permission::create(['name' => $deleteCategory]);
        Permission::create(['name' => $viewCategory]);

        Permission::create(['name' => $addRole]);
        Permission::create(['name' => $editRole]);
        Permission::create(['name' => $changeRoleUser]);
        Permission::create(['name' => $viewRole]);

        Permission::create(['name' => $permission]);

        // Define roles available
        $admin = 'admin';
        $seller = 'seller';
        $user = 'user';

        Role::create(['name' => $admin])->givePermissionTo(Permission::all());

        Role::create(['name' => $seller])->givePermissionTo([
            $addProduct,
            $editMyProduct,
            $deleteMyProduct,
            $editMyProfile,
            $deleteMyProfile,
            $viewMyprofile,
        ]);

        Role::create(['name' => $user])->givePermissionTo([
            $editMyProfile,
            $deleteMyProfile,
            $viewMyprofile,
        ]);
    }
}
