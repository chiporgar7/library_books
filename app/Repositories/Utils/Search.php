<?php
namespace App\Repositories\Utils;

use App\Models\book;

class Search
{
    public static function searchBooks($request){
        $search = $request['search'];
        return book::with(['created_by','updated_by','used_by'])
        ->where(function ($query) use ($search) {
            foreach (explode(' ', $search) as $bus) {
                $query->orwhere('name_book', 'like', '%' . $bus . '%')
                    ->orwhere('author', 'like', '%' . $bus . '%')
                    ->orwhere('year_publish', 'like', '%' . $bus . '%')
                    ->orwhere('isbn', 'like', '%' . $bus . '%');
            }
        })
        ->orderBy('id', 'desc')
        ->paginate(10);
    }    
}