<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/* admin Routes */
$route['admin'] = 'admin/admin/login';
$route['admin/parts'] = 'admin/projects/parts';
$route['admin/students'] = 'admin/users';

$route['admin/submissions'] = 'admin/submissions';
$route['admin/submissions/view/(:any)'] = 'admin/submissions/view/$1';
$route['admin/projects/parts'] = 'admin/parts';

$route['admin/projects/parts/update/(:any)/(:any)/(:any)/(:any)'] = 'admin/parts/update/$1/$2/$3/$4';
$route['admin/projects/parts/(:any)/(:any)/(:any)'] = 'admin/parts/$1/$2/$3';
$route['admin/projects/parts/(:any)/(:any)'] = 'admin/parts/$1/$2';
$route['admin/projects/parts/(:any)/(:any)/(:any)/(:any)'] = 'admin/parts/$1/$2/$3/$4';

$route['admin/category/create'] = 'admin/projects/createCategory';
$route['admin/projects'] = 'admin/projects';
$route['admin/projects/(:any)'] = 'admin/projects/$1';
$route['admin/(:any)'] = 'admin/admin/$1';
/*end of admin routes*/

/* API routes*/

$route['api/projects/enrolled'] = "api/projects/isEnrolled/";
$route['api/projects/enrolled/(:any)'] = "api/projects/isEnrolled/$1";
$route['api/projects/parts/task/submit'] = "api/projects/submitTask";
$route['api/projects/parts/(:any)/(:any)'] = "api/projects/part/$1/$2";
$route['api/projects/parts'] = "api/projects/part";
$route['api/projects/(:any)'] = "api/projects/$1";
$route['api/users/activate'] = "api/user/activate";
$route['api/users/(:any)'] = "api/user/(:any)";
$route['api'] = "api/api";


/*end of API routes*/


$route['default_controller'] = 'welcome';
//$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
