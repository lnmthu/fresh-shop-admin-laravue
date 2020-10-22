<?php

use Illuminate\Database\Seeder;

class ProductPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Laravue\Models\Permission::findOrCreate('view product', 'api');
        \App\Laravue\Models\Permission::findOrCreate('manage product', 'api');
        \App\Laravue\Models\Permission::findOrCreate('view menu product', 'api');
        // Assign new permissions to admin group
        $adminRole = App\Laravue\Models\Role::findByName(App\Laravue\Acl::ROLE_ADMIN);
        $adminRole->givePermissionTo(['view product', 'manage product','view menu product']);
        $visitorRole = App\Laravue\Models\Role::findByName(App\Laravue\Acl::ROLE_VISITOR);
        $visitorRole->givePermissionTo('view product');

    }
}
