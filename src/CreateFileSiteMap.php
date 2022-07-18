<?php

namespace Kirillkhimich\Sitemap;

class CreateFileSiteMap
{
    private $dir;
    public function __construct(){
        $this ->dir = $_SERVER['DOCUMENT_ROOT'] . "/SiteMapFiles";
    }

    public function CreateFile($type){

        try {
            $this->CreateDir($this->dir);
        }catch (\Exception $e){
            die($e->getMessage());
        }
        $rights = substr(sprintf('%o', fileperms($this->dir)), -4);
        if ($rights[1] >= 6){
            if ($type === "XML" || $type === "xml"){
                $typeFile = ".xml";
            }elseif ($type === "CSV" || $type === "csv"){
                $typeFile = ".csv";
            }elseif ($type === "JSON" || $type === "json"){
                $typeFile = ".json";
            }else{
                throw new \Exception("Ошибка записи файла:проверьте переданный параметр типа");
            }
            $file = $this->dir ."/". "sitemap". $typeFile;
                if (!file_exists($file)){
                    $stream = fopen($file, "w");
                    fclose($stream);
                }
            return $file;
        }else throw new \Exception("Ошибка записи файла:недостаточно прав на создание файла");
    }

    private function CreateDir($dir){
        $rights = substr(sprintf('%o', fileperms($_SERVER['DOCUMENT_ROOT'])), -4);
        if (!file_exists($dir)){
            if ($rights[1] >= 6) {
                mkdir($dir);
            }else throw new \Exception("Ошибка записи файла: недостаточно прав на создание папки");
        }
    }
}