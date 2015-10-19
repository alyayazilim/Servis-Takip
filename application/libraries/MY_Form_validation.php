<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

class MY_Form_validation extends CI_Form_validation {

	public function __construct() {
		parent::__construct();
		$this->_error_prefix = '<div class="formHatasi">';
		$this->_error_suffix = '</div>';
	}
}

/* MY_Form_validation.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/core/MY_Form_validation.php Adresinde Kayıtlı */