# PHPWeeMVC
A lightweight PHP micro-framework for building basic web applications.

## Features
- Simple and lightweight
- MVC architecture
- Routing system
- Blade-like templating engine
- Database ORM with query builder
- Logging system

## Installation
To install PHPWeeMVC via Composer, run:
```sh
composer require pmore/phpweemvc
```

Or create a new project:
```sh
composer create-project pmore/phpweemvc myapp
```

## Folder Structure
```
myapp/
│── public/
│   ├── index.php  # Front Controller
│── app/
│   ├── Controllers/
│   │   ├── HomeController.php
│   ├── Models/
│   │   ├── User.php
│   ├── Views/
│   │   ├── home.blade.php
│── core/
│   ├── App.php
│   ├── Router.php
│   ├── Controller.php
│   ├── Model.php
│   ├── Blade.php
│   ├── Middleware.php
│── routes/
│   ├── web.php
│── config/
│   ├── database.php
│── storage/
│   ├── logs/
│── .htaccess
│── composer.json
│── README.md
```

## Usage
### Create a Controller
Create a new controller inside `app/Controllers/`:

```php
namespace App\Controllers;
use Core\Controller;

class HomeController extends Controller {
    public function index() {
        return "Hello World!";
    }
}
```

### Define a Route
Define your routes inside `routes/web.php`:

```php
use Core\Router;
use App\Controllers\HomeController;

Router::get('/', [HomeController::class, 'index']);
```

### Running the Application
Use PHP’s built-in server to run your app:
```sh
php -S localhost:8000 -t public
```

## Database Configuration
Edit `config/database.php` with your database settings:
```php
return [
    'host' => '127.0.0.1',
    'database' => 'phpmvc',
    'username' => 'root',
    'password' => '',
];
```

## Logging
You can log messages using:
```php
use Core\Log;
Log::info('This is an info log');
Log::error('An error occurred');
```

## License
MIT License

## Contributing
Feel free to submit pull requests or open issues on GitHub.

## Contact
For support, reach out via GitHub Issues.

