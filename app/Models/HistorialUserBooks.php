<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialUserBooks extends Model
{
    use HasFactory;

    protected $fillable =[
        'used_by',
        'book_id',
    ];

    public function bookUsed(){
        return $this->belongsTo(Book::class,'book_id');
    }

    public function usedBy(){
        return $this->belongsTo(User::class,'used_by');
    }

}
