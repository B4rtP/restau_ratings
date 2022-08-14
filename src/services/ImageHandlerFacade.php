<?php

namespace Src\services;

use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class ImageHandlerFacade {

    private function __construct(

        private Image $image

    ){}

    public static function open(string $path):self {

        $imger = new ImageManager(['driver' => 'imagick']);

        $image = $imger->make($path);

        return new static($image);

    }

    public function reduceMaxSize(int $maxW, int $maxH):self {
        
        $this->image->fit($maxW, $maxH);

        return $this;   

    }

    public function applyBlur(int $blurLevel):self {
        
        $this->image->blur($blurLevel);

        return $this;

    }

    public function save(string $destination):void {

        $this->image->save($destination);

    }

}