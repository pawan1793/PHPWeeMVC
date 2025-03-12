# PHPWeeMVC
A lightweight PHP micro-framework for building basic web applications.

## **📌 Features**  
✅ **Eloquent ORM** 
✅ **Blade Templating**  
✅ **Mail Support**  
✅ **Task Scheduling**
✅ **.env Support**  
✅ **MVC Architecture**  
✅ **Error Logging**  

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


### **📌 Setup a Cron Job for Task Scheduling**  

To enable automatic task execution, follow these steps to set up a cron job for **PHPWeeMVC**:  

---

### ** Step 1: Open the Crontab Editor**  
Run the following command to edit your cron jobs:  
```sh
crontab -e
```

---

### ** Step 2: Add the Cron Job**  
At the bottom of the file, add this line to execute `cron.php` every minute:  
```sh
* * * * * php /var/www/html/myapp/cron.php >> /dev/null 2>&1
```
This ensures that the scheduler runs every minute without printing output.

---

### ** Step 3: Restart the Cron Service**  
After saving the crontab, restart the **cron service** to apply the changes:  
```sh
sudo systemctl restart cron
```

---

### ** Step 4: Verify if Cron is Running**  
To check if your cron job is working, run:  
```sh
crontab -l
```


## License
MIT License

## Contributing
Feel free to submit pull requests or open issues on GitHub.

## Contact
For support, reach out via GitHub Issues.

