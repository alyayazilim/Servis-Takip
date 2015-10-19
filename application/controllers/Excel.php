<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

class Excel extends CI_Controller {

	function __construct() {
		parent::__construct();
	}
	
	public function excel_oku() {
		$this->load->library('PHPExcel');
		$dosyaAdi = 'dosyalar/upload/Servis Takip.xlsx';
		$objPHPExcel = PHPExcel_IOFactory::load($dosyaAdi);

		$objPHPExcel->getProperties()->setCreator("Kadir TUTAK")
						->setLastModifiedBy("Kadir TUTAK")
						->setTitle("Servis Takip")
						->setSubject("Servis Takip")
						->setDescription("Servis Takip")
						->setKeywords("Kadir TUTAK Servis Takip")
						->setCategory("Servis Takip");

		/*
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		foreach($cell_collection AS $cell) {
			$column		= $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row			= $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
			if($row == 1) {
				$header[$row][$column] = $data_value;
			} else {
				$arr_data[$row][$column] = $data_value;
			}
		}
		$basliklar = $header;
		$veriler = $arr_data;
		foreach($veriler AS $veri) {
			echo '<div style="clear: both;">'.$veri['A'].' - '.$veri['B'].' - '.$veri['C'].'</div>';
		}
		*/
	}

	public function excel_yaz() {
		$this->load->library('PHPExcel');
		$this->excel = new PHPExcel();
		/*

		//$dosyaAdi = 'Servis Takip.xlsx';
		//$objPHPExcel = PHPExcel_IOFactory::load($dosyaAdi);
		/*
		$objPHPExcel->getProperties()->setCreator("Kadir TUTAK")
						->setLastModifiedBy("Kadir TUTAK")
						->setTitle("Servis Takip")
						->setSubject("Servis Takip")
						->setDescription("Servis Takip")
						->setKeywords("Kadir TUTAK Servis Takip")
						->setCategory("Servis Takip");
		
		// BAŞLIKLAR HAZIRLANIYOR
		$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A1', 'İŞ NUMARASI')
						->setCellValue('B1', 'SERVİSE GELİŞ TARİHİ')
						->setCellValue('C1', 'MÜŞTERİ ADI')
						->setCellValue('D1', 'MÜŞTERİ ADRESİ')
						->setCellValue('E1', 'POSTA KODU')
						->setCellValue('F1', 'ŞEHİR')
						->setCellValue('G1', 'TEL')
						->setCellValue('H1', 'E-MAIL')
						->setCellValue('I1', 'ÜRÜN KODU')
						->setCellValue('J1', 'ÜRÜN ADI')
						->setCellValue('K1', 'SERİ NO')
						->setCellValue('L1', 'GARANTİ BAŞLANGIÇ TARİHİ')
						->setCellValue('M1', 'GARANTİ BELGESİ TÜRÜ')
						->setCellValue('N1', 'BİLDİRİLEN ARIZA')
						->setCellValue('O1', 'ARIZA TANIMI')
						->setCellValue('P1', 'YAPILAN İŞLEMLER')
						->setCellValue('Q1', 'SAYAÇ DURUMU')
						->setCellValue('R1', 'MÜŞTERİYE TESLİM TARİHİ')
						->setCellValue('S1', 'SERVİS ŞEKLİ')
						->setCellValue('T1', 'GÖNDERİ ŞEKLİ')
						->setCellValue('U1', 'GÖNDERİ DÖKÜMANI')
						->setCellValue('V1', 'GÖNDERİ ÜCRETİ KDV Hariç')
						->setCellValue('W1', 'SERVİS ÜCRETİ')
						->setCellValue('X1', 'PARÇA KODU 1')
						->setCellValue('Y1', 'PARÇA ADI 1')
						->setCellValue('Z1', 'PARÇA KODU 2')
						->setCellValue('AA1', 'PARÇA ADI 2')
						->setCellValue('AB1', 'PARÇA KODU 3')
						->setCellValue('AC1', 'PARÇA ADI 3')
						->setCellValue('AD1', 'PARÇA KODU 4')
						->setCellValue('AE1', 'PARÇA ADI 4')
						->setCellValue('AF1', 'PARÇA KODU 5')
						->setCellValue('AG1', 'PARÇA ADI 5')
						->setCellValue('AH1', 'PARÇA KODU 6')
						->setCellValue('AI1', 'PARÇA ADI 6')
						->setCellValue('AJ1', 'PARÇA KODU 7')
						->setCellValue('AK1', 'PARÇA ADI 7')
						->setCellValue('AL1', 'PARÇA KODU 8')
						->setCellValue('AM1', 'PARÇA ADI 8')
						->setCellValue('AN1', 'PARÇA KODU 9')
						->setCellValue('AO1', 'PARÇA ADI 9')
						->setCellValue('AP1', 'PARÇA KODU 10')
						->setCellValue('AQ1', 'PARÇA ADI 10')
						->setCellValue('AR1', 'PARÇA KODU 11')
						->setCellValue('AS1', 'PARÇA ADI 11')
						->setCellValue('AT1', 'PARÇA KODU 12')
						->setCellValue('AU1', 'PARÇA ADI 12');
		$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);

		// Kullandığımız Kolonları Otomatik Olarak Genişletiyoruz. Ortaya Hizalıyoruz ve Yazı Formatlarını Ayarlıyoruz.
		for($kolon='A'; $kolon!=='AV'; $kolon++) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($kolon)->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($kolon.'1')->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle($kolon.'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
			$objPHPExcel->getActiveSheet()->getStyle($kolon.'1')->applyFromArray($yaziFormat);
			$objPHPExcel->getActiveSheet()->getStyle($kolon.'1')->getFill()->applyFromArray(
				array(
					'type'		 	=> PHPExcel_Style_Fill::FILL_SOLID,
					'startcolor'	=> array('rgb' =>'FFFF99')
				)
			);
		}

		$this->load->model();
		$bilgiler = $this->servis_model->fisler(FALSE, FALSE, FALSE);
		$i=2;
		foreach($sorgu->fetchAll() AS $sonuc) {
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$i, $sonuc['is_numarasi'])
							->setCellValue('B'.$i, unixtodate($sonuc['gelis_tarihi']))
							->setCellValue('C'.$i, $sonuc['musteri_adi'])
							->setCellValue('D'.$i, $sonuc['musteri_adresi'])
							->setCellValue('E'.$i, $sonuc['posta_kodu'])
							->setCellValue('F'.$i, $sonuc['sehir'])
							->setCellValue('G'.$i, $sonuc['tel'])
							->setCellValue('H'.$i, $sonuc['email'])
							->setCellValue('I'.$i, $sonuc['urun_kodu'])
							->setCellValue('J'.$i, $sonuc['urun_adi'])
							->setCellValue('K'.$i, $sonuc['seri_no'])
							->setCellValue('L'.$i, unixtodate($sonuc['garanti_baslangic']))
							->setCellValue('M'.$i, $sonuc['garanti_belge_turu'])
							->setCellValue('N'.$i, $sonuc['bildirilen_ariza'])
							->setCellValue('O'.$i, $sonuc['ariza_tanimi'])
							->setCellValue('P'.$i, $sonuc['yapilan_islem'])
							->setCellValue('Q'.$i, $sonuc['sayac_durumu'])
							->setCellValue('R'.$i, unixtodate($sonuc['teslim_tarihi']))
							->setCellValue('S'.$i, $sonuc['servis_sekli'])
							->setCellValue('T'.$i, $sonuc['gonderi_sekli'])
							->setCellValue('U'.$i, $sonuc['gonderi_dokuman'])
							->setCellValue('V'.$i, $sonuc['gonderi_ucreti'])
							->setCellValue('W'.$i, $sonuc['servis_ucreti'])
							->setCellValue('X'.$i, $sonuc['parcalar']);
			$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
			$borderStili = array(
			  'borders' => array(
			    'allborders' => array(
			      'style' => PHPExcel_Style_Border::BORDER_THIN
			    )
			  )
			);

			$objPHPExcel->getActiveSheet()->getStyle('A1:AU'.$i)->applyFromArray($borderStili);
			unset($borderStili);
			$yaziFormat = array(
				'font'  => array(
					'bold'  => false,
					'size'  => 8,
					'name'  => 'Arial'
				)
			);
			$objPHPExcel->getActiveSheet()->getStyle('A2:AU'.$i)->applyFromArray($yaziFormat);
			$i++;
		}

		$objPHPExcel->getActiveSheet()->setTitle('Kadir Tutak Servis Dökümü');
		$objPHPExcel->setActiveSheetIndex(0);
		$dosyaKaydet = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$dosyaKaydet->save(str_replace('.php', '.xlsx', base_url().'dosyalar/download/Servis Takip.xlsx'));
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Servis Takip.xlsx"');
		header('Cache-Control: max-age=0');
		$dosyaKaydet->save('php://output');
		*/
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Countries');
		$this->excel->getActiveSheet()->setCellValue('A1', 'Country Excel Sheet');
		$this->excel->getActiveSheet()->setCellValue('A4', 'S.No.');
		$this->excel->getActiveSheet()->setCellValue('B4', 'Country Code');
		$this->excel->getActiveSheet()->setCellValue('C4', 'Country Name');
		$this->excel->getActiveSheet()->mergeCells('A1:C1');
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
		for($col = ord('A'); $col <= ord('C'); $col++){
			$this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
			$this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
			$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		
		$this->load->model('servis_model');
		$veriler = $this->servis_model->fisler(false, false, false);
		//print_r($veriler);
		$exceldata="";
		foreach($veriler AS $veri) {
			$exceldata[] = $veri[];
		}
		$this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
		$this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$filename='Servis Takip.xlsx';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, '2007');  
		$objWriter->save('php://output');
	}
}

/* excel.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/controllers/excel.php Adresinde Kayıtlı */