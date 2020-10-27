<?php

namespace VnCoder\Controllers;

use VnCoder\Models\VnConfig;
use VnCoder\Models\VnUser;

class VnController extends BaseController
{
    protected $metaData;
    protected $setData = array();
    protected $isBackend = false;
    protected $template = 'default';
    protected $version = APP_VERSION;

    protected $extraHeader = '';
    protected $extraFooter = '';
    protected $extraHeaderCSS = '';
    protected $extraHeaderJS = '';
    protected $extraFooterJS = '';
    protected $uid = 0;

    public function __construct()
    {
        $this->coreInit();
        $this->siteInit();
    }

    protected function coreInit(): void
    {
        // Khoi tao Meta Data - Default
        $this->metaData = VnConfig::siteConfig();
        $this->metaData->baseUrl = url();

        $user_info = VnUser::getUser();
        $this->uid = $user_info ? $user_info->id : 0;
        $this->setData['__userData'] = $user_info;
    }

    protected function siteInit(): void
    {
    }

    protected function views($bladeName = '')
    {
        $this->setData['__currentUrl'] = request()->url();
        $this->setData['__metaData'] = $this->metaData;
        $this->setData['__extraHeader'] = $this->extraHeader;
        $this->setData['__extraHeaderCSS'] = $this->extraHeaderCSS;
        $this->setData['__extraHeaderJS'] = $this->extraHeaderJS;
        $this->setData['__extraFooter'] = $this->extraFooter;
        $this->setData['__extraFooterJS'] = $this->extraFooterJS;
        $this->setData['__template'] = $this->template;

        if ($this->isBackend) {
            $this->setData['__bladeTemplate'] = 'backend::layouts.' . $this->template;
        } else {
            $this->setData['__bladeTemplate'] = 'frontend::layouts.' . $this->template;
            $this->setData['__bladeRender'] =  'frontend::pages.' . $bladeName;
        }
        return view('core::views', $this->setData);
    }

    protected function header($text): void
    {
        $this->extraHeader .= $text . "\n";
    }

    protected function footer($text): void
    {
        $this->extraFooter .= $text . "\n";
    }

    protected function linkCSS($linkFile, $header = true): void
    {
        $stylesheet = $this->extraStylesheet($linkFile);
        if ($header) {
            if (strpos($this->extraHeaderCSS, $stylesheet) === false) {
                $this->extraHeaderCSS .= $stylesheet."\n";
            }
        } else {
            if (strpos($this->extraHeader, $stylesheet) === false) {
                $this->extraHeader .= $stylesheet."\n";
            }
        }
    }

    protected function linkJS($linkFile, $header = false)
    {
        $script = $this->extraScript($linkFile);
        if ($header) {
            if (strpos($this->extraHeaderJS, $script) === false) {
                $this->extraHeaderJS .= $script . "\n";
            }
        } else {
            if (strpos($this->extraFooter, $script) === false) {
                $this->extraFooterJS .= $script . "\n";
            }
        }
    }

    protected function extraScript($linkFile)
    {
        if (strpos($linkFile, 'http://') === false && strpos($linkFile, 'https://') === false) {
            $linkFile = url($linkFile) . '?v=' . $this->version;
        }
        return '<script type="text/javascript" src="' . $linkFile . '"></script>';
    }

    protected function extraStylesheet($linkFile)
    {
        if (strpos($linkFile, 'http://') === false && strpos($linkFile, 'https://') === false) {
            $linkFile = url($linkFile) . '?v=' . $this->version;
        }
        return '<link rel="stylesheet" type="text/css" href="' . $linkFile . '">';
    }

    protected function redirect404()
    {
        return redirect()->route('404');
    }
}
