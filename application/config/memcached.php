<?php
header("Content-type: text/html; charset=utf-8");
if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

/*
| -------------------------------------------------------------------------
| Memcached settings
| -------------------------------------------------------------------------
| Your Memcached servers can be specified below.
|
|	See: http://codeigniter.com/user_guide/libraries/caching.html#memcached
|
*/
$config = array(
	'default' => array(
		'hostname' => '127.0.0.1',
		'port'     => '11211',
		'weight'   => '1',
	),
);
