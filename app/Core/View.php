<?php
declare(strict_types=1);

namespace App\Core;

class View {
    private static array $shared = [];

    public static function share(string $key, mixed $value): void {
        self::$shared[$key] = $value;
    }

    public static function render(string $viewPath, array $data = [], string $layout = 'main'): void {
        $viewFile = dirname(__DIR__) . '/Views/' . ltrim($viewPath, '/') . '.php';
        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View file not found: {$viewFile}");
        }

        // Merge shared data with view-specific data
        $mergedData = array_merge(self::$shared, $data);
        extract($mergedData, EXTR_SKIP);

        // Start buffering view content
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        if ($layout === '') {
            echo $content;
            return;
        }

        $layoutFile = dirname(__DIR__) . '/Views/layouts/' . $layout . '.php';
        if (!file_exists($layoutFile)) {
            throw new \RuntimeException("Layout file not found: {$layoutFile}");
        }

        require $layoutFile;
    }

    public static function component(string $componentName, array $data = []): void {
        $componentFile = dirname(__DIR__) . '/Views/components/' . ltrim($componentName, '/') . '.php';
        if (file_exists($componentFile)) {
            $mergedData = array_merge(self::$shared, $data);
            extract($mergedData, EXTR_SKIP);
            require $componentFile;
        }
    }
}
