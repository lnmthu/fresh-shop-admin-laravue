<?php

use Illuminate\Database\Seeder;

class ContactPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Laravue\Models\Permission::findOrCreate('view contact', 'api');
        \App\Laravue\Models\Permission::findOrCreate('manage contact', 'api');
        \App\Laravue\Models\Permission::findOrCreate('view menu contact', 'api');
        // Assign new permissions to admin group
        $adminRole = App\Laravue\Models\Role::findByName(App\Laravue\Acl::ROLE_ADMIN);
        $adminRole->givePermissionTo(['view contact', 'manage contact','view menu contact']);
    }
}
