<?php

namespace Src\services;

class UploadHandler {

    private function __construct(

        private array $uploadedFile

    ){}


    public static function from(array $uploadedFile):self {
        
        return new static($uploadedFile);

    }

    public function saveWithUniqueName(string $destination):string {

        $parsed = explode('.', $this->uploadedFile['name']);

        $newFileName = uniqid() . '.' . end($parsed);

        $newFilePath = $destination . $newFileName;

        move_uploaded_file($this->uploadedFile['tmp_name'], $newFilePath);

        return $newFileName;

    }

}