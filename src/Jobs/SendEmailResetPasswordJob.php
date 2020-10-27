<?php

namespace VnCoder\Jobs;

use VnCoder\Models\VnMailer;

class SendEmailResetPasswordJob extends \VnJobs
{
    protected $email ;
    protected $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function handle()
    {
        if ($this->email) {
            $data = ['email' => $this->email, 'password' => $this->password];
            VnMailer::to($this->email)->subject('Thiết lập mật khẩu mới - ' . getConfig('name'))->send('core::email.password-reset', $data);
        }
    }
}
