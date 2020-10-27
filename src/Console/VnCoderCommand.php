<?php

namespace VnCoder\Console;

use Illuminate\Console\Command;

class VnCoderCommand extends Command
{
    protected $signature = 'run {run-command} {action?}';
    protected $description = "Using for VnCoder CMS.\n\t\t      Query : php artisan run {run-command} {action?}";

    public function handle()
    {
        if (PHP_OS_FAMILY === 'Windows') {
            system('cls');
        } else {
            system('clear');
        }

        $command = $this->argument('run-command');
        if (!$command) {
            die("Error: Permission denied\n");
        }

        $action = $this->argument('action');
        if (!$action) {
            $action = 'index';
        }
        $commandController = 'App\\Admin\\Command\\' . ucfirst($command) . 'Command';

        if (class_exists($commandController)) {
            $commandClass = app()->make($commandController);
            if (!method_exists($commandClass, 'print')) {
                echo "Please extends \VnCommand to call : $commandClass \n";
                exit();
            }

            $method = ucfirst($action). '_Action';
            if (!method_exists($commandClass, $method)) {
                echo "Method $method not active in class $commandController \n";
                exit();
            }
            return $commandClass->$method();
        }
        // Create Command
        $command_file = COMMAND_PATH. ucfirst($command). 'Command.php';
        $command_code = <<<EOF
<?php

namespace App\Admin\Command;
use VnCommand;

class __CONTROLLER__ extends VnCommand{

    public function __METHOD__(): void
    {

    }
}

EOF;
        if (!file_exists($command_file)) {
            $command_code = str_replace(['__CONTROLLER__', '__METHOD__'], [ucfirst($command) . 'Command', ucfirst($action) . '_Action'], $command_code);
            file_put_contents($command_file, $command_code);
            echo 'Command created in ' .$command_file;
        } else {
            echo 'Please check file ' .$command_file;
        }
        exit();
    }
}
