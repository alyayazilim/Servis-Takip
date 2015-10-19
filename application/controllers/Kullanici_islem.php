<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

class Kullanici_islem extends CI_Controller {

	function __construct() {
		parent::__construct();
		//$this->sistem_model->lisan_kontrol();
		$this->load->model('sistem_model');
		$this->sistemSabit = $this->sistem_model->sistemSabitleri();
	}
	
	function kullanici_listele() {
		$veri = array(
			'gosterilecekSayfa'	=> 'kullanici_listele'
		);
		$bilgi = array_merge($veri, $this->sistemSabit);
		$this->load->view('taslak', $bilgi);
	}

}

/* kullanici_islem.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/controllers/kullanici_islem.php Adresinde Kayıtlı */