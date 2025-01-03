<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    /**
     * Atributos que podem ser atribuídos em massa.
     *
     * Define os campos que podem ser preenchidos em massa no modelo Transfer.
     * Estes campos podem ser inseridos diretamente através de métodos como create().
     *
     * @var array
     */
    protected $fillable = [
        'external_id', // Identificador externo da transferência, único para cada transferência
        'amount',      // Valor da transferência
        'expected_on', // Data esperada para a transferência
        'status',      // Status da transferência (e.g., 'completed', 'pending')
        'user_id',     // ID do usuário associado a essa transferência
    ];
}
