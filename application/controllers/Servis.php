<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

class Servis extends CI_Controller {

	var $sistemSabitleri;

	function __construct() {
		parent::__construct();
		ini_set('display_errors', 1);
		$this->load->model('sistem_model');
		$this->sistemSabit = $this->sistem_model->sistemSabitleri();
	}
	
	function index() {
		redirect('servis/listele');
	}

	function giris() {
		$this->load->view('giris', $this->sistemSabit);
	}

	function giris_islem() {
		$this->form_validation->set_rules('kAdi', 'Kullanıcı Adı', 'trim|required|xss_clean|min_length[5]|callback__kullaniciKontrol');
		$this->form_validation->set_rules('kSifre', 'Şifre', 'trim|required|xss_clean|min_length[5]|md5|callback__sifreKontrol');
		$this->form_validation->set_rules('gKodu', 'Güvenlik Kodu', 'trim|required|xss_clean|min_length[4]|callback__gKoduKontrol');
		if($this->form_validation->run() == false) {
			$this->giris();
		} else {
			$this->load->model('kullanici_model');
			$this->kullanici_model->kullanici_giris($this->input->post('kAdi'));
			redirect('servis/listele');
		}
	}

	function _kullaniciKontrol($kAdi) {
		$this->load->model('kullanici_model');
		$kontrol = $this->kullanici_model->kullanici_kontrol($kAdi);
		if($kontrol > 0) {
			return true;
		} else {
			$this->form_validation->set_message('_kullaniciKontrol', 'Böyle bir kullanıcı bulunamadı !!!');
			return false;
		}
	}

	function _sifreKontrol($sifre) {
		$this->load->model('kullanici_model');
		$kontrol = $this->kullanici_model->sifre_kontrol($sifre, $this->input->post('kAdi'));
		if($kontrol > 0) {
			return true;
		} else {
			$this->form_validation->set_message('_sifreKontrol', 'Şifreniz Hatalı !!!');
			return false;
		}
	}

	function _gKoduKontrol($gKodu) {
		if($gKodu == 'Güvenlik') {
			$this->form_validation->set_message('_gKoduKontrol', 'Güvenlik Kodu alanının doldurulması zorunludur.');
			return false;
		} else {
			if($gKodu == $this->session->userdata('koruma')) {
				return true;
			} else {
				$this->form_validation->set_message('_gKoduKontrol', 'Güvenlik Kodu Hatalı !!!');
				return false;
			}
		}
	}

	function ara() {
		$sorguDizesi = array(
			'araBas'	=> $this->input->post('araBas'),
			'araBit'	=> $this->input->post('araBit'),
			'nerede'	=> $this->input->post('nerede'),
			'deger'	=> $this->input->post('deger')
		);
		$sorguNo = $this->input->sorguKaydet($sorguDizesi);
		redirect('servis/listele/'.$sorguNo);
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
		$this->load->model('servis_model');		
		$veriler = $this->servis_model->ara($sorguDizesi, $gosterilecekKayit, $offset, $neyeGoreSirala, $siralamaYonu);
		$this->load->library('pagination');
		$ayar = array(
			'uri_segment'	=> 6,
			'base_url'		=> site_url('servis/listele/'.$sorguNo.'/'.$neyeGoreSirala.'/'.$siralamaYonu),
			'total_rows'	=> $veriler['satirSayisi'],
			'per_page'		=> $gosterilecekKayit,
			'num_links'		=> 5
		);
		$this->pagination->initialize($ayar);
		$veri = array(
			'alanlar'	=>array(
				'is_numarasi'	=> 'İş Numarası',
				'gelis_tarihi'	=> 'Geliş Tarihi',
				'musteri_adi'	=> 'Müşteri Adı',
				'tel'				=> 'Telefon',
				'email'			=> 'Email',
				'durum'			=> 'Durum',
				'marka'			=> 'Marka',
				'urun_kodu'		=> 'Ürün Kodu',
				'urun_adi'		=> 'Ürün Adı',
				'seri_no'		=> 'Seri No'
			),
			'fisler'			=> $veriler['fisler'],
			'toplamKayit'	=> $veriler['satirSayisi'],
			'sayfalama'		=>	$this->pagination->create_links(),
			'siraSekil'		=> $siralamaYonu,
			'sirala'			=> $neyeGoreSirala,
			'aramaAlan'		=> array(
				''					=> 'Arama Alanı Seç',
				'is_numarasi'	=> 'İş Numarası',
				'musteri_adi'	=> 'Müşteri Adı',
				'tel'				=> 'Telefon',
				'sehir'			=> 'Şehir',
				'marka'			=> 'Marka',
				'model'			=> 'Model',
				'urun_adi'		=> 'Ürün Adı',
				'seri_no'		=> 'Seri No'
			),
			'sorguNo'				=> $sorguNo,
			'yeniFisNo'				=> $this->servis_model->yeniFisNoOlustur(),
			'markalar'				=> $this->servis_model->markalar(),
			'cihazTurleri'			=>	$this->servis_model->cihazTurleri(),
			'iller'					=>	$this->servis_model->iller(),
			'servisSekilleri'		=> $this->servis_model->servis_sekilleri(),
			'gonderiSekilleri'	=> $this->servis_model->gonderi_sekilleri(),
			'durumlar'				=> $this->servis_model->durumlar(),
			'gosterilecekSayfa'	=> 'servis_liste'
		);
		$bilgi = array_merge($veri, $this->sistemSabit);
		$this->load->view('taslak', $bilgi);
	}

	function servis_fis_sil() {
		$this->load->model('servis_model');
		$cevap = $this->servis_model->servisFisiKaydet(FALSE, 'sil', $this->uri->segment(3));
		redirect($this->agent->referrer());
	}

	function excel_yaz() {
		$this->load->model("servis_model");
		$sorgu = $this->servis_model->excelIcinVeriHazirla($this->uri->segment(3));
		$this->load->library('Excel');
		$tablo = $this->excel->getActiveSheet();
		// BAŞLIKLAR HAZIRLANIYOR
		$this->excel->setActiveSheetIndex(0)
						->setCellValue('A1', 'İŞ NUMARASI')
						->setCellValue('B1', 'GELİŞ TARİHİ')
						->setCellValue('C1', 'MÜŞTERİ ADI')
						->setCellValue('D1', 'MÜŞTERİ ADRESİ')
						->setCellValue('E1', 'POSTA KODU')
						->setCellValue('F1', 'ŞEHİR')
						->setCellValue('G1', 'TEL')
						->setCellValue('H1', 'E-MAIL')
						->setCellValue('I1', 'DURUM')
						->setCellValue('J1', 'MARKA')
						->setCellValue('K1', 'ÜRÜN KODU')
						->setCellValue('L1', 'ÜRÜN ADI')
						->setCellValue('M1', 'SERİ NO')
						->setCellValue('N1', 'GARANTİ BAŞLANGICI')
						->setCellValue('O1', 'GARANTİ BELGESİ TÜRÜ')
						->setCellValue('P1', 'BİLDİRİLEN ARIZA')
						->setCellValue('Q1', 'ARIZA TANIMI')
						->setCellValue('R1', 'YAPILAN İŞLEMLER')
						->setCellValue('S1', 'SAYAÇ DURUMU')
						->setCellValue('T1', 'TESLİM TARİHİ')
						->setCellValue('U1', 'SERVİS ŞEKLİ')
						->setCellValue('V1', 'GÖNDERİ ŞEKLİ')
						->setCellValue('W1', 'GÖNDERİ DÖKÜMANI')
						->setCellValue('X1', 'GÖNDERİ ÜCRETİ')
						->setCellValue('Y1', 'SERVİS ÜCRETİ')
						->setCellValue('Z1', 'PARÇA KODU 1')
						->setCellValue('AA1', 'PARÇA ADI 1')
						->setCellValue('AB1', 'PARÇA KODU 2')
						->setCellValue('AC1', 'PARÇA ADI 2')
						->setCellValue('AD1', 'PARÇA KODU 3')
						->setCellValue('AE1', 'PARÇA ADI 3')
						->setCellValue('AF1', 'PARÇA KODU 4')
						->setCellValue('AG1', 'PARÇA ADI 4')
						->setCellValue('AH1', 'PARÇA KODU 5')
						->setCellValue('AI1', 'PARÇA ADI 5')
						->setCellValue('AJ1', 'PARÇA KODU 6')
						->setCellValue('AK1', 'PARÇA ADI 6')
						->setCellValue('AL1', 'PARÇA KODU 7')
						->setCellValue('AM1', 'PARÇA ADI 7')
						->setCellValue('AN1', 'PARÇA KODU 8')
						->setCellValue('AO1', 'PARÇA ADI 8')
						->setCellValue('AP1', 'PARÇA KODU 9')
						->setCellValue('AQ1', 'PARÇA ADI 9')
						->setCellValue('AR1', 'PARÇA KODU 10')
						->setCellValue('AS1', 'PARÇA ADI 10')
						->setCellValue('AT1', 'PARÇA KODU 11')
						->setCellValue('AU1', 'PARÇA ADI 11')
						->setCellValue('AV1', 'PARÇA KODU 12')
						->setCellValue('AW1', 'PARÇA ADI 12');
		$tablo->getRowDimension(8)->setRowHeight(-1);
		// Kullandığımız Kolonları Otomatik Olarak Genişletiyoruz. Ortaya Hizalıyoruz ve Yazı Formatlarını Ayarlıyoruz.
		$i=2;
		foreach($sorgu AS $sonuc) :
			$pDize = array();
			if($sonuc->parcalar) {
				$parca = explode('|', $sonuc->parcalar);
				foreach($parca AS $p) :
					$yaz = explode('@*@', $p);
					array_push($pDize, $yaz);
				endforeach; // parca
				var_dump($pDize);
			}
			$tablo->setCellValue('A'.$i, $sonuc->is_numarasi)
					->setCellValue('B'.$i, $sonuc->gelis_tarihi)
					->setCellValue('C'.$i, $sonuc->musteri_adi)
					->setCellValue('D'.$i, $sonuc->musteri_adresi)
					->setCellValue('E'.$i, $sonuc->posta_kodu)
					->setCellValue('F'.$i, $sonuc->sehir)
					->setCellValue('G'.$i, $sonuc->tel)
					->setCellValue('H'.$i, $sonuc->email)
					->setCellValue('I'.$i, $sonuc->durum)
					->setCellValue('J'.$i, $sonuc->marka.' - '.$sonuc->cihaz_tur)
					->setCellValue('K'.$i, $sonuc->urun_kodu)
					->setCellValue('L'.$i, $sonuc->urun_adi)
					->setCellValue('M'.$i, $sonuc->seri_no)
					->setCellValue('N'.$i, $sonuc->garanti_baslangic)
					->setCellValue('O'.$i, $sonuc->garanti_belge_turu)
					->setCellValue('P'.$i, $sonuc->bildirilen_ariza)
					->setCellValue('Q'.$i, $sonuc->ariza_tanimi)
					->setCellValue('R'.$i, $sonuc->yapilan_islem)
					->setCellValue('S'.$i, $sonuc->sayac_durumu)
					->setCellValue('T'.$i, $sonuc->teslim_tarihi)
					->setCellValue('U'.$i, $sonuc->servis_sekli)
					->setCellValue('V'.$i, $sonuc->gonderi_sekli)
					->setCellValue('W'.$i, $sonuc->gonderi_dokuman)
					->setCellValue('X'.$i, '')
					->setCellValue('Y'.$i, '')
					->setCellValue('Z'.$i, @$pDize[0][0])
					->setCellValue('AA'.$i, @$pDize[0][1])
					->setCellValue('AB'.$i, @$pDize[1][0])
					->setCellValue('AC'.$i, @$pDize[1][1])
					->setCellValue('AD'.$i, @$pDize[2][0])
					->setCellValue('AE'.$i, @$pDize[2][1])
					->setCellValue('AF'.$i, @$pDize[3][0])
					->setCellValue('AG'.$i, @$pDize[3][1])
					->setCellValue('AH'.$i, @$pDize[4][0])
					->setCellValue('AI'.$i, @$pDize[4][1])
					->setCellValue('AJ'.$i, @$pDize[5][0])
					->setCellValue('AK'.$i, @$pDize[5][1])
					->setCellValue('AL'.$i, @$pDize[6][0])
					->setCellValue('AM'.$i, @$pDize[6][1])
					->setCellValue('AN'.$i, @$pDize[7][0])
					->setCellValue('AO'.$i, @$pDize[7][1])
					->setCellValue('AP'.$i, @$pDize[8][0])
					->setCellValue('AQ'.$i, @$pDize[8][1])
					->setCellValue('AR'.$i, @$pDize[9][0])
					->setCellValue('AS'.$i, @$pDize[9][1])
					->setCellValue('AT'.$i, @$pDize[10][0])
					->setCellValue('AU'.$i, @$pDize[10][1])
					->setCellValue('AV'.$i, @$pDize[11][0])
					->setCellValue('AW'.$i, @$pDize[11][1]);
			$tablo->getRowDimension(8)->setRowHeight(-1);
			$i++;
		endforeach; // sorgu
		//die();
		$borderStili = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$tablo->getStyle('A1:AW'.$i)->applyFromArray($borderStili);
		unset($borderStili);
		$yaziFormat = array(
			'font'  => array(
				'bold'  => false,
				'size'  => 8,
				'name'  => 'Arial'
			)
		);
		$tablo->getStyle('A2:AW'.$i)->applyFromArray($yaziFormat);
		$tlFormat = '#.###,00 \₺';
		$tablo->getStyle('X2:Y'.$i)->getNumberFormat()->setFormatCode($tlFormat);
		$tablo->getStyle('W2:W'.$i)->getNumberFormat()->setFormatCode('0');
		for($kolon='A'; $kolon!=='AX'; $kolon++) {
			$tablo->getColumnDimension($kolon)->setAutoSize(true);
			$tablo->getStyle($kolon.'1')->getAlignment()->setWrapText(false);
			$tablo->getStyle($kolon.'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$yaziFormat = array(
				'font'  => array(
					'bold'  => true,
					'color' => array(
						'rgb' => '000000'
					),
					'size'  => 9,
					'name'  => 'Arial'
				)
			);
			$tablo->getStyle($kolon.'1')->applyFromArray($yaziFormat);
			$tablo->getStyle($kolon.'1')->getFill()->applyFromArray(
				array(
					'type'		 	=> PHPExcel_Style_Fill::FILL_SOLID,
					'startcolor'	=> array('rgb' =>'FFFF99')
				)
			);
		}
		$tablo->freezePane("B2");
		$tablo->setTitle('Kadir Tutak Servis Dökümü');
		$this->excel->getProperties()->setCreator("Kadir TUTAK")
					->setLastModifiedBy("Kadir TUTAK")
					->setTitle("Servis Takip")
					->setSubject("Servis Takip")
					->setDescription("Servis Takip")
					->setKeywords("Kadir TUTAK Servis Takip")
					->setCategory("Servis Takip");
		$this->excel->setActiveSheetIndex(0);
		$yeniDosyaAdi = $this->servis_model->dosyaAdiOlustur(TRUE, FALSE);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="'.$yeniDosyaAdi.'.xlsx"');
		$objWriter->save('php://output');
		unlink('dosyalar/download/'.$yeniDosyaAdi.'.xlsx');
	}

	function excel_oku() {
		$veri = array(
			'gosterilecekSayfa' => 'excel_oku'
		);
		$bilgi = array_merge($veri, $this->sistemSabit);
		$this->load->view('taslak', $bilgi);
	}

	function excel_yukle() {
		$this->load->model('servis_model');
		$yeniDosyaAdi = $this->servis_model->dosyaAdiOlustur($ozNetlik=FALSE, $_FILES['excel_dosyasi']['name']);
		$ayar = array(
			'upload_path'		=> 'dosyalar/upload',
			'allowed_types'	=> 'xls|xlsx',
			'file_name'			=> $yeniDosyaAdi
		);
		$this->load->library('upload', $ayar);
		if(!$this->upload->do_upload('excel_dosyasi')) {
			$veri = array (
				'formHatasi'			=> $this->upload->display_errors('<div class="formHatasi">', '</div>'),
				'gosterilecekSayfa'	=> 'excel_oku'
			);
			$bilgi = array_merge($veri, $this->sistemSabit);
			$this->load->view('taslak', $bilgi);
		} else {
			$this->load->library('Excel');
			$this->excel = PHPExcel_IOFactory::load('dosyalar/upload/'.$yeniDosyaAdi);
			$sayfa			= $this->excel->getSheet(0);
			$satirSayisi	= $this->excel->setActiveSheetIndex(0)->getHighestRow();
			$kolonAdi		= $sayfa->getHighestColumn();
			echo $this->servis_model->tarih2unix('20.02.2015');
			$veri = array();
			for($satir=2; $satir<=$satirSayisi; $satir++) {
				$kolonVeri = array();
				$satirData = $sayfa->rangeToArray('B'.$satir.':'.$kolonAdi.$satir, NULL, TRUE, FALSE);
				foreach($satirData[0] AS $kolonNo=>$kolonBilgi) {
					$kolon = $kolonBilgi;
					array_push($kolonVeri, $kolon);
				}
				$yazVeri = array(
					'is_numarasi' 			=> $this->servis_model->yeniFisNoOlustur(),
					'gelis_tarihi' 		=> $this->servis_model->tarih2unix(PHPExcel_Style_NumberFormat::toFormattedString($kolonVeri[0], 'YYYY-MM-DD hh:mm:ss')),
					'musteri_adi'			=> $kolonVeri[1],
					'musteri_adresi'		=> $kolonVeri[2],
					'posta_kodu'			=> $this->servis_model->postaKoduGetir($kolonVeri[4]),
					'sehir'					=> $this->servis_model->plakaGetir($kolonVeri[4]),
					'tel'						=> $kolonVeri[5],
					'email'					=> $kolonVeri[6],
					'durum'					=> 1,
					'marka'					=> 2,
					'cihaz_tur'				=> 11,
					'urun_kodu'				=> strtoupper($kolonVeri[7]),
					'urun_adi' 				=> strtoupper($kolonVeri[8]),
					'seri_no' 				=> strtoupper($kolonVeri[9]),
					'garanti_baslangic' 	=> $this->servis_model->tarih2unix(PHPExcel_Style_NumberFormat::toFormattedString($kolonVeri[10], 'YYYY-MM-DD hh:mm:ss')),
					'garanti_belge_turu'	=> $kolonVeri[11],
					'bildirilen_ariza' 	=> $kolonVeri[12],
					'ariza_tanimi'			=> $kolonVeri[13],
					'yapilan_islem'		=> $kolonVeri[14],
					'sayac_durumu'			=> $kolonVeri[15],
					'teslim_tarihi'		=> $this->servis_model->tarih2unix(PHPExcel_Style_NumberFormat::toFormattedString($kolonVeri[16], 'YYYY-MM-DD hh:mm:ss')),
					'servis_sekli'			=> $kolonVeri[17],
					'gonderi_sekli'		=> $kolonVeri[18],
					'gonderi_dokuman'		=> $kolonVeri[19],
					'gonderi_ucreti'		=> 0,
					'servis_ucreti'		=> 0,
					'pesinat'				=> '0.00',
					'islemler'				=> NULL,
					'sil'						=> 0
				);
				$this->servis_model->exceldenVeriKaydet($yazVeri);
			}
			unlink('./dosyalar/upload/'.$yeni_dosya_adi);
			redirect('servis/listele');
		}
	}

	function cikis() {
		$this->load->model('kullanici_model');
		$this->kullanici_model->kullanici_cikis($this->session->has_userdata('k_no'));
		$cikisBilgi = array('k_no','k_adi','yetki');
		$this->session->unset_userdata($cikisBilgi);
		$this->session->sess_destroy();
		header('Location:'.base_url().'giris');
	}

	function fis_incele() {
		$glVeri = $this->input->post('fisNo');
		$veriler ="asd";
		echo $glVeri;
	}

}

/* servis.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/controllers/servis.php Adresinde Kayıtlı */