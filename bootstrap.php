<?php

require_once __DIR__ . '/vendor/autoload.php';  // Charger Composer, si utilisé

use core\DB;
use core\App;
use core\Container;
use Controllers\UserController;
use Controllers\dashboardController;
use Controllers\PatientController;
use Controllers\MedicamentController;
use Controllers\CategoryController;
use Controllers\SupplierController;
use Controllers\OrderController;
use Controllers\SalesController;
use Controllers\ProfileController;
use Controllers\PharmacyController;
// Create and initialize the service container
$container = new Container();

// Bind DB singleton
$container->bind('DB',function(){
    return DB::getInstance()->getConnection();
});

//bind UserController
$container->bind('UserController',function($container){

    return new UserController($container->resolve('DB'));

});

//bind dashboardController
$container->bind('dashboardController',function($container){

    return new dashboardController($container->resolve('DB'));

});
 
//bind PatientController
$container->bind('PatientController',function($container){

    return new PatientController($container->resolve('DB'));

});

//bind MedicamentController 
 $container->bind('MedicamentController',function($container){

    return new MedicamentController ($container->resolve('DB'));

 });

 //bind CategoryController 
 $container->bind('CategoryController',function($container){
     
    return new CategoryController ($container->resolve('DB'));
 });
 //bind SupplierController
 $container->bind('SupplierController',function($container){

    return new SupplierController($container->resolve('DB'));

 });
 
 //bind SalesController
 $container->bind('SalesController',function($container){
    return new SalesController($container->resolve('DB'));
 });

 //bind OrderController
$container->bind('OrderController',function($container){
    return new OrderController($container->resolve('DB'));
});
 //bind ProfileController
 $container->bind('ProfileController',function($container){
    return new ProfileController($container->resolve('DB'));
});
 //bind ProfileController
 $container->bind('BaseController',function($container){
    return new BaseController($container->resolve('DB'));
});
 //bind PharmacyController
 $container->bind('PharmacyController',function($container){
    return new PharmacyController($container->resolve('DB'));
});

// Configure the container for global use
App::setContainer($container);

