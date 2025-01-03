<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Executa o seeding para a base de dados da aplicação.
     *
     * Este método realiza a criação de dados iniciais no banco de dados.
     * Atualmente, ele cria um usuário de teste com dados predefinidos.
     * Pode ser expandido para incluir outros dados e tabelas conforme necessário.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
