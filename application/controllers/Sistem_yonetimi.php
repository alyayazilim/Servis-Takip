<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

class Sistem_yonetimi extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('sistem_model');
		$this->sistemSabit = $this->sistem_model->sistemSabitleri();
	}
	
	function index() {
		redirect('sistem_yonetimi/sistem_ayar');
	}

	function guvenlik_resmi() {
		$sifre = substr(md5(rand(0,999999999999)),-5);
		if($sifre) {
			$this->session->set_userdata('koruma', $sifre);
			$yukseklik	= 62;
			$genislik	= 200;
			$resim 	= ImageCreate($genislik, $yukseklik);
			$siyah	= ImageColorAllocate($resim, 0, 0, 0);
			$kirmizi = ImageColorAllocate($resim, 182, 16, 99);
			$beyaz	= ImageColorAllocate($resim, 255, 255, 255);
			ImageFill($resim, 0, 0, $beyaz);
			$font = 'css/comic.ttf';
			$font_boyut = 24;
			$sM			= 30;
			$uM			= 45;
			//kullanımı
			//resim adı, font boyutu, yazının açısı, yazının soldan margini, üstten margin, renk, font adı, şifrenin hangi digitinin yazılacağı bellirtiliyor
			imagettftext($resim,	$font_boyut,	rand(-45,45),	$sMa = $sM,			$uM, rand(0,255),	$font,	$sifre[0]);
			imagettftext($resim, $font_boyut,	rand(-45,45),	$sM = $sMa + $sM,	$uM, rand(0,255),	$font,	$sifre[1]);
			imagettftext($resim, $font_boyut,	rand(-45,45),	$sM = $sMa + $sM,	$uM, rand(0,255), $font,	$sifre[2]);
			imagettftext($resim, $font_boyut,	rand(-45,45),	$sM = $sMa + $sM,	$uM, rand(0,255),	$font,	$sifre[3]);
			imagettftext($resim, $font_boyut,	rand(-45,45),	$sM = $sMa + $sM,	$uM, rand(0,255),	$font,	$sifre[4]);
			//ImageRectangle($resim, 0, 0, $genislik-1, $yukseklik-1, $kirmizi);
			imageline($resim, 0, $yukseklik/2, $genislik, $yukseklik/2, $kirmizi);
			imageline($resim, $genislik/2, 0, $genislik/2, $yukseklik, $kirmizi);
			header("Content-Type: image/png");
			ImagePng($resim);
			ImageDestroy($resim);
		}
		exit;
	}

	function sistem_ayar() {
		$veri = array(
			'gosterilecekSayfa'	=> 'sistem_ayar'
		);
		$bilgi = array_merge($veri, $this->sistemSabit);
		$this->load->view('taslak', $bilgi);
	}

	function bakim_calismasi() {
		$this->load->view('bakim_calismasi');
	}

	function sistem_degisken() {
		$this->load->model('sistem_model');
		$firmaBilgi = $this->sistem_model->firmaBilgileriGetir();
		foreach($firmaBilgi AS $fBilgi) :
			$frBilgi		= unserialize($fBilgi->ayar_degerler);
			$firmaAdi	= $frBilgi['firma_adi'];
			$firmaMail	= $frBilgi['mail'];
			$firmaIli	= $frBilgi['il'];
			$firmaLogo	= $frBilgi['firma_logo'];
		endforeach;
		$veri = array(
			'firma_adi'		=> $firmaAdi,
			'firma_mail'	=> $firmaMail,
			'firma_il'		=> $firmaIli,
			'firma_logo'	=> $firmaLogo,
			'formHatasi'	=> '',
			'gosterilecekSayfa'	=> 'sistem_degisken'
		);
		$bilgi = array_merge($veri, $this->sistemSabit);
		$this->load->view('taslak', $bilgi);
	}

	function sistem_degisken_kontrol() {
		$this->form_validation->set_rules('firma_adi', 'Firma Adı', 'trim|required|xss_clean|min_length[5]');
		$this->form_validation->set_rules('firma_mail', 'Mail Adresi', 'trim|required|xss_clean|min_length[5]|valid_email');
		$this->form_validation->set_rules('firma_il', 'Firma İli', 'trim|required|xss_clean|min_length[3]');
		if($this->form_validation->run() == false) {
			$this->sistem_degisken();
		} else {
			$this->load->model('sistem_model');
			$firmaBilgi = $this->sistem_model->firmaBilgileriGetir();
			foreach($firmaBilgi AS $fBilgi) :
				$frBilgi		= unserialize($fBilgi->ayar_degerler);
				$firmaLogo	= $frBilgi['firma_logo'];
			endforeach;
			if($_FILES['firma_resim']['name']) {
				unlink('resimler/firma/'.$firmaLogo);
				$this->load->model('servis_model');
				$yeniDosyaAdi = $this->servis_model->dosyaAdiOlustur($ozNetlik=FALSE, $_FILES['firma_resim']['name']);
				$ayar = array(
					'upload_path'		=> 'resimler/firma',
					'allowed_types'	=> 'png',
					'file_name'			=> $yeniDosyaAdi
				);
				$this->load->library('upload', $ayar);
				if(!$this->upload->do_upload('firma_resim')) {
					echo $this->upload->display_errors('<div class="formHatasi">', '</div>');
				}
				$firmaBilgi = array(
					'firma_adi'		=> $this->input->post('firma_adi', TRUE),
					'mail'			=> $this->input->post('firma_mail', TRUE),
					'il'				=> $this->input->post('firma_il', TRUE),
					'firma_logo'	=> $yeniDosyaAdi
				);
			} else {
				$firmaBilgi = array(
					'firma_adi'		=> $this->input->post('firma_adi', TRUE),
					'mail'			=> $this->input->post('firma_mail', TRUE),
					'il'				=> $this->input->post('firma_il', TRUE),
					'firma_logo'	=> $firmaLogo
				);
			}
			$kayitVerileri = array(
				'ayar_degerler'	=> serialize($firmaBilgi)
			);
			$this->load->model('sistem_model');
			$this->sistem_model->firmaBilgiGuncelle($kayitVerileri);
			redirect('sistem_yonetimi/sistem_degisken');
		}
	}

	function cihaz_tur() {
		$this->load->model('servis_model');
		$veri = array(
			'turVerileri'			=> $this->servis_model->cihazTurleri(),
			'gosterilecekSayfa'	=> 'cihaz_tur'
		);
		$bilgi = array_merge($veri, $this->sistemSabit);
		$this->load->view('taslak', $bilgi);
	}

	function markalar() {
		$this->load->model('servis_model');
		$veri = array(
			'markaVerileri'		=> $this->servis_model->markalar(),
			'gosterilecekSayfa'	=> 'markalar'
		);
		$bilgi = array_merge($veri, $this->sistemSabit);
		$this->load->view('taslak', $bilgi);
	}

	function gorsel_ayar() {
		$veri = array(
			'gosterilecekSayfa'	=> 'gorsel_ayar'
		);
		$bilgi = array_merge($veri, $this->sistemSabit);
		$this->load->view('taslak', $bilgi);
	}

	function kullanici_ayar() {
		$veri = array(
			'gosterilecekSayfa'	=> 'kullanici_ayar'
		);
		$bilgi = array_merge($veri, $this->sistemSabit);
		$this->load->view('taslak', $bilgi);
	}

	function yonetici_ayar() {
		$veri = array(
			'gosterilecekSayfa'	=> 'yonetici_ayar'
		);
		$bilgi = array_merge($veri, $this->sistemSabit);
		$this->load->view('taslak', $bilgi);
	}

	function cihaz_tur_duzenle() {
		$this->load->model('servis_model');
		$cBilgiler = $this->servis_model->cihazTurleri($this->input->post('tur_no', true));
		foreach($cBilgiler AS $cBilgi) :
			$turResmi = $cBilgi->tur_resim;
		endforeach;
		if($_FILES['tur_resim']['name']) {
			unlink('resimler/cihazlar/'.$turResmi);
			$yeniDosyaAdi = $this->servis_model->dosyaAdiOlustur($ozNetlik=FALSE, $_FILES['tur_resim']['name']);
			$ayar = array(
				'upload_path'		=> 'resimler/cihazlar',
				'allowed_types'	=> 'png',
				'file_name'			=> $yeniDosyaAdi
			);
			$this->load->library('upload', $ayar);
			if(!$this->upload->do_upload('tur_resim')) {
				echo $this->upload->display_errors('<div class="formHatasi">', '</div>');
			}
			$cTurBilgi	= array(
				'tur_adi'		=> $this->input->post('tur_adi', TRUE),
				'tur_resim'		=> $yeniDosyaAdi
			);
		} else {
			$cTurBilgi	= array(
				'tur_adi'		=> $this->input->post('tur_adi', TRUE),
				'tur_resim'		=> $turResmi
			);
		}
		$this->load->model('sistem_model');
		$this->sistem_model->cihazTurGuncelle($this->input->post('tur_no', true), $cTurBilgi);
		redirect('sistem_yonetimi/cihaz_tur');
	}

	function cihaz_tur_kaydet() {
		$this->load->model('servis_model');
		if($_FILES['tur_resim']['name']) {
			$yeniDosyaAdi = $this->servis_model->dosyaAdiOlustur($ozNetlik=FALSE, $_FILES['tur_resim']['name']);
			$ayar = array(
				'upload_path'		=> 'resimler/cihazlar',
				'allowed_types'	=> 'png',
				'file_name'			=> $yeniDosyaAdi
			);
			$this->load->library('upload', $ayar);
			if(!$this->upload->do_upload('tur_resim')) {
				echo $this->upload->display_errors('<div class="formHatasi">', '</div>');
			}
			$cTurBilgi	= array(
				'tur_adi'		=> $this->input->post('cihaz_turu', TRUE),
				'tur_resim'		=> $yeniDosyaAdi
			);
		}
		$this->load->model('sistem_model');
		$this->sistem_model->cihazTurKaydet($cTurBilgi);
		redirect('sistem_yonetimi/cihaz_tur');
	}

	function cihaz_tur_sil() {
		$turNo = $this->uri->segment(3);
		$this->load->model('sistem_model');
		$resimAdi = $this->sistem_model->cihazTurResmiGetir($turNo);
		unlink('resimler/cihazlar/'.$resimAdi);
		$this->sistem_model->cihaz_tur_sil($turNo);
		redirect('sistem_yonetimi/cihaz_tur');
	}

	function marka_sil() {
		$markaNo = $this->uri->segment(3);
		$this->load->model('sistem_model');
		$resimAdi = $this->sistem_model->cihazMarkaResmiGetir($markaNo);
		unlink('resimler/markalar/'.$resimAdi);
		$this->sistem_model->cihaz_tur_sil($turNo);
		redirect('sistem_yonetimi/markalar');
	}

}

/* sistem_yonetimi.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/controllers/Sistem_yonetimi.php Adresinde Kayıtlı */