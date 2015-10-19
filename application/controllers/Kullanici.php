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
		$sorguDizesi = array(
			'araBas'	=> $this->input->get('araBas'),
			'araBit'	=> $this->input->get('araBit'),
			'nerede'	=> $this->input->get('nerede'),
			'deger'	=> $this->input->get('deger')
		);
		$this->load->model('kullanici_model');		
		$veriler = $this->kullanici_model->ara($sorguDizesi, $gosterilecekKayit, $offset, $neyeGoreSirala, $siralamaYonu);
		$this->load->library('pagination');
		$ayar = array(
			'uri_segment'	=> 6,
			'base_url'		=> site_url('kulllanici/listele/'.$sorguNo.'/'.$neyeGoreSirala.'/'.$siralamaYonu),
			'total_rows'	=> $veriler['satirSayisi'],
			'per_page'		=> $gosterilecekKayit,
			'num_links'		=> 5
		);
		$this->pagination->initialize($ayar);
		$veri = array(
			'alanlar'			=>array(
				'k_adi'			=> 'Kullanıcı Adı',
				'yetki'			=> 'Yetki',
				'eposta'			=> 'Email',
				'kayit_tarih'	=> 'Kayıt Tarihi',
				'son_giris'		=> 'Son Giriş'
			),
			'sorguNo'		=> $sorguNo,
			'kullanicilar'	=> $veriler['kullanicilar'],
			'toplamKayit'	=> $veriler['satirSayisi'],
			'sayfalama'		=>	$this->pagination->create_links(),
			'siraSekil'		=> $siralamaYonu,
			'sirala'			=> $neyeGoreSirala,
			'aramaAlan'		=> array(
				''					=> 'Arama Alanı Seç',
				'k_adi'			=> 'Kullanıcı Adı',
				'yetki'			=> 'Yetki',
				'eposta'			=> 'Email',
				'son_giris'		=> 'Son Giriş'
			),
			'yetkiler'				=> $this->kullanici_model->yetki_getir(),
			'gosterilecekSayfa'	=> 'kullanici_listele'
		);
		$this->load->view('taslak', $veri);
	}

	function kullanici_sil() {
		$this->load->model('kullanici_model');
		$cevap = $this->kullanici_model->kullaniciSil($this->uri->segment(3));
		redirect($this->agent->referrer());
	}

}

/* Sistem.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/controllers/Kullanici.php Adresinde Kayıtlı */