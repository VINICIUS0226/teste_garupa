<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Executa o seeding para criar um usuário admin.
     *
     * Este método cria um usuário com o papel de administrador e associa permissões a ele,
     * garantindo que o usuário tenha as permissões necessárias para acessar funcionalidades
     * administrativas do sistema.
     *
     * @return void
     */
    public function run()
    {
        // Criação do usuário admin com dados predefinidos
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('adminpassword'),
        ]);

        // Busca o papel de 'admin' na tabela de roles e associa ao usuário
        $role = DB::table('roles')->where('name', 'admin')->first();
        if ($role) {
            $user->roles()->attach($role->id);
        }

        // Adiciona todas as permissões existentes para o usuário admin
        $permissions = DB::table('permissions')->get();
        foreach ($permissions as $permission) {
            $user->permissions()->attach($permission->id);
        }
    }
}
