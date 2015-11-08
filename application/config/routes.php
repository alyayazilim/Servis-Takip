<?php header("Content-type: text/html; charset=utf-8");
if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

	$route['default_controller']				= 'servis';
	$route['giris']			 					= 'servis/giris';
	$route['sifre_degistir']			 		= 'sistem_yonetimi/sifre_degistir';
	$route['bakim_calismasi']					= 'sistem_yonetimi/bakim_calismasi';
	$route['(.*)/ajax_istekleri/(:any)'] 	= "ajax_istekleri/$2";
	$route['(.*)/dosyalar/(:any)'] 			= "dosyalar/$2";
	$route['(.*)/ara/(:any)'] 					= "ara/$2";
	$route['404_override']						= '';
	$route['translate_uri_dashes']			= FALSE;