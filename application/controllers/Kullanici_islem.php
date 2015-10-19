<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

class Kullanici_islem extends CI_Controller {

	function __construct() {
		parent::__construct();
		//$this->sistem_model->lisan_kontrol();
	}
	
	function kullanici_listele() {
		$veri = array(
			
			'gosterilecekSayfa'	=> 'kullanici_listele'
		);
		$this->load->view('taslak', $veri);
	}

}

/* kullanici_islem.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/controllers/kullanici_islem.php Adresinde Kayıtlı */