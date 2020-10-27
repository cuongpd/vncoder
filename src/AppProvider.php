<?php

namespace VnCoder;

use Illuminate\Support\ServiceProvider;
use VnCoder\Console\VnCoderCommand;
use Illuminate\Contracts\Console\Kernel as ConsoleKernel;
use VnCoder\Console\CronjobSchedule;
use Illuminate\Contracts\Debug\ExceptionHandler;
use VnCoder\Exceptions\VnCoderHandler;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Pagination\Paginator;

defined('BASE_PATH')                || die('Please define BASE_PATH');

defined('APP_VERSION')                 ||  define('APP_VERSION', '1.0');
defined('BASE_URL')                 ||  define('BASE_URL', env('APP_URL'));
defined('TIME_NOW')                 ||  define('TIME_NOW', time());
defined('APP_PATH')                 ||  define('APP_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR);
defined('PUBLIC_PATH')              ||  define('PUBLIC_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
defined('ADMIN_PATH')               ||  define('ADMIN_PATH', APP_PATH . 'Admin' . DIRECTORY_SEPARATOR);
defined('COMMAND_PATH')             ||  define('COMMAND_PATH', ADMIN_PATH . 'Command' . DIRECTORY_SEPARATOR);
defined('CONTROLLER_PATH')          ||  define('CONTROLLER_PATH', APP_PATH . 'Controllers' . DIRECTORY_SEPARATOR);
defined('API_PATH')                 ||  define('API_PATH', CONTROLLER_PATH . 'Api' . DIRECTORY_SEPARATOR);

defined('VNCODER_DIR')              ||  define('VNCODER_DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR);
defined('VNCODER_CONFIG')           ||  define('VNCODER_CONFIG', VNCODER_DIR . 'config' . DIRECTORY_SEPARATOR);
defined('VNCODER_ASSETS')           ||  define('VNCODER_ASSETS', VNCODER_DIR . 'assets' . DIRECTORY_SEPARATOR);
defined('VNCODER_PATH')             ||  define('VNCODER_PATH', VNCODER_DIR . 'src' . DIRECTORY_SEPARATOR);
defined('BACKEND_PATH')             ||  define('BACKEND_PATH', VNCODER_PATH . 'Backend' . DIRECTORY_SEPARATOR);

class AppProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(VNCODER_PATH . 'Views', 'core');
        $this->loadViewsFrom(BACKEND_PATH . 'Views', 'backend');
        $this->loadViewsFrom(ADMIN_PATH   . 'Views', 'admin');
        $this->loadViewsFrom(APP_PATH     . 'Views', 'frontend');
        Paginator::defaultView('core::paginate.bootstrap');
    }

    public function register(): void
    {
        $this->helperRegister();
        if ($this->app->runningInConsole()) {
            $this->commands(VnCoderCommand::class);
            $this->app->singleton(ConsoleKernel::class, CronjobSchedule::class);
        }

        $this->app->register(\App\Providers\AppServiceProvider::class);
        $this->routerRegister();
        $this->serviceRegister();
    }

    protected function serviceRegister(): void
    {
        // Register Alias Class
        class_alias(\VnCoder\Models\VnCart::class, 'VnCart');
        class_alias(\VnCoder\Models\VnJobs::class, 'VnJobs');
        class_alias(\VnCoder\Models\VnUser::class, 'VnUser');
        class_alias(\VnCoder\Models\VnRole::class, 'VnRole');
        class_alias(\VnCoder\Models\VnPosts::class, 'VnPosts');
        class_alias(\VnCoder\Models\VnModel::class, 'VnModel');
        class_alias(\VnCoder\Models\VnConfig::class, 'VnConfig');
        class_alias(\VnCoder\Models\VnCommand::class, 'VnCommand');
        class_alias(\Barryvdh\Debugbar\Facade::class, 'Debugbar');

        $this->setConfig('queue');
        // Setup Debugbar Mode
        $debugbar = cookie('_debugbar');
        if ($debugbar === 'on') {
            $this->app->register(\Barryvdh\Debugbar\LumenServiceProvider::class);
            $this->setConfig('debugbar');
        }
        // Custom Log Data
        $this->app->singleton(ExceptionHandler::class, VnCoderHandler::class);
        // Session Loader
        $this->sessionLoader();
        // Mailer
        $this->mailerLoader();

        $this->app->register(\Laravel\Socialite\SocialiteServiceProvider::class);
        $this->setConfig('services');
    }

    protected function sessionLoader(): void
    {
        // Register Session Service
        $this->app->bind(\Illuminate\Session\SessionManager::class, static function ($app) {
            return $app->make('session');
        });
        $this->app->register(\Illuminate\Session\SessionServiceProvider::class);
        $this->setConfig('session');
        $this->app->middleware([\Illuminate\Session\Middleware\StartSession::class]);
    }

    protected function mailerLoader(): void
    {
        $this->app->register(\Illuminate\Mail\MailServiceProvider::class);
        $this->setConfig('mail');
        $this->app->alias('mail.manager', \Illuminate\Mail\MailManager::class);
        $this->app->alias('mail.manager', \Illuminate\Contracts\Mail\Factory::class);

        $this->app->alias('mailer', \Illuminate\Mail\Mailer::class);
        $this->app->alias('mailer', \Illuminate\Contracts\Mail\Mailer::class);
        $this->app->alias('mailer', \Illuminate\Contracts\Mail\MailQueue::class);
    }

    protected function setConfig($name)
    {
        $configNamePath = VNCODER_CONFIG . $name . '.php';
        if (file_exists($configNamePath)) {
            try {
                $this->app->make('config')->set($name, require VNCODER_CONFIG . $name . '.php');
            } catch (BindingResolutionException $e) {
            }
        }
    }

    protected function helperRegister()
    {
        if (file_exists(APP_PATH.'helper.php')) {
            require APP_PATH . 'helper.php';
        }
    }

    protected function routerRegister()
    {
        $this->app->routeMiddleware([
            'login' => \VnCoder\Middleware\LoginMiddleware::class,
            'auth' => \VnCoder\Middleware\AuthMiddleware::class,
        ]);

        $this->app->router->group(['namespace' => 'VnCoder\Controllers'], static function ($r) {
            // Auth
            $r->get('login.html', [ 'as' => 'auth.login', 'uses' => 'AuthController@Login_Form']);
            $r->get('register.html', [ 'as' => 'auth.register', 'uses' => 'AuthController@Register_Form']);
            $r->get('reset-password.html', [ 'as' => 'auth.reset', 'uses' => 'AuthController@Reset_Password_Form']);
            $r->get('request/{token:[a-f0-9]+}.html', [ 'as' => 'auth.request','uses' => 'AuthController@Reset_Password_Request']);
            $r->get('logout.html', [ 'as' => 'auth.logout', 'uses' => 'AuthController@Logout_Action']);
            $r->get('active/{token:[a-f0-9]+}.html', [ 'as' => 'auth.active','uses' => 'AuthController@Active_Action']);
            $r->get('re-active/{token:[a-f0-9]+}.html', [ 'as' => 'auth.re-active','uses' => 'AuthController@ReActive_Action']);
            // Auth Post
            $r->post('login.html', 'AuthController@Login_Submit');
            $r->post('register.html', 'AuthController@Register_Submit');
            $r->post('reset-password.html', 'AuthController@Reset_Password_Submit');
            // Auth Provider
            $r->get('auth/{provider:[a-z]+}', [ 'as' => 'auth.provider', 'uses' => 'AuthController@Provider_Auth_Action']);
            $r->get('auth/{provider:[a-z]+}/callback', [ 'as' => 'auth.callback','uses' => 'AuthController@Provider_Callback_Action']);
            // Default
            $r->get('core/{filename:[a-zA-Z0-9-./]+}', [ 'as' => 'core-assets','uses' => 'LoaderController@AssetsLoader'           ]);
            $r->get('api/v1', [ 'as' => 'api-url','uses' => 'LoaderController@Page404']);
            $r->get('404.html', [ 'as' => '404','uses' => 'LoaderController@Page404']);
            $r->get('api/media-loader', [ 'as' => 'media-loader','uses' => 'LoaderController@MediaLoader']);
            $r->get('api/vn-helper.html', [ 'as' => 'swagger-helper','uses' => 'LoaderController@SwaggerHelper']);
            $r->get('api/vn-swagger-data.json', [ 'as' => 'swagger-api','uses' => 'LoaderController@SwaggerData']);
            // API
            $r->get('api/v1/{controller:[a-z]+}[/{action:[a-z0-9-]+}]', 'LoaderController@getAPI');
            $r->post('api/v1/{controller:[a-z]+}[/{action:[a-z0-9-]+}]', 'LoaderController@postAPI');
        });

        $this->app->router->group(['as' => 'backend', 'prefix' => 'backend', 'middleware' => 'auth'], static function ($router) {
            $router->get('/', [ 'as' => 'main', 'uses' => '\\App\Admin\Controllers\MainController@Main_Action']);
            $router->get('{controller:[a-z-]+}[/{action:[a-z0-9-]+}]', ['as' => 'route', 'uses' => '\\VnCoder\Backend\Controllers\RouteController@get']);
            $router->post('{controller:[a-z]+}[/{action:[a-z0-9-]+}]', '\\VnCoder\Backend\Controllers\RouteController@post');
        });

        $this->app->router->group([ 'namespace' => 'App\Controllers'], static function ($router) {
            $router->get('/', [ 'as' => 'home', 'uses' => 'HomeController@Main_Action']);
            if (file_exists(APP_PATH . 'route.php')) {
                require APP_PATH . 'route.php';
            }
        });
    }
}
