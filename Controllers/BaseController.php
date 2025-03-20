<?php
class BaseController {
    protected function view($view, $data = [], $layout = 'layout') {
        extract($data);
        ob_start();
        $viewFile = "views/{$view}.php";
        if (!file_exists($viewFile)) {
            die("View file not found: $viewFile");
        }
        require $viewFile;
        $content = ob_get_clean();
        if ($layout !== null) {
            $layoutFile = "views/{$layout}.php";
            if (!file_exists($layoutFile)) {
                die("Layout file not found: $layoutFile");
            }
            require $layoutFile;
        } else {
            echo $content;
        }
    }

    protected function redirect($url) {
        header("Location: $url");
        exit;
    }
}