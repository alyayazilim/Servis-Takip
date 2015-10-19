<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

	echo '<div id="dikeyOrtala">';
		echo '<div class="jumbotron sistem_degisken golge">'."\r\n";
			echo '<img src="'.base_url().'resimler/firma/'.@$firma_logo.'">';
			echo form_open_multipart('sistem_yonetimi/sistem_degisken_kontrol', 'id="sistem_degisken_form" class="sistem_degisken"')."\r\n";
				echo form_label('Firma Adı', 'firma_adi', 'clearfix');
				echo form_input('firma_adi', @$firma_adi);
				echo form_label('Mail Adresi', 'firma_mail', 'clearfix');
				echo form_input('firma_mail', @$firma_mail);
				echo form_label('Firma İli', 'firma_il');
				echo form_input('firma_il', @$firma_il);
				echo '<input type="file" id="firma_resim" name="firma_resim" class="griinput" accept="image/png" />'."\r\n";
				echo form_submit('kaydetButon', 'Kaydet', 'id="kaydetButon"')."\r\n";
			echo form_close();
			echo @$formHatasi;
		echo '</div>';
	echo '</div>';

/* sistem_degisken.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/views/sistem_degisken.php Adresinde Kayıtlı */