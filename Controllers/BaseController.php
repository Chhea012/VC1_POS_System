<?php
class BaseController {
    protected function view($view, $data = [], $layout = 'layout') {
        extract($data);
        ob_start();
        require "views/{$view}.php";
        $content = ob_get_clean();
        if ($layout !== null) {
            require "views/{$layout}.php";
        } else {
            echo $content;
        }
    }

    protected function redirect($url) {
        header("Location: $url");
        exit;
    }
}
