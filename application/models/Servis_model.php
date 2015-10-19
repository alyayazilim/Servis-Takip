<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

class Servis_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->mySunucu = $this->load->database('mySunucu', true);
	}

	function tarih2unix($tarih=NULL) {
		return strtotime($tarih);
	}

	function unix2tarih($uTarih=NULL) {
		return date('d.m.Y', $uTarih);
	}

	function dosyaAdiOlustur($ozNetlik=FALSE, $dosyaAdi=FALSE) {
		if($ozNetlik == TRUE) {
			$dosya1 = md5(time()).md5(time()+1);
			$yeniDosyaAdi = $dosya1;
		} else {
			$dosya1 = md5(time()).md5(time()+1);
			$dizi = explode(".", $dosyaAdi);
			$sayi = count($dizi);
			$yeniDosyaAdi = $dosya1.".".$dizi[$sayi-1];
		}
		return urlencode($yeniDosyaAdi);
	}

	function ara($sorguDizesi, $gosterilecekKayit, $offset, $neyeGoreSirala, $siralamaYonu) {
		$siralamaYonu		= $siralamaYonu=="desc" ? 'desc' : 'asc';
		$sort_colums	= array('is_numarasi','gelis_tarihi','musteri_adi','durum','tur_no','marka','tur_adi','urun_kodu','urun_adi', 'seri_no');
		$neyeGoreSirala			= (in_array($neyeGoreSirala, $sort_colums)) ? $neyeGoreSirala : 'is_numarasi';
		$veriSorgu	= $this->mySunucu->select('*')
			->from('fis_bul')
			->limit($gosterilecekKayit, $offset)
			->order_by($neyeGoreSirala, $siralamaYonu);
		if(strlen($sorguDizesi['araBas'])) {
			$veriSorgu->where('FROM_UNIXTIME(gelis_tarihi, \'%d.%m.%Y\')>=', $sorguDizesi['araBas']-1);
		}
		if(strlen($sorguDizesi['araBit'])) {
			$veriSorgu->where('FROM_UNIXTIME(gelis_tarihi, \'%d.%m.%Y\')<=', $sorguDizesi['araBit']);
		}
		if(strlen($sorguDizesi['nerede'])) {
			if($sorguDizesi['nerede'] == 'sehir') {
				$veriSorgu->like('sehir', $sorguDizesi['deger'], 'both');
			} else {
				$veriSorgu->like($sorguDizesi['nerede'], $sorguDizesi['deger']);
			}
		}
		$fisler = $veriSorgu->get()->result();

		$q = $this->mySunucu->select('COUNT(*) AS satirSayisi')
			->from('servis_fis AS SF')
			->join('iller AS IL', 'SF.sehir = IL.il_no', 'left')
			->where('sil !=', 1);
		if(strlen($sorguDizesi['araBas'])) {
			$q->where('FROM_UNIXTIME(gelis_tarihi, \'%d.%m.%Y\')>=', $sorguDizesi['araBas']-1);
		}
		if(strlen($sorguDizesi['araBit'])) {
			$q->where('FROM_UNIXTIME(gelis_tarihi, \'%d.%m.%Y\')<=', $sorguDizesi['araBit']);
		}
		if(strlen($sorguDizesi['nerede'])) {
			if($sorguDizesi['nerede'] == 'sehir') {
				$veriSorgu->like('IL.il_adi', $sorguDizesi['deger'], 'both');
			} else {
				$veriSorgu->like($sorguDizesi['nerede'], $sorguDizesi['deger'], 'both');
			}		}
		$cevap = array(
			'fisler'			=> $fisler,
			'satirSayisi'	=> $q->get()->result()[0]->satirSayisi
		);
		return $cevap;
	}

	function fisler($urisi=FALSE, $limit=FALSE, $sayfa_sayisi=FALSE) {
		$sorgu = 'SELECT * FROM servis_listesi';
		if(!$urisi) {
			$urisi = 0;
		}
		if(!$sayfa_sayisi) {
			$sorgu .= "\r\n".' LIMIT '.$urisi.', '.$limit;
			$sorgu = $this->mySunucu->QUERY($sorgu);
			return $sorgu->result();
		} else {
			$sorgu = $this->mySunucu->QUERY($sorgu);
			return $sorgu->num_rows();
		}
	}

	function yeniFisNoOlustur() {
		$sorgu = $this->mySunucu->query('SELECT is_numarasi FROM servis_fis ORDER BY is_numarasi DESC LIMIT 0,1');
		foreach($sorgu->result() AS $no) {
			$isNo = $no->is_numarasi;
		}
		$isNo = substr($isNo, 5, 4);
		return date('y', time()).'-KT'.str_pad($isNo+1, 4, "0", STR_PAD_LEFT);
	}

	function markalar($markaNo=false) {
		if($markaNo==false) {
			$sorgu = $this->mySunucu->query('SELECT marka_no, marka_adi, marka_resim FROM markalar ORDER BY marka_adi ASC');
		} else {
			$sorgu = $this->mySunucu->query('SELECT marka_no, marka_adi, marka_resim FROM markalar WHERE marka_no='.$markaNo.' ORDER BY marka_adi ASC');
		}
		return $sorgu->result();
	}

	function durumlar() {
		$sorgu = $this->mySunucu->query('SELECT durum_no, durum_aciklama FROM durumlar ORDER BY durum_aciklama ASC');
		return $sorgu->result();
	}

	function cihazTurleri($turNo=false) {
		if($turNo==false) {
			$sorgu = $this->mySunucu->query('SELECT tur_no, tur_adi, tur_resim FROM cihaz_tur ORDER BY tur_no ASC');
		} else {
			$sorgu = $this->mySunucu->query('SELECT tur_no, tur_adi, tur_resim FROM cihaz_tur WHERE tur_no='.$turNo.' ORDER BY tur_no ASC');
		}
		return $sorgu->result();
	}

	function iller() {
		$sorgu = $this->mySunucu->query('SELECT * FROM iller ORDER BY il_adi ASC');
		return $sorgu->result();
	}

	function servis_sekilleri() {
		$sorgu = $this->mySunucu->query('SELECT * FROM servis_tur ORDER BY servis_tur_adi ASC');
		return $sorgu->result();
	}

	function gonderi_sekilleri() {
		$sorgu = $this->mySunucu->query('SELECT * FROM gonderi_sekil ORDER BY gonderi_aciklama ASC');
		return $sorgu->result();
	}

	function servisFisiKaydet($veri=FALSE, $islem=FALSE, $fisNo=FALSE) {
		if($islem == 'kayit') {
			$this->mySunucu->INSERT('servis_fis', $veri);
		} elseif($islem == 'guncelle') {
			$this->mySunucu->WHERE('fis_no', $fisNo);
			$this->mySunucu->UPDATE('servis_fis', $veri);
		} else {
			$silVeri = array('sil' => 1);
			$this->mySunucu->WHERE('fis_no', $fisNo);
			$this->mySunucu->UPDATE('servis_fis', $silVeri);
		}
		return true;
	}

	function servisFisiGuncelle($veri, $fisNo) {
		try {
			$this->mySunucu->WHERE('fis_no', $fisNo);
			$this->mySunucu->UPDATE('servis_fis', $veri);
			return true;
		} catch(Exception $hata) {
			return $hata->getMessage();
		}
	}

	function servisFisiGetir($fisNo) {
		$sorgu = $this->mySunucu->query("SELECT * FROM servis_fis_getir WHERE fis_no=".$fisNo);
		return $sorgu->result();
	}

	function excelIcinVeriHazirla($sorguNo) {
		$this->input->sorguGetir($sorguNo);
		$sorguDizesi = array(
			'araBas'	=> $this->input->get('araBas'),
			'araBit'	=> $this->input->get('araBit'),
			'nerede'	=> $this->input->get('nerede'),
			'deger'	=> $this->input->get('deger')
		);
		$siralamaYonu		= $siralamaYonu=="desc" ? 'desc' : 'asc';
		$veriSorgu	= $this->mySunucu->select('*')->from('excel_sorgu');
		if(strlen($sorguDizesi['nerede'])) {
			if($sorguDizesi['nerede'] == 'sehir') {
				$veriSorgu->like('sehir', $sorguDizesi['deger'], 'both');
			} else {
				$veriSorgu->like($sorguDizesi['nerede'], $sorguDizesi['deger']);
			}
		}
		return $veriSorgu->get()->result();
	}

	function plakaGetir($sehirAdi) {
		$sorgu = $this->mySunucu->query('SELECT il_no FROM iller WHERE il_adi LIKE "%'.$sehirAdi.'%" LIMIT 0,1;');
		foreach($sorgu->result() AS $sonuc) :
			$plaka = $sonuc->il_no;
		endforeach;
		return $plaka;
	}
	
	function postaKoduGetir($sehirAdi) {
		$sorgu = $this->mySunucu->query('SELECT il_no FROM iller WHERE il_adi LIKE "%'.$sehirAdi.'%" LIMIT 0,1;');
		foreach($sorgu->result() AS $sonuc) :
			$postaKodu = $sonuc->il_no;
		endforeach;
		return $postaKodu.'000';
	}

	function exceldenVeriKaydet($yazVeri) {
		$this->mySunucu->INSERT('servis_fis', $yazVeri);
	}

}


/* servis_model.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/models/servis_model.php Adresinde Kayıtlı */