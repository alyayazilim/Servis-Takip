<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

class Ajax_istekleri extends CI_Controller {

	function __construct() {
		parent::__construct();
	}
	
	function fis_incele() {
		$glVeri = $this->input->post('fisNo');
		$veriler ="asd";
		echo $glVeri;
	}
	
	function yeni_fis_kayit() {
		$this->load->model('servis_model');
		$kayitVerileri = array(
			'is_numarasi'			=> $this->servis_model->yeniFisNoOlustur(),
			'gelis_tarihi'			=> time(),
			'musteri_adi'			=> $this->input->post('mus', TRUE),
			'musteri_adresi'		=> $this->input->post('adres', TRUE),
			'posta_kodu'			=> $this->input->post('sehir', TRUE).'000',
			'sehir'					=> $this->input->post('sehir', TRUE),
			'tel'						=> $this->input->post('tel', TRUE),
			'email'					=> $this->input->post('email', TRUE),
			'durum'					=> $this->input->post('durum', TRUE),
			'cihaz_tur'				=> $this->input->post('cihaz', TRUE),
			'marka'					=> $this->input->post('marka', TRUE),
			'urun_kodu'				=> $this->input->post('urunKodu', TRUE),
			'urun_adi'				=> $this->input->post('urunAdi', TRUE),
			'seri_no'				=> $this->input->post('seriNo', TRUE),
			'garanti_baslangic'	=> $this->servis_model->tarih2unix($this->input->post('garantiBaslangic', TRUE)),
			'garanti_belge_turu'	=> $this->input->post('belgeTuru', TRUE),
			'bildirilen_ariza'	=> $this->input->post('ariza', TRUE),
			'ariza_tanimi'			=> $this->input->post('arizaTanim', TRUE),
			'yapilan_islem'		=> $this->input->post('islemler', TRUE),
			'sayac_durumu'			=> $this->input->post('sayac', TRUE),
			'teslim_tarihi'		=> $this->servis_model->tarih2unix($this->input->post('teslimTarihi', TRUE)),
			'servis_sekli'			=> $this->input->post('servisSekli', TRUE),
			'gonderi_sekli'		=> $this->input->post('gonderiSekli', TRUE),
			'gonderi_dokuman'		=> $this->input->post('gonderiDokuman', TRUE),
			'gonderi_ucreti' 		=> $this->input->post('gonderiUcret', TRUE),
			'servis_ucreti' 		=> $this->input->post('gonderiUcret', TRUE),
			'servis_ucreti'		=> $this->input->post('servisUcret', TRUE),
			'pesinat'				=> $this->input->post('pesinat', TRUE)
		);
		$cevap = $this->servis_model->servisFisiKaydet($kayitVerileri, 'kayit', $kayitNo=FALSE);
		echo $cevap;
	}

	function servis_no_getir() {
		if($this->input->post('istek', TRUE) == 'yeni') {
			$this->load->model('servis_model');
			$yeniNo = $this->servis_model->yeniFisNoOlustur();
			echo $yeniNo;
		}
	}

	function servis_fisi_getir() {
		$fisNo = $this->input->post('fisNo', TRUE);
		if($this->input->post('istek', TRUE) == 'bilgi') {
			$this->load->model('servis_model');
			$veri = json_encode($this->servis_model->servisFisiGetir($fisNo), JSON_UNESCAPED_UNICODE);
			echo $veri;
		}
	}

	function fis_duzenle() {
		$this->load->model('servis_model');
		$kayitVerileri = array(
			'musteri_adi'			=> $this->input->post('mus', TRUE),
			'musteri_adresi'		=> $this->input->post('adres', TRUE),
			'posta_kodu'			=> $this->input->post('sehir', TRUE).'000',
			'sehir'					=> $this->input->post('sehir', TRUE),
			'tel'						=> $this->input->post('tel', TRUE),
			'email'					=> $this->input->post('email', TRUE),
			'durum'					=> $this->input->post('durum', TRUE),
			'marka'					=> $this->input->post('marka', TRUE),
			'cihaz_tur'				=> $this->input->post('cihaz', TRUE),
			'urun_kodu'				=> $this->input->post('urunKodu', TRUE),
			'urun_adi'				=> $this->input->post('urunAdi', TRUE),
			'seri_no'				=> $this->input->post('seriNo', TRUE),
			'garanti_baslangic'	=> $this->servis_model->tarih2unix($this->input->post('garantiBaslangic', TRUE)),
			'garanti_belge_turu'	=> $this->input->post('belgeTuru', TRUE),
			'bildirilen_ariza'	=> $this->input->post('ariza', TRUE),
			'ariza_tanimi'			=> $this->input->post('arizaTanim', TRUE),
			'yapilan_islem'		=> $this->input->post('islemler', TRUE),
			'sayac_durumu'			=> $this->input->post('sayac', TRUE),
			'teslim_tarihi'		=> $this->servis_model->tarih2unix($this->input->post('teslimTarihi', TRUE)),
			'servis_sekli'			=> $this->input->post('servisSekli', TRUE),
			'gonderi_sekli'		=> $this->input->post('gonderiSekli', TRUE),
			'gonderi_dokuman'		=> $this->input->post('gonderiDokuman', TRUE),
			'gonderi_ucreti'		=> $this->input->post('gonderiUcret', TRUE),
			'servis_ucreti'		=> $this->input->post('servisUcret', TRUE),
			'pesinat'				=> $this->input->post('pesinat', TRUE)
		);
		$sonuc = $this->servis_model->servisFisiGuncelle($kayitVerileri, $this->uri->segment(3));
		echo $sonuc;
	}

	function kullanici_getir() {
		$kullaniciNo = $this->input->post('kullaniciNo', TRUE);
		if($this->input->post('istek', TRUE) == 'bilgi') {
			$this->load->model('kullanici_model');
			$veri = json_encode($this->kullanici_model->kullanici_bilgi_getir($kullaniciNo), JSON_UNESCAPED_UNICODE);
			echo $veri;
		}
	}

	function yeni_kullanici_kayit() {
		$this->load->model('kullanici_model');
		$kayitVerileri = array(
			'k_adi'	=> $this->input->post('k_adi', TRUE),
			'sifre'	=> md5($this->input->post('sifre', TRUE)),
			'yetki'	=> $this->input->post('yetki', TRUE),
			'eposta'	=> $this->input->post('eposta', TRUE)
		);
		if($this->kullanici_model->kullaniciMukerrerKontrol($this->input->post('k_adi', TRUE)) == 0) {
			$cevap = $this->kullanici_model->yeniKullaniciKaydet($kayitVerileri);
		} else {
			$cevap = 0;	
		}
		echo $cevap;
	}

	function kullanici_duzenle() {
		$this->load->model('kullanici_model');
		$kayitVerileri = array(
			'k_adi'	=> $this->input->post('k_adi', TRUE),
			'sifre'	=> md5($this->input->post('sifre', TRUE)),
			'yetki'	=> $this->input->post('yetki', TRUE),
			'eposta'	=> $this->input->post('eposta', TRUE)
		);
		$sonuc = $this->kullanici_model->kullaniciGuncelle($kayitVerileri, $this->uri->segment(3));
		echo $sonuc;
	}

	function kullanici_kontrol() {
		$this->load->model("kullanici_model");
		$kontrol = $this->kullanici_model->kullanici_adres_bilgi_getir($this->input->post('musteri_adi', TRUE));
		if(count($kontrol)!=0) {
			$bilgi = "";
			foreach($kontrol AS $musteri) :
				$bilgi .= '<a class="ajaxMusteriListesi" href="javascript:;" onclick="kBilgiYaz('.$musteri->fis_no.');">'.$musteri->musteri_adi.' - '.$musteri->tel.' - '.$musteri->sehir.'</a>';
			endforeach;
			echo $bilgi;
		}

	}

	function kullanici_bilgi_json() {
		$this->load->model('kullanici_model');
		$veri = $this->kullanici_model->kullanici_bilgi_json($this->input->post('musteri_no', TRUE));
		echo json_encode($veri, JSON_UNESCAPED_UNICODE);
	}

	function cihaz_tur_mukerrermi() {
		$cihaz_turu	= $this->input->post('cihaz_turu', true);
		$this->load->model('sistem_model');
		$ctKontrol	= $this->sistem_model->cihaz_tur_mukerrermi($cihaz_turu);
		if($ctKontrol == 0) {
			$cevap = 'yok';
		} else {
			$cevap = 'var';
		}
		echo $cevap;
	}

	function cihaz_tur_ekle() {
		if($this->input->post('islem', true) == "ekle") {
			$obje = form_open_multipart('sistem_yonetimi/cihaz_tur_kaydet', 'name="cihazTurForm" id="cihazTurForm" class="yukle_form" onsubmit="return cihaz_tur_kaydet_kontrol();"')."\r\n";
			$obje .= form_input('cihaz_turu', set_value('cihaz_turu'), 'id="cihaz_turu" autocomplete="off" placeholder="Cihaz Türü" onkeyup="turMukerrerKontrol(this);"');
			$obje .= '<input type="file" id="tur_resim" name="tur_resim" class="griinput" accept="image/png" />'."\r\n";
			$obje .= form_submit('kaydetButon', 'Kaydet', 'id="kaydetButon"')."\r\n";
			$obje .= form_close()."\r\n";
			$obje .= @$formHatasi;
		} elseif($this->input->post('islem', true) == "duzenle") {
			$obje = 'Düzenlenecek';
		}
		echo $obje;
	}

}

/* ajax_istekleri.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/controllers/ajax_istekleri.php Adresinde Kayıtlı */