<?php
include_once "SiteMapClasses/CreateSiteMap.php";
include_once "SiteMapClasses/CreateFileSiteMap.php";
function printer($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}
$array = [[
    "loc" => "https://site.ru/",
    "lastmod"=> "2020-12-14",
    "priority"=>"1",
    "changefreq" =>"hourly",

],[
    "loc" => "https://site.ru/news",
    "lastmod"=> "2020-12-14",
    "priority"=>"1",
    "changefreq" =>"daily"
]];

$sitemap = new \SiteMapClasses\CreateSiteMap();
$sitemap->CreateSiteMap($array,"JSON");
