<?php
   
namespace App\Http\Controllers\Auth;
   
use App\Services\LoginService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
   
class LoginController extends Controller
{
   
    public function __construct(private LoginService $loginService)
    {
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function weblogin(LoginRequest $request): JsonResponse
    {
        if($this->loginService->loginByEmail( $request->email,$request->password)){
            return $this->sendSuccess('User logged in successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

     /**
     * Login web
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apilogin(LoginRequest $request): JsonResponse
    {
        if($this->loginService->loginByEmail( $request->email,$request->password)){
            $user = Auth::user(); 
            $data['token'] =  $user->createToken('token')->plainTextToken; 
            $data['name'] =  $user->name;
   
            return $this->sendResponse($data, 'User logged in successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
  
}