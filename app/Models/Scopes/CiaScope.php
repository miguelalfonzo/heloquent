<?php
 
namespace App\Models\Scopes;
 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;


class CiaScope implements Scope
{
   
    public function apply(Builder $builder, Model $model)
    {
         $builder->where('hotel_id', auth()->user()->hotel_id);
    }
}