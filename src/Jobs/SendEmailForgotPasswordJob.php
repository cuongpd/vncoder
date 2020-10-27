<?php

namespace VnCoder\Jobs;

use VnCoder\Models\VnJobs;
use VnCoder\Models\VnMailer;

class SendEmailForgotPasswordJob extends VnJobs
{
    protected $email ;
    protected $token;

    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    public function handle()
    {
        if ($this->email) {
            $data = ['email' => $this->email, 'token' => $this->token];
            VnMailer::to($this->email)->subject('Khôi phục mật khẩu - ' . getConfig('name'))->send('core::email.forgot-password', $data);
        }
    }
}
