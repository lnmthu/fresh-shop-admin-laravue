<?php

use Illuminate\Database\Seeder;

class OrderPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Laravue\Models\Permission::findOrCreate('view order', 'api');
        \App\Laravue\Models\Permission::findOrCreate('manage order', 'api');

        $adminRole = App\Laravue\Models\Role::findByName(App\Laravue\Acl::ROLE_ADMIN);
        $adminRole->givePermissionTo(['view order', 'manage order']);
    }
}
