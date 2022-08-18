<?php

namespace App\Repositories\Chat;

use App\Events\Messages;
use App\Models\message;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class ChatRepository.
 */
class ChatRepository extends BaseRepository
{

    public function model()
    {
    return message::class;

    }

    public function chat($details){
        $auth=auth()->user()->email;
        event(new Messages($details->input($auth), $details->input('message')));
    }
}
