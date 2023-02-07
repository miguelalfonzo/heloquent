<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'stock',
    ];



      public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function baseRate(){

       return $this->where('hierarchy',0)->get();
    }


    public function especialRate($from,$to){

       return $this->where(function($query) use($from,$to){

        $query->whereBetween('from', [$from, $to])
              ->orWhereBetween('to', [$from, $to]);

    
        })->orWhere(function($query) use ($from, $to) {

            $query->where('from', '<', $from)
                ->where('to', '>', $to);

        })->orderBy('hierarchy', 'desc')->first();


    }


}

