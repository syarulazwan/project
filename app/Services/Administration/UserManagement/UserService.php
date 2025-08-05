<?php

namespace App\Services\Administration\UserManagement;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserService
{
    public function getUser() {

        return User::select('id', 'name', 'email', 'status' , 'created_id', 'created_at', 'updated_at')->get();

    }

    public function getUserFilter($data)
    {
        $user = User::select(
                                'id', 
                                'name', 
                                'email', 
                                'status', 
                                'created_id', 
                                'created_at', 
                                'updated_at'
                            )
                ->where(array_filter($data))
                ->get();

        return $user;
    }

    public function CreateUser($data){
        
        $createdId = Session::get('role_id');

        $user = User::create([
                    'name' => $data['name_add'],
                    'email' => $data['email_add'],
                    'password'   => Hash::make($data['password_add']),
                    'status' => $data['status_add'],
                    'created_id' => $createdId,
                ]);


        return $user;
    }

    public function UpdateUser($data)
    {
        $user = User::find($data['id']);

        if (!$user) {
            throw new \Exception('User not found.');
        }

        $user->update([
            'name'     => $data['name_update'],
            'email'    => $data['email_update'],
            'status'   => $data['status_update'],
        ]);

        return $user;
    }

    public function deleteUserById($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            throw new \Exception('User not found.');
        }

        $user->delete();

        return true;
    }




}