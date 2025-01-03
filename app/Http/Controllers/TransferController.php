<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    /**
     * Cria uma nova transferência.
     *
     * Este método valida os dados recebidos na requisição, cria uma transferência associada
     * ao usuário autenticado e simula a atualização do status da transferência para 'completed'.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
// Valida os dados recebidos na requisição
        $validated = $request->validate([
            'external_id' => 'required|string|unique:transfers,external_id', // O campo external_id é obrigatório, uma string e único na tabela transfers
            'amount' => 'required|numeric|min:0.01', // O campo amount é obrigatório, numérico e maior que 0
            'expected_on' => 'nullable|date|after:today', // A data de vencimento não pode ser anterior ao dia atual
        ]);

// Verifica se a data de vencimento é anterior à data atual
        if (isset($validated['expected_on']) && $validated['expected_on'] < now()->toDateString()) {
            return response()->json(['error' => 'A data de vencimento não pode ser anterior ao dia de hoje.'], 422); // Retorna um erro caso a data de vencimento seja inválida
        }

// Define o user_id, se não fornecido, assume-se que o usuário autenticado é o responsável pela transferência
        $validated['user_id'] = auth()->id() ?? 1;  // Recupera o ID do usuário autenticado, caso contrário assume o valor 1

// Cria uma nova transferência com os dados validados
        $transfer = Transfer::create([
            'external_id' => $validated['external_id'],
            'amount' => $validated['amount'],
            'expected_on' => $validated['expected_on'], // Pode ser null, então a validação já garante que é uma data válida ou nula
            'user_id' => $validated['user_id'],
            'status' => 'pending', // Status inicial é "pending", será alterado para "completed" após a liquidação
        ]);

// Verifica se a data de vencimento não passou antes de enviar para a plataforma de liquidação
        if (isset($validated['expected_on']) && $validated['expected_on'] < now()->toDateString()) {
            return response()->json(['error' => 'A transferência está vencida e não pode ser processada.'], 422); // Retorna erro se a data estiver vencida
        }

// Envia os dados para a plataforma de liquidação do banco (simulada internamente)
        $response = $this->enviarParaPlataformaLiquidadora($transfer);

// Verifica se a resposta da plataforma foi bem-sucedida
        if ($response['status'] == 'success') {
// Atualiza o status da transferência para "completed" após ser processada com sucesso pela plataforma
            $transfer->update(['status' => 'completed']);

// Retorna a transferência criada com sucesso e o status HTTP 201
            return response()->json($transfer, 201);
        } else {
// Em caso de erro na plataforma de liquidação, retorna a falha
            return response()->json(['error' => 'Erro ao processar a transferência na plataforma de liquidação.'], 500);
        }
    }


    /**
     * Retorna uma lista de transferências para o usuário autenticado.
     *
     * Este método retorna todas as transferências associadas ao usuário logado.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
// Obtém o usuário autenticado
        $user = auth()->user();

// Busca as transferências relacionadas ao usuário
        $transfers = Transfer::where('user_id', $user->id)->get();

// Retorna as transferências como JSON
        return response()->json($transfers);
    }

    /**
     * Exibe as transferências de um usuário com base no ID externo.
     *
     * @param  string  $external_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($external_id)
    {
        // Busca as transferências associadas ao ID externo fornecido
        $transfers = Transfer::where('external_id', $external_id)->get();

        // Verifica se não há transferências e retorna uma resposta apropriada
        if ($transfers->isEmpty()) {
            return response()->json(['message' => 'Nenhuma transferência encontrada para este usuário.'], 404);
        }

        // Retorna as transferências encontradas como JSON
        // Mesmo se houver apenas uma transferência, a resposta será um array
        return response()->json($transfers->toArray());
    }



    /**
     * Simula o envio dos dados para a plataforma de liquidação do banco.
     *
     * Este método simula a interação com a plataforma interna de liquidação do banco.
     *
     * @param \App\Models\Transfer $transferencia
     * @return array
     */
    private function enviarParaPlataformaLiquidadora($transferencia)
    {
// Aqui você pode adicionar a lógica interna que simula a liquidação
// Por exemplo, podemos simular que a liquidação foi bem-sucedida e retornar uma resposta simulada

// Simulação de resposta de sucesso
        $response = [
            'status' => 'success',
            'message' => 'Transferência processada com sucesso!',
        ];

        return $response;
    }
}
