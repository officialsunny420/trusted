<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

//admin routes
$routes->group("admin", ["filter" => "adminAuthGuard"], function ($routes) {
	$routes->add("dashboard",'\Modules\Dashboard\Controllers\AdminController::index');
	$routes->add("upload",'\Modules\Dashboard\Controllers\AdminController::upload');
	$routes->add("remove_upload_images",'\Modules\Dashboard\Controllers\AdminController::remove_upload_images');
	$routes->add("claculate_retail_value",'\Modules\Dashboard\Controllers\AdminController::claculateRetailValue');
	$routes->add("claculate_rental_transaction",'\Modules\Dashboard\Controllers\AdminController::claculateRentalTransaction');
	$routes->add("claculate_membership_pie",'\Modules\Dashboard\Controllers\AdminController::CalculateMembershipPie');
	
	$routes->group('categories', function ($routes) {
        $routes->add('/', '\Modules\Categories\Controllers\AdminController::index');
        $routes->add('add', '\Modules\Categories\Controllers\AdminController::add');
		$routes->add('edit/(:num)', '\Modules\Categories\Controllers\AdminController::edit/$1');
		$routes->add('change_status', '\Modules\Categories\Controllers\AdminController::changeStatus');
	});

	
	$routes->group('forms', function ($routes) {
        $routes->add('/', '\Modules\Forms\Controllers\AdminController::index');
        $routes->add('add', '\Modules\Forms\Controllers\AdminController::add');
		$routes->add('edit/(:num)', '\Modules\Forms\Controllers\AdminController::edit/$1');
		$routes->add('change_status', '\Modules\Forms\Controllers\AdminController::changeStatus');
		$routes->add('delete', '\Modules\Forms\Controllers\AdminController::deleteRow');
		$routes->add('get-subcategories', '\Modules\Forms\Controllers\AdminController::getSubcategories');
		$routes->add('view/(:num)', '\Modules\Forms\Controllers\AdminController::view/$1');
	});

	$routes->group('profile', function ($routes) {
        $routes->add('/', '\Modules\Profile\Controllers\AdminController::index');
	});
	
	$routes->group('settings', function ($routes) {
        $routes->add('/', '\Modules\Settings\Controllers\AdminController::index');
        $routes->add('delete_image', '\Modules\Settings\Controllers\AdminController::deleteSliderImage');
	});
	
	$routes->group('users', function ($routes) {
        $routes->add('/', '\Modules\Users\Controllers\AdminController::index');
        $routes->add('add', '\Modules\Users\Controllers\AdminController::add');
        $routes->add('data', '\Modules\Users\Controllers\AdminController::data');
        $routes->add('edit/(:num)', '\Modules\Users\Controllers\AdminController::edit/$1');
        $routes->add('document/(:num)', '\Modules\Users\Controllers\AdminController::document/$1');
        $routes->add('change_featured', '\Modules\Users\Controllers\AdminController::changeFeatured');
        $routes->add('delete_user', '\Modules\Users\Controllers\AdminController::deleteUser');
        $routes->add('delete_document', '\Modules\Users\Controllers\AdminController::deleteDocument');
		$routes->add('change_status', '\Modules\Users\Controllers\AdminController::changeStatus');
	});

	$routes->group('stocks', function ($routes) {
        $routes->add('/', '\Modules\Stocks\Controllers\AdminController::index');
        $routes->add('add', '\Modules\Stocks\Controllers\AdminController::add');
		$routes->add('edit/(:num)', '\Modules\Stocks\Controllers\AdminController::edit/$1');
		$routes->add('change_status', '\Modules\Stocks\Controllers\AdminController::changeStatus');
	});
    $routes->group('submissions', function ($routes) {
        $routes->add('/', '\Modules\Form_Submission\Controllers\AdminController::index');
         $routes->add('contact_us', '\Modules\Form_Submission\Controllers\AdminController::contact_us');
        $routes->add('add', '\Modules\Form_Submission\Controllers\AdminController::add');
		$routes->add('view/(:num)', '\Modules\Form_Submission\Controllers\AdminController::view/$1');
		$routes->add('change_status', '\Modules\Form_Submission\Controllers\AdminController::changeStatus');
		$routes->add('delete', '\Modules\Form_Submission\Controllers\AdminController::deleteRow');
		$routes->add('export', '\Modules\Form_Submission\Controllers\AdminController::export');
			$routes->add('export-single/(:num)', '\Modules\Form_Submission\Controllers\AdminController::exportSingle/$1');
			$routes->add('exportall', '\Modules\Form_Submission\Controllers\AdminController::exportall');
			$routes->add('exportcategories', '\Modules\Form_Submission\Controllers\AdminController::exportCategories');
			$routes->add('get-subcategories', '\Modules\Form_Submission\Controllers\AdminController::getSubcategories');
	});
	
	
	$routes->add("logout",'\Modules\Dashboard\Controllers\AdminController::logout');
});

//user route
$routes->group("account", ["filter" => "userAuthGuard"], function ($routes) {
	$routes->add("dashboard",'\UserModules\Dashboard\Controllers\AdminController::index');
	$routes->add("upload",'\UserModules\Dashboard\Controllers\AdminController::upload');
	$routes->add("remove_upload_images",'\UserModules\Dashboard\Controllers\AdminController::remove_upload_images');
	$routes->add("claculate_retail_value",'\UserModules\Dashboard\Controllers\AdminController::claculateRetailValue');
	$routes->add("claculate_rental_transaction",'\UserModules\Dashboard\Controllers\AdminController::claculateRentalTransaction');
	$routes->add("claculate_membership_pie",'\UserModules\Dashboard\Controllers\AdminController::CalculateMembershipPie');
	$routes->add("calculate_category_pie",'\UserModules\Dashboard\Controllers\AdminController::CalculateCategoryPie');
	$routes->group('stocks', function ($routes) {
        $routes->add('/', '\UserModules\Stocks\Controllers\AdminController::index');
		$routes->add('view/(:num)', '\UserModules\Stocks\Controllers\AdminController::view/$1');
	});
	
	$routes->group('historical', function ($routes) {
        $routes->add('/', '\UserModules\Historical\Controllers\AdminController::index');
		$routes->add('view/(:num)', '\UserModules\Historical\Controllers\AdminController::view/$1');
	});
	
	$routes->add("documents",'\UserModules\DocumentUpload\Controllers\AdminController::index');
	$routes->group('documents', function ($routes) {
		$routes->add('delete_document', '\UserModules\DocumentUpload\Controllers\AdminController::deleteDocument');
	});
	
	$routes->group('profile', function ($routes) {
        $routes->add('/', '\UserModules\Profile\Controllers\AdminController::index');
	});
	
	$routes->add("logout",'\UserModules\Dashboard\Controllers\AdminController::logout');
});
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */
//for user
$routes->get('/', 'Home::index');
$routes->post('/get-subcategories', 'Home::getSubcategories');
$routes->get('/get-form-data', 'Home::getFormData');
$routes->post('/add-form-data', 'Home::addFormData');
$routes->post('/add-contact-form-data', 'Home::addContactFormData');
$routes->post('/file-upload', 'Home::fileUpload');
$routes->get('/success', 'Home::success');
// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/artist/(:any)', 'Home::artist/$1');
$routes->get('/category/(:any)', 'Home::category/$1');
$routes->get('/search', 'Home::search');
$routes->get('/contact-us', 'Home::contact');
$routes->get('/terms-and-conditions', 'Home::terms_and_conditions');
$routes->get('/about', 'Home::about');
$routes->get('/privacy-policy', 'Home::privacy');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

//...  

// Add this to Footer, Including all module routes

$modules_path = APPPATH . 'Modules/';
$modules = scandir($modules_path);

foreach ($modules as $module) {
	if ($module === '.' || $module === '..') {
		continue;
	}

	if (is_dir($modules_path) . '/' . $module) {
		$routes_path = $modules_path . $module . '/Config/Routes.php';
		if (file_exists($routes_path)) {
			require $routes_path;
		} else {
			continue;
		}
	}
}
