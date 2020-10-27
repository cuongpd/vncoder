<?php

namespace VnCoder\Models;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Mail;

class VnMailer
{
    protected $subject ;
    protected $config = [];

    // VnMailer::to('nampq9x@gmail.com')->subject('Xin Chào Nam')->send('mail' , ['info' => 'ok']);

    public function send($view, $data = [])
    {
        if (!$this->subject) {
            return false;
        }
        $config = $this->config;
        $subject = $this->subject;

        Mail::send($view, $data, function ($message) use ($config , $subject) {
            if (isset($config['from'])) {
                $message->from($config['from']['email'], $config['from']['name']);
            } else {
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            }

            if (isset($config['email_to'])) {
                foreach ($config['email_to'] as $item) {
                    $message->to($item['email'], $item['name']);
                }
            }
            if (isset($config['email_cc'])) {
                foreach ($config['email_cc'] as $item) {
                    $message->cc($item['email'], $item['name']);
                }
            }
            if (isset($config['email_bcc'])) {
                foreach ($config['email_bcc'] as $item) {
                    $message->bcc($item['email'], $item['name']);
                }
            }
            if (isset($config['reply_email'])) {
                $message->reply_to($config['reply_email']['email'], $config['reply_email']['name']);
            }
            if (isset($config['attachment'])) {
                foreach ($config['attachment'] as $item) {
                    $message->attach($item);
                }
            }
            $message->subject($subject)->priority(1);
        });
    }

    public function subject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public static function to($email, $name = '')
    {
        return (new static)->add($email, $name);
    }

    public function add($email, $name = '')
    {
        $this->config['email_to'][] = [ 'email' => $email , 'name' => $name];
        return $this;
    }

    public function cc($email, $name = '')
    {
        $this->config['email_cc'][] = [ 'email' => $email , 'name' => $name];
        return $this;
    }

    public function bcc($email, $name = '')
    {
        $this->config['email_bcc'][] = [ 'email' => $email , 'name' => $name];
        return $this;
    }

    public function reply($email, $name = '')
    {
        $this->config['reply_email'] = [ 'email' => $email , 'name' => $name];
        return $this;
    }

    public function attachment($file)
    {
        $this->config['attachment'][] = $file;
        return $this;
    }

    public function from($email, $name)
    {
        $this->config['from'] = ['email' => $email , 'name' => $name];
        return $this;
    }
}
