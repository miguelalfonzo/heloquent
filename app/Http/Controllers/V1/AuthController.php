<?php
namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
   use RestController;

    public function register(Request $request)
    {
       
        $data = $request->only('name', 'email', 'password');
     
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50',
        ]);
      
       if ($validator->fails()) {

          
      		return response()->json($this->setRpta('warning' ,'validations failed', $this->msgValidator($validator)),Response::HTTP_BAD_REQUEST);
         	
      
        }
     
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
       
        $credentials = $request->only('email', 'password');
       	
       	$data = [

       		'token' => JWTAuth::attempt($credentials),
            'user' => $user
       	];



        return response()->json($this->setRpta('ok' ,'user created', $data),Response::HTTP_OK);

    }
  
    public function authenticate(Request $request)
    {
        
        
     
        try {


        	$credentials = $request->only('email', 'password');
       
	        $validator = Validator::make($credentials, [
	            'email' => 'required|email',
	            'password' => 'required|string|min:6|max:50'
	        ]);
	       
	        if ($validator->fails()) {

	           return response()->json($this->setRpta('warning' ,'validations failed', $this->msgValidator($validator)),Response::HTTP_BAD_REQUEST);
	        }


            if (!$token = JWTAuth::attempt($credentials)) {
               
                 return response()->json($this->setRpta('error' ,'login failed', []),Response::HTTP_BAD_REQUEST);

            }
        } catch (JWTException $e) {
           
           return response()->json($this->setRpta('error' ,$e->getMessage(), []),Response::HTTP_BAD_REQUEST);
        }
      
	     
	     $data = [

	     	  'token' => $token,
              'user' => Auth::user()
	     ];


         return response()->json($this->setRpta('ok' ,'user authenticate', $data),Response::HTTP_OK);
    }
    
    public function logout(Request $request)
    {
       
       
        try {
           	
           	 $validator = Validator::make($request->only('token'), [
            	'token' => 'required|string'
	        ]);
	     

	        if ($validator->fails()) {

	             return response()->json($this->setRpta('warning' ,'validations failed', $this->msgValidator($validator)),Response::HTTP_BAD_REQUEST);
	        }



             JWTAuth::invalidate($request->token);
            
             return response()->json($this->setRpta('ok' ,'user disconnected', []),Response::HTTP_OK);

        } catch (JWTException $e) {
          
             return response()->json($this->setRpta('error' ,$e->getMessage(), []),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
   
    public function getUser(Request $request)
    {	




       	
           $validator = Validator::make($request->only('token'), [
            	'token' => 'required|string'
	       ]);
	     

	       if ($validator->fails()) {

	             return response()->json($this->setRpta('warning' ,'validations failed', $this->msgValidator($validator)),Response::HTTP_BAD_REQUEST);
	       }
       
     
       
     

        $user = JWTAuth::authenticate($request->token);
      	
      	
        if(!$user){

        	return response()->json($this->setRpta('error' ,'invalid token / token expired', []),Response::HTTP_BAD_REQUEST);
        }
       	
       	


         return response()->json($this->setRpta('ok' ,'get user data', $user),Response::HTTP_OK);

       
    }
}