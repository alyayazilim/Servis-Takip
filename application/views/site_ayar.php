<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

	echo '<div id="dikeyOrtala">';
		echo '<div class="jumbotron cihaz_tur golge ortala">'."\r\n";
			foreach($markaVerileri AS $marka) :
				echo '<a href="'.base_url().'sistem_yonetimi/marka_sil/'.$marka->marka_no.'"  onclick="return confirm(\''.@$marka->marka_adi.' isimli Markayı silmek istediğine emin misin?\');">
					<div class="ctSil" id="'.$marka->marka_no.'">
						<img src="'.base_url().'resimler/sil_aktif.png">
					</div>
				</a>
				<a href="javascript:;" onclick="cihazMarkaGetir('.$marka->marka_no.');">
					<div class="ctIsim" clearfix id="'.$marka->marka_no.'">'.$marka->marka_adi.'</div>
				</a>';
			endforeach;
			echo '<div id="turDokum" class="golge"></div>'."\r\n";
		echo '</div>'."\r\n";
	echo '</div>'."\r\n";

/* site_ayar.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/views/site_ayar.php Adresinde Kayıtlı */