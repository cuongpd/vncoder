<?php

namespace VnCoder\Jobs;

use VnCoder\Models\VnJobs;
use VnCoder\Models\VnMailer;

class SendEmailActiveUserJob extends VnJobs
{
    protected $name ;
    protected $email ;
    protected $token;

    public function __construct($name, $email, $token)
    {
        $this->name = $name;
        $this->email = $email;
        $this->token = $token;
    }

    public function handle()
    {
        if ($this->email) {
            $data = ['name' => $this->name, 'email' => $this->email, 'token' => $this->token];
            VnMailer::to($this->email)->subject('Kích hoạt tài khoản trên hệ thống ' . getConfig('name'))->send('core::email.register', $data);
        }
    }
}
