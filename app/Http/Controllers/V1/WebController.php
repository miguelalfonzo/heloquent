<?php
namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Booking;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use App\Models\Rate;


class WebController extends Controller
{   
    use RestController;

    protected $user;

    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');

        if($token != '')
           
            $this->user = JWTAuth::parseToken()->authenticate();

           
    }
    

    protected function search(Request $request)
    {
        
         $data = $request->only('check_in', 'check_out');


         $validator = Validator::make($data, [

            'check_in' => 'required|date',
            'check_out' => 'required|date'
            
        ]);
       

        if ($validator->fails()) {

           return response()->json($this->setRpta('warning' ,'validations failed', $this->msgValidator($validator)),Response::HTTP_BAD_REQUEST);
        }

        //return Booking::with('reservation')->get();

        $booking = new Booking;
     
        $room = new Room;
        
        $rate = new Rate;

       // $re = new Reservation;

        return  $booking->getAvailabilityBooking('2022-01-01','2022-01-01');

        //return $rate->especialRate('2023-01-24','2023-01-25');
        
        //return Booking::with('room')->get();

       //return Room::with('roomType')->get();
        

    }
   
}