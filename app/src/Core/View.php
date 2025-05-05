<?php
namespace Core;

class View {
    public static function render($view, $data = []) {
        extract($data);
        
        $layout = self::getLayout($data);
        $viewContent = self::getViewContent($view, $data);
        
        return str_replace('@content', $viewContent, $layout);
    }

    private static function getLayout($data) {
        extract($data);
        ob_start();
        include __DIR__ . '/../../app/Views/layouts/main.php';
        return ob_get_clean();
    }

    private static function getViewContent($view, $data) {
        extract($data);
        ob_start();
        include __DIR__ . "/../../app/Views/{$view}.php";
        return ob_get_clean();
    }

    public static function partial($name, $data = []) {
        extract($data);
        include __DIR__ . "/../../app/Views/partials/{$name}.php";
    }
}