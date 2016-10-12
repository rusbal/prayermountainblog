<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Mail\RaymondMailTest;
use Illuminate\Support\Facades\Mail;

class RaymondMailController extends Controller
{
    public function mail()
    {
        $data = array(
            'name' => 'Raymond S. Usbal',
            'message' => 'You\'ve got a project to work on!  Thank you Lord.',
            'subject' => 'A very beautiful Laravel email',
            'attachment' => storage_path('logs/laravel.log'),
        );

        Mail::to('raymond@philippinedev.com')
            ->cc('forrest@philippinedev.com')
            ->send(new RaymondMailTest($data));

        echo 'ok';
    }
}
