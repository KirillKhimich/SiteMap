<?php

namespace SiteMapClasses;

use SiteMapClasses\CreateFileSiteMap;
class CreateSiteMap
{
    private $createFile;
    public function __construct(){
        $this->createFile = new CreateFileSiteMap();
    }
    public function CreateSiteMap($array,$type){
        try {
            $this->createFile->CreateFile($type);
        }catch (\Exception $e){
            die($e->getMessage());
        }
        try {
            $this->CheckArray($array);
        }catch (\Exception $e){
            die($e->getMessage());
        }
        
    }
    private function CheckArray($array){
        foreach ($array as $key => $value){
            $keys = (array_keys($value));
            if ($keys[0] !== "loc" || $keys[1] !== "lastmod" || $keys[2] !== "priority" || $keys[3] !== "changefreq"){
                throw new \Exception("Ошибка создания карты сайта: проверьте валидность данных массива");
                return false;
            }
        }
        return true;
    }
}