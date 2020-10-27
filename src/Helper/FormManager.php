<?php

namespace VnCoder\Helper;

class FormManager
{
    protected $data = [];
    protected $action = '';
    protected $output = '';

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function html(): string
    {
        $this->openForm();
        $this->formGenerator();
        $this->closeForm();
        return $this->output;
    }

    protected function formGenerator(): void
    {
        // View Data: title , name , value ,
        if ($this->data && is_array($this->data)) {
            foreach ($this->data as $item) {
                $key = $item['name'] ?? '';
                if ($key) {
                    $data = [];
                    $data['name'] = $key;
                    $data['title'] = $item['title'] ?? $key;
                    $formType = (isset($data['type']) && $data['type']) ? $data['type'] : $this->getTypeFormByName($key);
                    $data['value'] = $data['value'] ?? '';
                    $data['required'] = $data['required'] ?? '';
                    $data['placeholder'] = $data['placeholder'] ?? '';
                    $this->getHtml($formType, $data);
                }
            }
        }
    }

    protected function getTypeFormByName($name = ''): string
    {
        return 'text';
        if (in_array($name, ['id', 'created', 'updated', 'status', 'created_at', 'updated_at'])) {
            return 'hidden';
        }
        if (in_array($name, ['photo', 'avatar', 'img', 'image', 'images', 'logo', 'favicon'])) {
            return 'photo';
        }
        if (in_array($name, ['file', 'source', 'video', 'webm'])) {
            return 'file';
        }
        if (in_array($name, ['description', 'meta'])) {
            return 'textarea';
        }
        if ($name === 'content') {
            return 'content';
        }
        if (in_array($name, ['keyword','tags'])) {
            return 'tags';
        }
        return 'text';
    }

    protected function openForm(): void
    {
        $action = $this->action;
        $this->getHtml('form_open', ['action' => $action]);
    }

    protected function closeForm(): void
    {
        $this->getHtml('form_close');
    }

    protected function getHtml($type, $data = []): void
    {
        $data['form'] = 'core::form.' . $type;
        try {
            $this->output .= view('core::form', $data)->render();
        } catch (\Throwable $e) {
        }
    }
}
