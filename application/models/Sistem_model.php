<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

class Sistem_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->mySunucu = $this->load->database('mySunucu', TRUE);
	}

	function sistemSabitleri() {
		$firmaBilgi = $this->mySunucu->query('SELECT ayar_degerler FROM sistem_ayar WHERE ayar_no=1');
		foreach($firmaBilgi->result() AS $fBilgi) :
			$fBilgiArray = unserialize($fBilgi->ayar_degerler);
			/*$fBilgiArr = array(
				'firma_adi'		=> $fBilgiArray->firma_adi,
				'mail'			=> $fBilgiArray->mail,
				'il'				=> $fBilgiArray->il,
				'firma_logo'	=> $fBilgiArray->firma_logo
			);*/
		endforeach;
		return $fBilgiArray;
	}

	function firmaBilgileriGetir() {
		$sorgu = $this->mySunucu->query('SELECT ayar_degerler FROM sistem_ayar WHERE ayar_adi="firma_bilgileri"');
		return $sorgu->result();
	}

	function turBilgileriGetir($turNo) {
		$sorgu = $this->mySunucu->query('SELECT tur_adi, tur_resim FROM cihaz_tur WHERE tur_no='.$turNo);
		return $sorgu->result();
	}

	function firmaBilgiGuncelle($kayitVerileri) {
		$this->mySunucu->WHERE('ayar_no', 1);
		$this->mySunucu->UPDATE('sistem_ayar', $kayitVerileri);
		return true;
	}

	function cihazTurGuncelle($turNo, $kayitVerileri) {
		$this->mySunucu->WHERE('tur_no', $turNo);
		$this->mySunucu->UPDATE('cihaz_tur', $kayitVerileri);
		return true;
	}

	function cihazTurResmiGetir($turNo) {
		$sorgu = $this->mySunucu->query('SELECT tur_resim FROM cihaz_tur WHERE tur_no='.$turNo);
		foreach($sorgu->result() AS $bilgi) :
			$resim = $bilgi->tur_resim;
		endforeach;
		return $resim;
	}

	function cihazMarkaResmiGetir($markaNo) {
		$sorgu = $this->mySunucu->query('SELECT marka_resim FROM markalar WHERE marka_no='.$markaNo);
		foreach($sorgu->result() AS $bilgi) :
			$resim = $bilgi->marka_resim;
		endforeach;
		return $resim;
	}

	function cihaz_tur_sil($turNo) {
		$this->mySunucu->WHERE('tur_no', $turNo);
		$this->mySunucu->DELETE('cihaz_tur');
		return true;
	}

	function cihaz_marka_sil($markaNo) {
		$this->mySunucu->WHERE('marka_no', $markaNo);
		$this->mySunucu->DELETE('markalar');
		return true;
	}

	function cihazTurKaydet($kayitVerileri) {
		$this->mySunucu->INSERT('cihaz_tur', $kayitVerileri);
		return true;
	}

	function cihaz_tur_mukerrermi($cihaz_turu) {
		$sorgu = $this->mySunucu->query('SELECT tur_adi FROM cihaz_tur WHERE tur_adi = "'.$cihaz_turu.'"');
		return $sorgu->num_rows();
	}

	function markaBilgileriGetir($markaNo) {
		$sorgu = $this->mySunucu->query('SELECT marka_adi, marka_resim FROM markalar WHERE marka_no='.$markaNo);
		return $sorgu->result();
	}

}

/* Sistem_model.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/models/Sistem_model.php Adresinde Kayıtlı */