<?php

namespace App\Http\Controllers\API\V1;

use Auth;
use Validator;
use App\Models\User;
use App\Traits\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Traits\Api\Validators\ApiValidator;
use App\Services\ApiServices\UtilsApiServices;
use App\DAO\ApiDao\AuthApiDao;


class AuthController extends Controller
{
    use Utils, ApiValidator;
    protected $utils_api_services, $authApiDao;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->utils_api_services = new UtilsApiServices();
        $this->authApiDao = new AuthApiDao();
    }
    

    /**
     * Register user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = $this->registerDataValidate($request);

        if ($validator->fails()) {
            $response = array(
                'success' => false,
                'title' => 'Register',
                'message' => $validator->errors(),
            );
            return response()->json($response, 400);
        }

        $user = $this->authApiDao->userDataSave($request);

        $token = Auth::login($user);
        $response = array(
            'success' => true,
            'title' => 'Register',
            'message' => 'User successfully registered',
            'data' => [
                'user' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]
        );
        return response()->json($response, 200);
    }

    /**
     * login user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $validator = $this->usernamePasswordValidate($request);
    
        if ($validator->fails()) {
            $response = array(
                'status' => false,
                'message' => $validator->errors(),
            );
            return response()->json($response, 422);
        }


        if (!$token = auth()->attempt($validator->validated())) {

            $response = array(
                'status' => false,
                'message' => 'Unauthorized User',
                "payload" => []
            );
            return response()->json($response, 401);
        }

        $userInfo = auth()->user();

        $payload = array(
            'parent_user_id' => $userInfo->id,
            'username' => $userInfo->user_name,
            'password' => $userInfo->password,
            'authorization' => [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 6000000000000
            ]
        );
        
        if($userInfo){
            $response = $this->utils_api_services->getOkResponse($payload);
        }else{
            $response = $this->utils_api_services->getNotFoundResponse();
        }
        return response()->json($response);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile() {
      
        $userInfo = auth()->user();
        
        $payload = array(
            'id' => (!empty($userInfo->id) ? $userInfo->id : ''),
            'name' => (!empty($userInfo->name) ? $userInfo->name : ''),
            'email' => (!empty($userInfo->email) ? $userInfo->email : ''),
            'user_name' => (!empty($userInfo->user_name) ? $userInfo->user_name : ''),
        );
        
        if($userInfo){
            $response = $this->utils_api_services->getOkResponse($payload);
        }else{
            $response = $this->utils_api_services->getNotFoundResponse();
        }
        return response()->json($response);
    }

       /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 6000000000000,
            'user' => auth()->user()
        ]);
    }

    public function logout(){
        auth()->logout();

        $response = array(
            'success' => true,
            'title' => 'Logout',
            'message' => 'User successfully logged out.'
        );
        return response()->json($response, 401);
    }

    
    public function reset_pass_step_email(Request $request){
        $payload = array();
        $email = $request->email;

        $validator = $this->resetPassEmailValidate($request);
        
        if ($validator->fails()) {
            $response = array(
                'status' => false,
                'message' => $validator->errors(),
            );
            return response()->json($response, 422);
        }

        if ($email) {
            $query = User::where('email', $email)->where('status', 1)->first();
            
            
            $payload = array(
                'email' => (!empty($query->email) ? $query->email : ''),
            );
            if($query){
                $response = $this->utils_api_services->getOkResponse($payload);
            }else{
                $response = $this->utils_api_services->getNotFoundResponse();
            }     
            return response()->json($response);
        }
    }

    
    public function reset_pass_step_new(Request $request){
        $payloadData = array();
        $email = $request->email;
        $new_password = $request->password;
        
        $validator = $this->resetEmailPasswordValidate($request);
        
        if ($validator->fails()) {
            $response = array(
                'status' => false,
                'message' => $validator->errors(),
            );
            return response()->json($response, 422);
        }

        if ($new_password) {
            
            $user = User::where('email', $email)->first();
            if(!empty($user)){
                $user->password = Hash::make($new_password);
                $user->save();

                $payload = array(
                    'new_password' => (!empty($new_password) ? $new_password : ''),
                );
                $response = $this->utils_api_services->getOkResponse($payload);
            }else{
                $response = $this->utils_api_services->getNotFoundResponse();
            }    
            return response()->json($response);
        }
    }

}
