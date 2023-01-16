<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotifyController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function notifyMe(book $book)
    {
        $user = auth()->user()->id;
        $hasNotifcation = Notification::where('book_id',$book->id)->where('user_id',$user)->first();
        if($hasNotifcation) return;
        $request['book_id'] = $book->id;
        $request['user_id'] = $user;
        return Notification::create($request);
    }

    public function forgetBook(Book $book){
        return Notification::where('book_id',$book->id)->where('user_id',auth()->user()->id)->delete();
    }

}
