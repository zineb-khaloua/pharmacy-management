<?php

namespace Helpers;

class UrlHelper{

    public static function redirect($path)
    {
       
        $url=BASE_PATH . $path;

        header("location: $url");
        exit();


    }

}
