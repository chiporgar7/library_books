<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'created_by',
    ];

    public static function create(array $attributes = []){
        $attributes['created_by'] = auth()->user()->id;

        return static::query()->create($attributes);
    }


    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
