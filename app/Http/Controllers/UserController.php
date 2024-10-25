<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserServiceInterface;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 * @author Vinícius Siqueira
 * @link https://github.com/ViniciusSCS
 * @date 2024-08-23 21:48:54
 * @copyright UniEVANGÉLICA
 */
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Exiba uma listagem do recurso.
     */
    public function index()
    {
        $users = $this->userService->getAllUsers();

        return [
            'status' => 200,
            'message' => 'Usuários encontrados!!',
            'users' => $users
        ];
    }

    /**
     * Mostrar o usuário atualmente autenticado.
     */
    public function me()
    {
        $user = Auth::user();

        return [
            'status' => 200,
            'message' => 'Usuário logado!',
            "usuario" => $user
        ];
    }

    /**
     * Armazene um recurso recém-criado no armazenamento.
     */
    public function store(UserCreateRequest $request)
{
    $data = $request->validated();
    
    // Confira os dados recebidos
    // dd($data);

    $data['password'] = bcrypt($data['password']); // Criptografa a senha manualmente
    $user = $this->userService->createUser($data);

    return response()->json([
        'status' => 200,
        'message' => 'Usuário cadastrado com sucesso!',
        'user' => $user
    ]);
}


    /**
     * Exiba o recurso especificado.
     */
    public function show(string $id)
    {
        $user = $this->userService->findUserById($id);

        if (!$user) {
            return [
                'status' => 404,
                'message' => 'Usuário não encontrado! Que triste!',
            ];
        }

        return [
            'status' => 200,
            'message' => 'Usuário encontrado com sucesso!!',
            'user' => $user
        ];
    }

    /**
     * Atualize o recurso especificado no armazenamento.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $user = $this->userService->updateUser($id, $data);

        if (!$user) {
            return [
                'status' => 404,
                'message' => 'Usuário não encontrado! Que triste!',
            ];
        }

        return [
            'status' => 200,
            'message' => 'Usuário atualizado com sucesso!!',
            'user' => $user
        ];
    }

    /**
     * Remova o recurso especificado do armazenamento.
     */
    public function destroy(string $id)
    {
        $deleted = $this->userService->deleteUser($id);

        if (!$deleted) {
            return [
                'status' => 404,
                'message' => 'Usuário não encontrado! Que triste!',
            ];
        }

        return [
            'status' => 200,
            'message' => 'Usuário deletado com sucesso!!'
        ];
    }
}
