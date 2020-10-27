<?php

namespace VnCoder\Backend\Controllers;

class RouteController
{
    public function get($controller, $action = 'index')
    {
        return $this->BackendLoader($controller, $action, false);
    }

    public function post($controller, $action = 'index')
    {
        return $this->BackendLoader($controller, $action, true);
    }

    protected function BackendLoader($controller, $action, $isPostMethod = false)
    {
        $controllerBackend = "\\App\Admin\\Controllers\\" . getControllerName($controller);
        $controllerAdmin = "\\VnCoder\Backend\Controllers\\" . getControllerName($controller);

        $firstCharacter = substr($action, 0, 1);
        if ($firstCharacter === '-' || is_numeric($firstCharacter)) {
            return response()->json([
                'status'    => -1 ,
                'error'     => 'Action '. $action .' started with number or - charter!',
            ], 500, [], JSON_PRETTY_PRINT);
        }
        $method = getFunctionName($action);
        if ($isPostMethod) {
            $method = $method . '_Submit';
        }

        // Kiểm tra Class tồn tại ở Controller
        if (class_exists($controllerBackend)) {
            if (class_exists($controllerAdmin)) {
                return response()->json([
                    'status'    => -1 ,
                    'message'   => 'Class '.$controllerBackend.' has defined in Admin Core!',
                ], 500, [], JSON_PRETTY_PRINT);
            }

            $makeControllerClass = app()->make($controllerBackend);
            if (method_exists($makeControllerClass, $method)) {
                return $makeControllerClass->$method($controller, $action);
            }
            return response()->json([
                'status'    => -1 ,
                'message'   => 'Method ' . $method . ' not active in class ' . $controllerBackend,
            ], 502, [], JSON_PRETTY_PRINT);
        }

        // Kiểm tra Class tồn tại ở Core
        if (class_exists($controllerAdmin)) {
            $makeControllerClass = app()->make($controllerAdmin);
            if (method_exists($makeControllerClass, $method)) {
                return $makeControllerClass->$method($controller, $action);
            }
            return response()->json([
                'status'    => -1 ,
                'message'   => 'Method ' . $method . ' not active in class ' . $controllerAdmin,
            ], 502, [], JSON_PRETTY_PRINT);
        }

        return response()->json([
            'status'    => -1 ,
            'message'   => 'Class ' . $controllerBackend . ' not found',
        ], 404, [], JSON_PRETTY_PRINT);
    }
}
