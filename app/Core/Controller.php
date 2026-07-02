<?php

namespace App\Core;

class Controller {
    /**
     * Render a view file and pass data to it.
     *
     * @param string $view e.g. "perfis.index"
     * @param array $data
     */
    protected function render(string $view, array $data = []): void {
        extract($data);
        
        $viewFile = BASE_PATH . '/app/Views/' . str_replace('.', '/', $view) . '.php';
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo "View file not found: $viewFile";
        }
    }

    /**
     * Redirect to a specific URL.
     *
     * @param string $url
     */
    protected function redirect(string $url): void {
        header("Location: $url");
        exit;
    }
}
