<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

	echo '<div id="dikeyOrtala">';
	echo '<div class="jumbotron excelYukle golge">'."\r\n";
	echo 		form_open_multipart('servis/excel_yukle', 'id="excel_yukle_form" class="yukle_form"')."\r\n";
	echo '		<input type="file" id="excel_dosyasi" name="excel_dosyasi" class="griinput" onchange="return dosyaBoyutu();" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />'."\r\n";
	echo 		form_submit('kaydetButon', 'Yükle', 'id="kaydetButon"')."\r\n";
	echo 		form_close()."\r\n";
	echo @$formHatasi;
	echo '</div>'."\r\n";
	echo '</div>'."\r\n";

/* excel_yukle.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/views/excel_yukle.php Adresinde Kayıtlı */