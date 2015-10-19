<?php
	header("Content-type: text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

	$hook['display_override'][] = array(
		'class' => '',
		'function' => 'Compress',
		'filename' => 'Compress.php',
		'filepath' => 'Hooks'
	);