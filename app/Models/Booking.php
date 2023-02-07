<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\CiaScope;
use DB;

class Booking  extends Model
{
    use HasFactory;

 	
 	
    protected $table='bookings';



   

    protected $fillable = [
        'name'
       
    ];

   
    


    
   

 
    public function getAvailabilityBooking($from,$to){

        $rooms = Room::all();

        $now = Carbon::now()->format('Y-m-d');

        $data = [];

        foreach($rooms as $values){

                $count = 0;

                $availability = $this->select('reserve_date_from','reserve_date_to')->where('room_id', $values->id)

                     ->where(function($query) use($now){

                        $query->where('reserve_date_from', '>=',$now)->orWhere(function($query) use($now){


                             $query->where('reserve_date_from', '<=', $now)
                                    ->where('reserve_date_to', '>=', $now);

                        });

                     })
                   ->get();

            foreach ($availability as $value) {

                if($value->reserve_date_from>$from && $value->reserve_date_to<$to){

                    $count++;
                }
            
            }


            if($count == 0 ){

                $data[] = $values->id;
            }


        }


        return  RoomType::withCount(['rooms' => function ($query) use ($data) {

                $query->whereIn('id',$data);

            }])->with('rates')->especialRate('2023-01-21','2023-01-21')->get();

        
     


        
    }


   
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

     public function room()
    {
        return $this->belongsTo(Room::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ActiveScope);

         static::addGlobalScope(new CiaScope);
    }

   

}
