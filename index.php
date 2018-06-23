<?php

include("config.php");
$lang=default_lang;
$data = file_get_contents("locales/".$lang.".json");
$lang_data = json_decode($data, true);

require __DIR__ . '/vendor/mustache/mustache/src/Mustache/Autoloader.php';
Mustache_Autoloader::register();

$options =  array('extension' => '.html');

$m = new Mustache_Engine(array(
    'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__)."/parcials/" , $options),
    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__)."/theme/travel/" , $options)
));

$pages = array(
  'orlando-360'=>"0",
  "mexico-que-arde" => "1",
  "punta-cana-palm"=>"2",
  "bahamas-festival"=>"3",
  "las-vegas-lux"=>"4"
);

if (gettype($_GET['p'])!='NULL') {

  if ($_GET['p']=="promo") {
    $lang_data['dataselected']=$lang_data['paquetes'][($pages[$_GET['d']])]["item"];
    $directoryToScan = "images/tour/travel/".$_GET['d'];
    $lang_data['title']=$lang_data['dataselected']['title'];
    $lang_data["dataselected"]["img"]=glob($directoryToScan."/*.jpg");

    echo $m->render($_GET['p'], $lang_data);




  }else{
    $lang_data['title']=$lang_data[$_GET['p']];
    echo $m->render($_GET['p'], $lang_data);
  }


}else{
  $lang_data['title']=$lang_data['index'];
  echo $m->render('index', $lang_data);
}
