<?php

namespace App\Services;

use App\Models\User;

class UserService implements UserServiceInterface
{
    public function getAllUsers()
    {
        return User::select('id', 'name', 'email', 'created_at')->paginate(10);
    }

    public function findUserById($id)
    {
        return User::find($id);
    }

    public function createUser(array $data)
    {
        $data['password'] = bcrypt($data['password']);  // Centralizando a lógica de senha aqui
        return User::create($data);
    }

    public function updateUser($id, array $data)
    {
        $user = User::find($id);
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        return $user ? $user->update($data) : null;
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        return $user ? $user->delete() : null;
    }
}
