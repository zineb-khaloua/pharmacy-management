<?php
namespace Helpers;

class ViewHelper{

public static function render($view , $data=[])
{

    extract($data);
    $viewPath = VIEWS . $view; 

    if(!file_exists($viewPath))
    {
       //echo ("Fichier introuvable : $viewPath");
        throw new \Exception ("view file not exict : {$view}");
    }
    ob_start();
    include $viewPath;
    return ob_get_clean(); 
}


}