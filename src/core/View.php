<?php

namespace Src\core;

class View {

    private string $layout = '';

    private function __construct(

        private string $template,

        private array $data
    ){}


    public static function display(string $templateName, array $data = []):self {

        $templatePath = VIEW_PATH . 'templates/' . $templateName . '.phtml';
        
        return new static($templatePath, $data);
        
    }

    public function setLayout(string $layoutName):void {
        
        $this->layout = $layoutName;

    }

    public function __destruct() {

        extract($this->data);

        include $this->template;

        if ($_SESSION['message'] ?? false) {

            unset($_SESSION['message']);

        }

    }
}