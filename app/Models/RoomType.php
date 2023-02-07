<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'stock',
    ];


    public function rooms()
    {   
        return $this->hasMany(Room::class);
    }
   


   public function rates()
    {   
        return $this->hasMany(Rate::class);
    }
}