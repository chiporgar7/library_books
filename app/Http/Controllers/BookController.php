<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Jobs\ProcessNotify;
use App\Models\book as BookModel;
use App\Models\User;
use App\Repositories\Utils\Search;
use Illuminate\Http\Request;

class BookController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Status
     * @param  UserModel
     */

    public function returnBook(BookModel $book, User $user){
        if($user->id != $book->user_id ) return;
        $book->isAvailable = 'yes';
        $book->used_by = null;
        $book->save();
        ProcessNotify::dispatch($book); //notificar a los usuarios que su libro ya está disponible
    }


    /**
     * Display a listing of the resource.
     *
     * @return ParamIDBook
     * @param  Book
     */

     public function takeBook(BookModel $book){
        //validacion de ROL_ESTUDIANTE_MIEMBRO
        if($book->isAvailable == 'no')  return;
        return   $book->update([
         'used_by' => auth()->user()->id,
         'isAvailable' => 'no'
        ]);
     }  




    /**
     * Display a listing of the resource.
     *
     * @return Array []
     * @param  Request
     */

    public function searchBooks (Request $request){
        return Search::searchBooks($request);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        // $variabeName =  config('twilio.SID');
        return BookModel::paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
       return BookModel::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BookModel $book)
    {
        return $book->load('crated_by','used_by','updatepd_by','category_id');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, BookModel $book)
    {   
        $request['updated_by'] = auth()->user()->id;
        return $book->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function destroy(BookModel $book)
    {
        return $book->delete();
    }
}
