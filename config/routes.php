<?php

//user route
$router->map('GET', '/login', 'UserController@loginForm');
$router->map('POST', '/login', 'UserController@login');
$router->map('GET', '/userSetting/[i:userId]', 'UserController@userShow');
$router->map('POST', '/userSetting/[i:userId]', 'UserController@updateUser');
$router->map('GET', '/logout', 'UserController@logout');
 
$router->map('GET','/export-users','UserController@exportUsers');
$router->map('GET','/authenInfo','UserController@authentificationInfo');
$router->map('GET','/addUser','UserController@formAddUser');
$router->map('POST','/addUser','UserController@addUser');
$router->map('GET','/editUser/[i:userId]','UserController@editUser');
$router->map('POST','/editUser/[i:userId]','UserController@updateUserAndProfile');
$router->map('GET','/deleteUser/[i:userId]','UserController@deleteUser'); 

//dashboard route
$router->map('GET','/dashboard', 'dashboardController@dashboardShow');
$router->map('GET','/statisticsSale/[*:period]/[*:date]','dashboardController@getStatisticsSaleByPeriod');
$router->map('GET','/statisticsSaleByYear/[i:year]/','dashboardController@getStatisticsSaleByYear');
$router->map('GET','/low-stock-medicaments','dashboardController@lowStock');
//patient route 
$router->map('GET', '/export-patients', 'PatientController@exportPatients');
$router->map('GET', '/patient', 'PatientController@patientShow');
$router->map('GET',  '/addPatient','PatientController@formAddPatient');
$router->map('POST','/addPatient','PatientController@addPatient');
$router->map('GET','/editPatient/[i:id]','PatientController@editForm');
$router->map('POST','/editPatient/[i:id]','PatientController@updatePatient');
$router->map('GET','/deletePatient/[i:id]','PatientController@deletePatient');
//medicament route 
$router->map('GET','/export-medicaments','MedicamentController@exportMedicaments');
$router->map('GET','/medicament','MedicamentController@medicamentShow');
$router->map('GET','/addMedicament','MedicamentController@formAddMedicament');
$router->map('POST','/addMedicament','MedicamentController@addMedicament');
$router->map('GET','/editMedicament/[i:id]','MedicamentController@editForm');
$router->map('POST','/editMedicament/[i:id]','MedicamentController@updateMedicament');
$router->map('GET','/deleteMedicament/[i:id]','MedicamentController@deleteMedicament');

//category route 

$router->map('GET','/export-categories','CategoryController@exportCategories');
$router->map('GET','/category','CategoryController@categoryShow');
$router->map('GET','/addCategory','CategoryController@formAddCategory');
$router->map('POST','/addCategory','CategoryController@addCategory');
$router->map('GET','/editCategory/[i:id]','CategoryController@editForm');
$router->map('POST','/editCategory/[i:id]','CategoryController@updateCategory');
$router->map('GET','/deleteCategory/[i:id]','CategoryController@deleteCategory');
//supplier route
$router->map('GET','/export-suppliers','SupplierController@exportSuppliers');
$router->map('GET','/supplier','SupplierController@supplierShow');
$router->map('GET','/addSupplier','SupplierController@formAddSupplier');
$router->map('POST','/addSupplier','SupplierController@addSupplier');
$router->map('GET','/editSupplier/[i:id]','SupplierController@editForm');
$router->map('POST','/editSupplier/[i:id]','SupplierController@updateSupplier');
$router->map('GET','/deleteSupplier/[i:id]','SupplierController@deleteSupplier');
//order route
$router->map('GET','/export-orders','OrderController@exportOrders');
$router->map('GET','/order','OrderController@orderShow');
$router->map('POST', '/updateOrderStatus', 'OrderController@updateOrderStatus');
$router->map('GET','/getOrderDetails/[i:id]','OrderController@orderDetails');
$router->map('GET','/addOrder','OrderController@formAddOrder');
$router->map('POST','/addOrder','OrderController@addOrder');
$router->map('GET','/editOrder/[i:id]','OrderController@editForm');
$router->map('POST','/editOrder/[i:id]','OrderController@updateOrderProcess');
$router->map('GET','/deleteOrder/[i:id]','OrderController@deleteOrder');
$router->map('GET', '/deleteOrderItem/[i:itemId]/[i:orderId]', 'OrderController@deleteOrderItem');
//invoice route
$router->map('GET','/generateOrderInvoice/[i:orderId]','OrderController@invoiceCreate');
//sales route.....
$router->map('GET','/export-sales','SalesController@exportSales');
$router->map('GEt','/sale','SalesController@saleShow');
$router->map('GEt','/getSaleDetails/[i:id]','SalesController@saleDetails');
$router->map('GEt','/addSale','SalesController@formAddsale');
$router->map('POST','/addSale','SalesController@addSale');
$router->map('GET','/editSale/[i:id]','SalesController@editForm');
$router->map('POST','/editSale/[i:id]','SalesController@updateSaleProcess');
$router->map('GET','/deleteSale/[i:id]','SalesController@deleteSale');
$router->map('GET','/deleteSaleItem/[i:itemId]/[i:saleId]', 'SalesController@deleteSaleItem');
//invoiceSale route 
$router->map('GET','/generateSaleInvoice/[i:saleId]','SalesController@invoiceCreate');
//StatisticsSale route 
$router->map('GET','/statisticsSale/[i:saleId]','SalesController@getStatistics');

//pharmacy route
$router->map('GET','/pharmacy','PharmacyController@pharmacy');
$router->map('POST','/updatePharmacy/[i:id]','PharmacyController@updatePharmacy');
