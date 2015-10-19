<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

	set_include_path(implode(PATH_SEPARATOR,
		[
			realpath(__DIR__ . '/libraries'),
			get_include_path()
		]
	));
	require_once "PHPExcel.php";

class Excel extends PHPExcel { 
	public function __construct() { 
		parent::__construct(); 
	}

}

/* Excel.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/libraries/Excel.php Adresinde Kayıtlı */