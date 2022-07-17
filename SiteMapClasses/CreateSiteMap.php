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
            $this->CheckArray($array);
        }catch (\Exception $e){
            die($e->getMessage());
        }
        try {
            $file = $this->createFile->CreateFile($type);
        }catch (\Exception $e){
            die($e->getMessage());
        }
        if ($type === "XML" || $type === "xml"){
            $this->CreateCiteMapXML($array,$file);
        }elseif ($type === "CSV" || $type === "csv"){
            $this->CreateSiteMapCSV($array,$file);
        }elseif ($type === "JSON" || $type === "json"){
            $this->CreateSiteMapJSON($array,$file);
        }
    }

    private function CheckArray($array){
        if (is_array($array)){
            foreach ($array as $key => $value){
                if (is_array($value)){
                $keys = (array_keys($value));
                    if ($keys[0] !== "loc" || $keys[1] !== "lastmod" || $keys[2] !== "priority" || $keys[3] !== "changefreq"){
                    throw new \Exception("Ошибка создания карты сайта: проверьте валидность данных массива");

                    }
                }else throw new \Exception("Ошибка создания карты сайта:библиотека не работает с одномерным массивом");
            }
        }else throw new \Exception("Ошибка создания карты сайта: параметр не является массивом");
    }

    private function CreateSiteMapJSON($array,$file){
        $jsonValue = json_encode($array,JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        $result = file_put_contents($file,"$jsonValue");

    }

    private function CreateSiteMapCSV($array,$file){
        $stream = fopen($file,'w');
        foreach($array as $key => $value) {
            if (!isset($keys)){
                $keys = array_keys($value);
                fputcsv($stream, $keys, ";");
            }
            fputcsv($stream, $value, ";");
        }
        fclose($stream);
    }
    private function CreateCiteMapXML($array,$file){
        $result = new \SimpleXMLElement('<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"></urlset>');
        foreach ($array as $keyFirst => $valueFirst) {
            $url = $result->addChild("url");
            foreach ($valueFirst as $keySecond => $valueSecond){
                $url->addChild($keySecond,$valueSecond);
            }
        }
        $result = $result->asXML();
        $dom = new \DOMDocument();
        $dom->loadXML($result);
        $dom->formatOutput = true;
        $formattedXML = $dom->saveXML();
        $fp = fopen($file,"w");
        fwrite($fp, $formattedXML);
        fclose($fp);
    }
}
