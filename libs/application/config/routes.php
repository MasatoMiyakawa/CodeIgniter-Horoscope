<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['404_override'] = '';

//ranking
$route['default_controller'] = "horoscope_ranking";
$route['top3'] = "horoscope_ranking/getTop3";

//constellations
$route['aries'] = "horoscope_detail";
$route['taurus'] = "horoscope_detail";
$route['gemini'] = "horoscope_detail";
$route['cancer'] = "horoscope_detail";
$route['leo'] = "horoscope_detail";
$route['virgo'] = "horoscope_detail";
$route['libra'] = "horoscope_detail";
$route['scorpio'] = "horoscope_detail";
$route['sagittarius'] = "horoscope_detail";
$route['capricornus'] = "horoscope_detail";
$route['aquarius'] = "horoscope_detail";
$route['pisces'] = "horoscope_detail";

//daily
$route['aries/(:num)'] = "horoscope_detail/index/$1";
$route['taurus/(:num)'] = "horoscope_detail/index/$1";
$route['gemini/(:num)'] = "horoscope_detail/index/$1";
$route['cancer/(:num)'] = "horoscope_detail/index/$1";
$route['leo/(:num)'] = "horoscope_detail/index/$1";
$route['virgo/(:num)'] = "horoscope_detail/index/$1";
$route['libra/(:num)'] = "horoscope_detail/index/$1";
$route['scorpio/(:num)'] = "horoscope_detail/index/$1";
$route['sagittarius/(:num)'] = "horoscope_detail/index/$1";
$route['capricornus/(:num)'] = "horoscope_detail/index/$1";
$route['aquarius/(:num)'] = "horoscope_detail/index/$1";
$route['pisces/(:num)'] = "horoscope_detail/index/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */