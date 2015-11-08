<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

class Kullanici_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->mySunucu = $this->load->database('mySunucu', TRUE);
	}

	function kullanici_kontrol($kAdi) {
		$sorgu = 'SELECT k_adi FROM kullanicilar WHERE k_adi=?';
		$sonuc = $this->mySunucu->query($sorgu, $kAdi);
		return $sonuc->num_rows();
	}

	function sifre_kontrol($sifre, $kAdi) {
		$sorgu = 'SELECT k_adi FROM kullanicilar WHERE k_adi=? AND sifre=?';
		$sonuc = $this->mySunucu->query($sorgu, array($kAdi, $sifre));
		return $sonuc->num_rows();
	}

	function kullanici_giris($kAdi) {
		$sorgu = $this->mySunucu->QUERY('SELECT k_no, k_adi, yetki, eposta, FROM_UNIXTIME(son_giris, \'%d.%m.%Y - %H:%i\') AS son_giris
		FROM kullanicilar
		WHERE k_adi = "'.$kAdi.'"');
		foreach($sorgu->result() AS $sonuc) {
			$k_no			= $sonuc->k_no;
			$k_adi		= $sonuc->k_adi;
			$yetki		= $sonuc->yetki;
			$eposta		= $sonuc->eposta;
			$sonGiris	= $sonuc->son_giris;
		}

		$bilgi = array(
			'k_no'		=> $k_no,
			'k_adi'		=> $k_adi,
			'yetki'		=> $yetki,
			'eposta'		=> $eposta,
			'sonGiris'	=> $sonGiris
		);
		$this->session->set_userdata($bilgi);
		$this->session->unset_userdata('koruma');
		$this->mySunucu->query('DELETE FROM ci_sorgulari WHERE kullanici_no='.$k_no);
		$kayitBilgi = array(
			'son_giris'	=> time()
		);
		$this->mySunucu->where('k_adi', $kAdi);
		$this->mySunucu->update('kullanicilar', $kayitBilgi);
		return true;
	}

	function ara($sorguDizesi, $gosterilecekKayit, $offset, $neyeGoreSirala, $siralamaYonu) {
		$siralamaYonu		= $siralamaYonu=="desc" ? 'desc' : 'asc';
		$sort_colums		= array('k_adi','yetki','eposta','kayit_tarih','son_giris');
		$neyeGoreSirala	= (in_array($neyeGoreSirala, $sort_colums)) ? $neyeGoreSirala : 'k_adi';
		$veriSorgu	= $this->mySunucu->select('*')
			->from('kullaniciListesi')
			->limit($gosterilecekKayit, $offset)
			->order_by($neyeGoreSirala, $siralamaYonu);
		if(strlen($sorguDizesi['nerede'])) {
				$veriSorgu->like($sorguDizesi['nerede'], $sorguDizesi['deger'], 'both');
		}
		$kullanicilar = $veriSorgu->get()->result();
		$q = $this->mySunucu->select('COUNT(*) AS satirSayisi')
			->from('kullaniciSatirSayisi');
		if($sorguDizesi['nerede'] == 'sehir') {
			$veriSorgu->like($sorguDizesi['nerede'], $sorguDizesi['deger'], 'both');
		}
		$cevap = array(
			'kullanicilar'	=> $kullanicilar,
			'satirSayisi'	=> $q->get()->result()[0]->satirSayisi
		);
		return $cevap;
	}

	function yetki_getir() {
		$sorgu = $this->mySunucu->query('SELECT yetki_no, yetki_adi FROM yetkiler ORDER BY yetki_adi ASC');
		return $sorgu->result();
	}

	function kullanici_cikis($kullaniciNo) {
		$this->mySunucu->query('DELETE FROM ci_sorgulari WHERE kullanici_no='.$kullaniciNo);
		return true;
	}

	function kullanici_bilgi_getir($kullaniciNo) {
		$sorgu = $this->mySunucu->query('SELECT * FROM kullaniciListesi WHERE k_no='.$kullaniciNo);
		return $sorgu->result();
	}

	function yeniKullaniciKaydet($kayitVerileri) {
		$this->mySunucu->INSERT('kullanicilar', $kayitVerileri);
		return 1;
	}

	function kullaniciMukerrerKontrol($kAdi) {
		$sorgu = $this->mySunucu->query('SELECT k_adi
		FROM kullanicilar
		WHERE k_adi = "'.$kAdi.'"');
		return $sorgu->num_rows();
	}

	function kullaniciGuncelle($kayitVerileri, $k_no) {
		try {
			$this->mySunucu->WHERE('k_no', $k_no);
			$this->mySunucu->UPDATE('kullanicilar', $kayitVerileri);
			return true;
		} catch(Exception $hata) {
			return $hata->getMessage();
		}
	}

	function kullaniciSil($k_no) {
		try {
			$this->mySunucu->where('k_no', $k_no);
			$this->mySunucu->delete('kullanicilar');
			return true;
		} catch(Exception $hata) {
			return $hata->getMessage();
		}
	}

	function kullanici_adres_bilgi_getir($kAdi) {
		$sorgu = $this->mySunucu->query('SELECT * FROM ajaxMusteriBilgi WHERE musteri_adi like "%'.$kAdi.'%"');
		return $sorgu->result();
	}

	function kullanici_bilgi_json($fNo) {
		$sorgu = $this->mySunucu->query('SELECT musteri_adi, musteri_adresi, sehir, tel, email FROM servis_fis WHERE fis_no='.$fNo);
		return $sorgu->result();
	}

	function kullanici_seri_no_bilgi($seriNo, $fisNo) {
		$sorgu = 'SELECT SF.fis_no, SF.musteri_adi, SF.musteri_adresi, SF.posta_kodu, SF.sehir, IL.il_adi AS il, SF.tel, SF.email, SF.marka, SF.cihaz_tur, SF.urun_kodu, SF.urun_adi, date_format(from_unixtime(SF.garanti_baslangic),"%d.%m.%Y") AS garanti_baslangic, SF.garanti_belge_turu, SF.seri_no,SF.sayac_durumu
		FROM servis_fis AS SF
			LEFT JOIN iller AS IL ON SF.sehir = IL.il_no';
		if($seriNo != false) {
			$sorgu .= ' WHERE SF.seri_no LIKE "%'.$seriNo.'%"';
		} elseif($fisNo != false) {
			$sorgu .= ' WHERE SF.fis_no='.$fisNo;
		}
		$sorgu .= ' GROUP BY SF.musteri_adi';
		$sonuc = $this->mySunucu->QUERY($sorgu);
		return $sonuc->result();
	}

	function sifre_degistir($kullaniciAdi, $sifre) {
		$kayitBilgi = array(
			'sifre'	=> md5($sifre)
		);
		$this->mySunucu->WHERE('k_adi', $kullaniciAdi);
		$this->mySunucu->UPDATE('kullanicilar', $kayitBilgi);
		return true;
	}

}

/* kullanici_model.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/models/kullanici_model.php Adresinde Kayıtlı */