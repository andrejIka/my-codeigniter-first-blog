<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Here's the posts routes
$route['posts/(:num)'] = 'posts/index/$1';
$route['posts/add_post'] = 'posts/add_post';
$route['posts/edit_post/(:num)'] = 'posts/edit_post/$1';
$route['posts/delete_post/(:num)'] = 'posts/delete_post/$1';
$route['posts/export_posts'] = 'posts/export_posts/$1';
$route['posts/search'] = 'posts/search';

// Calendar routes
$route['calendar/(:num)/(:num)'] = 'calendar/index/$1';
$route['calendar/remove/(:num)/(:num)'] = 'calendar/remove/$1';
$route['calendar/calendar_tasks/'] = 'calendar/calendar_tasks/$1';

// Upload images routes
$route['upload'] = 'upload';
$route['upload/delete_image/(:any)'] = 'upload/delete_image/$1';

// Authentification
// $route['auth'] = 'auth/index/$1';
$route['auth/(.*)'] = 'users/auth/$1';
// $route['upload/(:any)'] = 'upload/index/$1';
// $route['add_post.php'] = 'posts/add_post';
// $route['(:any)'] = 'pages/view/$1';
// $route['default_controller'] = 'pages/view';

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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "posts";
$route['404_override'] = '';
// $route['404_override'] = 'welcome';


/* End of file routes.php */
/* Location: ./application/config/routes.php */