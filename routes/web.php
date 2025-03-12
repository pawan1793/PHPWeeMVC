<?php

use Core\Router;

Router::get('', 'HomeController@index');
Router::get('test-mail', 'HomeController@testMail');

