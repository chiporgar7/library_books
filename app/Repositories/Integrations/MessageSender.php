<?php

namespace App\Repositories\Integrations;

use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class MessageSender
{ 
    public static function dispatchNotify($book){
        $users = Notification::with(['user','book'])->where('book_id',$book->id)->where('dispatched','no')->get();
        Log::info($users);
        $client = new Client(config('twilio.SID'),config('twilio.TOKEN'));
        foreach($users as $user){
            try{
                $client->messages->create(
                    $user->user->phone,
                    [
                        'from' => config('twilio.PHONE'),
                        'body' => 'Medio:'.$user->medio.' '.$user->user->name . ' El Libro '.$user->book->name_book  . ' Ya se encuentra disponible  en la libreria. '
                    ]
                );
            }catch(\Exception $e){
                Log::info($e);
                Log::info('Error al notificar al usuario '.$user->user->email.' Porque su telefono tiene un formato incorrecto '.$user->user->phone);
            }
        }
    }
}