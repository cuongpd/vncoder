<?php

namespace VnCoder\Models;

class VnCommand
{
    public function __construct()
    {
        ob_start();
        ob_implicit_flush(true);
        ob_end_flush();
    }

    public function print($data = null, $die = false): void
    {
        if (is_array($data) || is_object($data)) {
            print_r($data);
        } else {
            echo $data;
        }
        echo "\n";
        if ($die) {
            die;
        }
    }

    public function Index_Action()
    {
        $this->print('OK');
    }

    public function exec($command): void
    {
        $output = exec($command);
        $this->print($output);
    }

    public function showNotify($message = ''): void
    {
        $this->exec("osascript -e 'display notification \"$message\" with title \"VnCoder Notify\"'");
    }
}
