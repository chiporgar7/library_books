<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book extends Model
{
    use HasFactory;

    protected $fillable = [
        'author',
        'name_book',
        'isbn',
        'year_publish',
        'number_pages',
        'sku',
        'editorial',
        'used_by',
        'created_by',
        'updated_by',
        'category_id'
    ];

    public static function create(array $attributes = []){
        $user = auth()->user()->id;
        $attributes['created_by'] = $user;
        $attributes['updated_by'] = $user;
        return static::query()->create($attributes);
    }

    public function created_by() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function used_by(){
        return $this->belongsTo(User::class,'used_by');
    }

    public function updated_by(){
        return $this->belongsTo(User::class,'updated_by');
    }

    public function category_id(){
        return $this->belongsTo(Category::class,'category_id');
    }


    //has many

    public function historialUsers(){
        return $this->hasMany(HistorialUserBooks::class);
    }
}
