<?php

namespace VnCoder\Controllers;

use VnCoder\Models\VnMedia;

class LoaderController
{
    public function __construct()
    {
        debugbar_off();
    }

    // API Loader
    public function getAPI($controller, $action = 'index')
    {
        return $this->ApiLoader($controller, $action);
    }

    public function postAPI($controller, $action = 'index')
    {
        return $this->ApiLoader($controller, $action);
    }

    protected function ApiLoader($controller, $action = 'index')
    {
        if (env('API_CHECK_TOKEN')) {
            if (request()->header('x-csrf-token') !== csrf_token()) {
                return response()->json([
                    'status'    => -1 ,
                    'message'     => 'Nothing to do!',
                ], 500, [], JSON_PRETTY_PRINT);
            }
        }

        $controllerClass = "\\App\\Controllers\\Api\\".getControllerName($controller);
        $firstCharacter = substr($action, 0, 1);
        if ($firstCharacter === '-' || is_numeric($firstCharacter)) {
            return response()->json([
                'status'    => -1 ,
                'message'     => 'Action '. $action .' started with number or - charter!',
            ], 500, [], JSON_PRETTY_PRINT);
        }
        $method = getFunctionName($action);

        // Kiểm tra Class tồn tại ở Controller
        if (class_exists($controllerClass)) {
            $makeControllerClass = app()->make($controllerClass);
            if (method_exists($makeControllerClass, $method)) {
                return $makeControllerClass->$method();
            }
            return response()->json([
                'status'    => -1 ,
                'message'     => 'Function ' . $method . ' does not exist in class ' . $controllerClass,

            ], 503, [], JSON_PRETTY_PRINT);
        }

        return response()->json([
            'status'    => -1 ,
            'message'     => 'Class ' . $controllerClass .' does not exist',
        ], 404, [], JSON_PRETTY_PRINT);
    }

    public function AssetsLoader($filename)
    {
        $filepath = VNCODER_ASSETS . $filename;
        if (file_exists($filepath)) {
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            if (!$extension) {
                return;
            }
            header('Cache-Control: max-age=84600');
            // Text File
            if (in_array($extension, ['css', 'js'])) {
                if ($extension == 'js') {
                    header('Content-Type: application/javascript');
                } else {
                    header("Content-Type: text/css");
                    header("X-Content-Type-Options: nosniff");
                }
                echo file_get_contents($filepath);
                exit;
            } else {
                switch ($extension) {
                    case 'png':
                        header('Content-Type: image/png');
                        break;
                    case 'jpg':
                    case 'jepg':
                        header('Content-type:image/jpeg');
                        break;
                    case 'gif':
                        header('Content-type:image/gif');
                        break;
                    case 'svg':
                        header('Content-type:image/svg+xml');
                        break;
                    default:
                        header('Content-Type: application/octet-stream');

                }
                header('Content-Disposition: inline; filename="'.basename($filename).'"');
                header('Content-Length: ' . filesize($filepath));
                readfile(VNCODER_ASSETS .$filename);
                return;
            }
        }
    }

    // Swagger API
    public function SwaggerHelper()
    {
        return view('core::api-helper');
    }

    public function SwaggerData(): \Illuminate\Http\JsonResponse
    {
        return response()->json(\OpenApi\scan(API_PATH));
    }

    // Media Loader
    public function MediaLoader()
    {
        $action = getParam('action', 'input');
        $medias = VnMedia::loadMedia(17);
        if (!$medias) {
            return false;
        }
        return view('backend::core.media', ['medias' => $medias , 'action' => $action]);
    }

    public function Page404()
    {
        return view('core::404');
    }
}
