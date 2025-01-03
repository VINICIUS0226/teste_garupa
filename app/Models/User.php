<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * Define os campos que podem ser preenchidos em massa no modelo User.
     * Estes campos podem ser inseridos diretamente através de métodos como create().
     *
     * @var array
     */
    protected $fillable = [
        'name',     // Nome do usuário
        'email',    // Email do usuário
        'password', // Senha do usuário
    ];

    /**
     * Os atributos que devem ser ocultados para serialização.
     *
     * Especifica quais atributos não devem ser expostos quando o modelo é convertido em array ou JSON.
     *
     * @var array
     */
    protected $hidden = [
        'password',       // A senha do usuário não deve ser visível nas respostas
        'remember_token', // O token de "lembrar-me" não deve ser exposto
    ];

    /**
     * Obtém os atributos que devem ser convertidos para outros tipos.
     *
     * Define a conversão de atributos para tipos específicos, como data e criptografia.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Converte o atributo 'email_verified_at' para tipo 'datetime'
            'password' => 'hashed',            // Garante que a senha seja tratada como uma senha criptografada
        ];
    }
}
