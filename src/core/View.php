<?php

namespace Src\core;

use Src\exceptions\ViewNotFoundException;

class View {

    private string $layout = '';

    private function __construct(

        private string $template,

        private array $data){}


    public static function display(string $templateName, array $data = []):self {

        $templatePath = VIEW_PATH . 'templates/' . $templateName . '.phtml';

        self::validateFile($templatePath, 'template');
        
        return new static($templatePath, $data);
        
    }

    public function setLayout(string $layoutName):void {

        $layoutPath = VIEW_PATH . 'layouts/' . $layoutName . '.phtml';

        self::validateFile($layoutPath, 'layout');

        $this->layout = $layoutPath;

    }
    
    private static function validateFile($path, $errorRef):void {

        if (! file_exists($path)) {

            throw new ViewNotFoundException($errorRef);

        }
    }

    public function __destruct() {

        extract($this->data);

        include $this->template;

    }



}