<?php

namespace App\Services;

interface UserServiceInterface
{
    public function getAllUsers();
    public function findUserById($id);
    public function createUser(array $data);
    public function updateUser($id, array $data);
    public function deleteUser($id);
}
