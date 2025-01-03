<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Executa o seeding para criar permissões e papéis (roles).
     *
     * Este método cria as permissões "create transfer" e "view transfer",
     * além de criar dois papéis: "user" e "admin". Ele também associa
     * as permissões aos papéis apropriados.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'create transfer']);
        Permission::create(['name' => 'view transfer']);

        $userRole = Role::create(['name' => 'user']);
        $adminRole = Role::create(['name' => 'admin']);

        $userRole->givePermissionTo(['create transfer', 'view transfer']);
        $adminRole->givePermissionTo(['create transfer', 'view transfer']);
    }
}
