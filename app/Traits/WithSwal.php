<?php

namespace App\Traits;

use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;

trait WithSwal
{
    protected function swal(
        string $title,
        string $text = '',
        string $icon = 'success',
        string $html = '',
        string $theme = 'light',
        bool   $toast = false,
        bool   $timerProgressBar = false,
        bool   $showConfirmButton = true,
        bool   $showCloseButton = false,
        bool   $showCancelButton = false,
        string $position = 'center',
        int    $timer = 3000,
    ): void
    {
        $this->dispatch('swal', [
            'title' => $title,
            'text' => $text,
            'icon' => $icon,
            'html' => $html,
            'theme' => $theme,
            'toast' => $toast,
            'timerProgressBar' => $timerProgressBar,
            'showConfirmButton' => $showConfirmButton,
            'showCloseButton' => $showCloseButton,
            'showCancelButton' => $showCancelButton,
            'position' => $position,
            'timer' => $timer,
        ]);
    }

    public function swalError(
        string $title,
        string $text = '',
               $errors = [],
        string $html = '',
        string $icon = 'error',
        string $theme = 'light',
        bool   $toast = false,
        bool   $timerProgressBar = false,
        bool   $showConfirmButton = true,
        bool   $showCloseButton = false,
        bool   $showCancelButton = false,
        string $position = 'center'
    ): void
    {
        if ($html === '' || $html === null) {
            $html = $errors ? $this->prepareRenderErrors($text, $errors) : '';
        }

        $this->dispatch('swal', [
            'title' => $title,
            'icon' => $icon,
            'html' => $html,
            'theme' => $theme,
            'toast' => $toast,
            'timerProgressBar' => $timerProgressBar,
            'showConfirmButton' => $showConfirmButton,
            'showCloseButton' => $showCloseButton,
            'showCancelButton' => $showCancelButton,
            'position' => $position,
        ]);
    }

    public function swalWarning(
        string $title = 'Warning',
        string $text = '',
        string $icon = 'warning',
        string $html = '',
        string $theme = 'light',
        bool   $toast = false,
        bool   $timerProgressBar = false,
        bool   $showConfirmButton = true,
        bool   $showCloseButton = false,
        bool   $showCancelButton = false,
        string $position = 'center',
        int    $timer = 3000,
    ): void
    {
        $this->dispatch('swal', [
            'title' => $title,
            'text' => $text,
            'icon' => $icon,
            'html' => $html,
            'theme' => $theme,
            'toast' => $toast,
            'timerProgressBar' => $timerProgressBar,
            'showConfirmButton' => $showConfirmButton,
            'showCloseButton' => $showCloseButton,
            'showCancelButton' => $showCancelButton,
            'position' => $position,
            'timer' => $timer,
        ]);
    }

    private function prepareRenderErrors($text, $errors): string
    {
        if ($errors instanceof ValidationException) {
            $errors = $errors->errors();
        } elseif ($errors instanceof MessageBag) {
            $errors = $errors->toArray();
        } elseif ($errors instanceof \Throwable) {
            $errors = [$errors->getMessage() ?: 'Unexpected error.'];
        } elseif (is_string($errors)) {
            $errors = [$errors];
        } elseif (!is_array($errors)) {
            $errors = ['Unknown error.'];
        }

        $messages = [];
        $walker = static function ($value) use (&$messages, &$walker) {
            if (is_array($value)) {
                foreach ($value as $v) {
                    $walker($v);
                }
            } elseif ($value !== null && $value !== '') {
                $messages[] = (string)$value;
            }
        };
        $walker($errors);

        $messages = array_values(array_unique(array_map(
            fn($m) => htmlspecialchars($m, ENT_QUOTES, 'UTF-8'),
            $messages
        )));

        if (empty($messages)) {
            $messages[] = 'Unexpected error.';
        }

        $html = '<ul>';
        foreach ($messages as $msg) {
            $html .= '<li>' . $msg . '</li>';
        }
        $html .= '</ul>';

        return "$text<br/> $html";
    }
}
