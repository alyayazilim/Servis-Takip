<?php
header("Content-type: text/html; charset=utf-8");
if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

echo "\nDatabase error: ",
	$heading,
	"\n\n",
	$message,
	"\n\n";