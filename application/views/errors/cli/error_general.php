<?php
header("Content-type: text/html; charset=utf-8");
if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

echo "\nERROR: ",
	$heading,
	"\n\n",
	$message,
	"\n\n";