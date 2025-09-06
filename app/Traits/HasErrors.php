<?php

namespace App\Traits;

use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;

trait HasErrors {
    public function prepareRenderErrors($errors): string
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
        $walker = function ($value) use (&$messages, &$walker) {
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

        return $html;
    }
}
