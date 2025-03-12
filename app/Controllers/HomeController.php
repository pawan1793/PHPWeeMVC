<?php

namespace App\Controllers;

use Core\Controller;
use Core\Log;
use App\Models\User;
use Core\Mail;
use Core\Blade;


class HomeController extends Controller {
    public function index() {
        //dd(User::find(1));
        $appName = env('APP_NAME');
        return Blade::render('home', ['appName' => $appName]);
    }

    public function testMail(){
       
       
       $a = Mail::send('emails.welcome', ['name' => 'Pawan Thalia'], function($mail) {
            $mail->to('pawanmore38@gmail.com', 'Pawan More')
                ->subject('Welcome to Our Platform');
        });
        dd($a);
    }
}