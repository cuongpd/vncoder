<?php

namespace VnCoder\Backend\Controllers;

use VnCoder\Backend\Models\VnLogs;

class LogsController extends BackendController
{
    private $vn_logs;

    public function __construct()
    {
        parent::__construct();
        $this->vn_logs = new VnLogs();
    }

    public function Index_Action()
    {
        $this->metaData->title = 'Xem log hệ thống';
        $folderFiles = [];
        if ($this->request->input('f')) {
            $this->vn_logs->setFolder(decrypt($this->request->input('f')));
            $folderFiles = $this->vn_logs->getFolderFiles(true);
        }
        if ($this->request->input('l')) {
            $this->vn_logs->setFile(decrypt($this->request->input('l')));
        }
        if ($early_return = $this->earlyReturn()) {
            return $early_return;
        }

        $logs = $this->vn_logs->all();
        $this->setData['folders'] = $this->vn_logs->getFolders();
        $this->setData['current_folder'] = $this->vn_logs->getFolderName();
        $this->setData['folder_files'] = $folderFiles;
        $this->setData['files'] = $this->vn_logs->getFiles(true);

        $current_file = $this->vn_logs->getFileName();
        $this->setData['current_file'] = $current_file;
        $this->setData['standardFormat'] = true;

        if (is_array($logs)) {
            $firstLog = reset($logs);
            if ($firstLog && !$firstLog['context']) {
                $data['standardFormat'] = false;
            }
        }

        $this->setData['logs'] = $logs;
        $this->setData['logs_url'] = backend('logs');
        $this->setData['logs_data'] = encrypt($current_file);

        $this->linkCSS('core/plugins/datatables/dataTables.bootstrap4.css');
        $this->linkJS('core/plugins/datatables/jquery.dataTables.min.js');
        $this->linkJS('core/plugins/datatables/dataTables.bootstrap4.min.js');
        $this->header('<style>.stack-info{font-size:9px;text-align: initial} .td-top{vertical-align:top !important;}</style>');
        return $this->views('admin.logs');
    }

    private function earlyReturn()
    {
        if ($this->request->input('f')) {
            $this->vn_logs->setFolder(decrypt($this->request->input('f')));
        }
        if ($this->request->input('dl')) {
            return $this->download($this->pathFromInput('dl'));
        } elseif ($this->request->has('clean')) {
            app('files')->put($this->pathFromInput('clean'), '');
            return $this->redirect($this->request->url());
        } elseif ($this->request->has('del')) {
            app('files')->delete($this->pathFromInput('del'));
            return $this->redirect($this->request->url());
        } elseif ($this->request->has('delall')) {
            $files = ($this->vn_logs->getFolderName())
                ? $this->vn_logs->getFolderFiles(true)
                : $this->vn_logs->getFiles(true);
            foreach ($files as $file) {
                try {
                    app('files')->delete($this->vn_logs->pathToLogFile($file));
                } catch (\Exception $e) {
                }
            }
            return $this->redirect($this->request->url());
        }
        return false;
    }

    private function pathFromInput($input_string): string
    {
        try {
            return $this->vn_logs->pathToLogFile(decrypt($this->request->input($input_string)));
        } catch (\Exception $e) {
        }
    }

    private function redirect($to)
    {
        if (function_exists('redirect')) {
            return redirect($to);
        }
        return app('redirect')->to($to);
    }

    private function download($data)
    {
        return response()->download($data);
    }
}
