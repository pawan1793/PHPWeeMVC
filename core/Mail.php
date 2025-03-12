<?php

namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Core\Blade;

class Mail {
    protected $mail;
    protected $data = [];
    protected $view;

    public function __construct() {
        $this->mail = new PHPMailer(true);
     
     
        // SMTP Configuration
        $this->mail->isSMTP();
        $this->mail->Host       = env('MAIL_HOST') ?: 'smtp.example.com';
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = env('MAIL_USERNAME') ?: 'user@example.com';
        $this->mail->Password   = env('MAIL_PASSWORD') ?: 'secret';
        $this->mail->SMTPSecure = env('MAIL_ENCRYPTION') ?: PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = env('MAIL_PORT') ?: 587;
        $this->mail->setFrom(env('MAIL_FROM') ?: 'no-reply@example.com', 'My App');
    }

    public static function send($view, $data, $callback) {
        $instance = new static();
        $instance->view = $view;
        $instance->data = $data;

        call_user_func($callback, $instance);
        return $instance->sendMail();
    }

    public function to($email, $name = '') {
        $this->mail->addAddress($email, $name);
        return $this;
    }

    public function subject($subject) {
        $this->mail->Subject = $subject;
        return $this;
    }

    public function sendMail() {

        $blade = new Blade(__DIR__ . '/../app/Views', __DIR__ . '/../storage/cache');
        $this->mail->Body = $blade->run($this->view, $this->data);
        $this->mail->isHTML(true);
        return $this->mail->send();

    }
}
