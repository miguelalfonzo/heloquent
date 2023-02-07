<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\CiaScope;

class UserType  extends Model
{
    use HasFactory;

 
    protected $fillable = [
        'name'
       
    ];

   

   
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ActiveScope);

         static::addGlobalScope(new CiaScope);
    }





}
