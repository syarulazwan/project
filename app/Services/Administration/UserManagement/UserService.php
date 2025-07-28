<?php

namespace App\Services\Administration\UserManagement;
use App\Models\User;

class UserService
{
    public function getUser() {

        return User::select('id', 'name', 'email', 'status' , 'created_id', 'created_at', 'updated_at')->get();

    }


}