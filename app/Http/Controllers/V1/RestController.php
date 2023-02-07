<?php



namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


trait RestController { 
    
  
  
    public function setRpta($status,$description,$data){

        return array("status"=>$status,"description"=>$description,"data"=>$data);

    }

}