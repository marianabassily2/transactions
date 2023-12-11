<?php

namespace App\Services; 

use Illuminate\Support\Facades\Auth;

class LoginService
{
   public function loginByEmail($email,$password)
   {
        return Auth::attempt(['email' => $email, 'password' => $password]);
   }

}
