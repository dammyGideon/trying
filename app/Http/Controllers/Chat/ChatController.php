<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Repositories\Chat\ChatRepository;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    //

    public function messages(Request $request, ChatRepository $chatRepository){
        return $chatRepository($request);
    }
}
