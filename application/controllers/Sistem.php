<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

class Kullanici extends CI_Controller {

	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$this->listele();
	}

	function listele($sorguNo=0, $neyeGoreSirala='is_numarasi', $siralamaYonu='desc', $offset=0) {
		$gosterilecekKayit = 25;
		$this->input->sorguGetir($sorguNo);
		$veri = array(
			'alanlar'			=>array(
				'k_adi'			=> 'Kullanıcı Adı',
				'yetki'			=> 'Yetki',
				'eposta'			=> 'Email',
				'kayit_tarih'	=> 'Kayıt Tarihi',
				'son_giris'		=> 'Son Giriş'
			),
			'fisler'			=> $veriler['fisler'],
			'toplamKayit'	=> $veriler['satirSayisi'],
			'sayfalama'		=>	$this->pagination->create_links(),
			'siraSekil'		=> $siralamaYonu,
			'sirala'			=> $neyeGoreSirala,
			'aramaAlan'		=> array(
				''					=> 'Arama Alanı Seç',
				'k_adi'			=> 'Kullanıcı Adı',
				'yetki'			=> 'Yetki',
				'eposta'			=> 'Email',
				'kayit_tarih'	=> 'Kayıt Tarihi',
				'son_giris'		=> 'Son Giriş'
			),
			'gosterilecekSayfa'	=> 'sistem_ayar'
		);
		$this->load->view('taslak', $veri);
	}

}

/* Sistem.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/controllers/Sistem.php Adresinde Kayıtlı */