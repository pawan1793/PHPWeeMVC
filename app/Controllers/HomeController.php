<?php

namespace App\Controllers;

use Core\Controller;
use Core\Log;
use App\Models\User;

class HomeController extends Controller {
    public function index() {
        $users = User::all();
        Log::info('message');
        $this->view('home', ['users' => $users]);
    }
}