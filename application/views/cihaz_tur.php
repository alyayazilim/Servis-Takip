<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

	echo '<div id="dikeyOrtala">';
		echo '<div class="jumbotron cihaz_tur golge ortala">'."\r\n";
		echo '<a class="ctEkle" href="javascript:;" onclick="yeniTurEkle(this);"><img src="'.base_url().'resimler/ekle.png"></a>'."\r\n";
			foreach($turVerileri AS $turler) :
				echo '<a href="'.base_url().'sistem_yonetimi/cihaz_tur_sil/'.$turler->tur_no.'"  onclick="return confirm(\''.@$turler->tur_adi.' isimli Cihazı silmek istediğine emin misin?\');">
					<div class="ctSil" id="'.$turler->tur_no.'">
						<img src="'.base_url().'resimler/sil_aktif.png">
					</div>
				</a>
				<a href="javascript:;" onclick="cihazTurGetir(this, \''.$turler->tur_resim.'\', '.$turler->tur_no.');">
					<div class="ctIsim" clearfix id="'.$turler->tur_no.'">'.$turler->tur_adi.'</div>
				</a>';
			endforeach;
			echo '<div id="turDokum" class="golge"></div>'."\r\n";
		echo '</div>'."\r\n";
	echo '</div>'."\r\n";

/* cihaz_tur.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/views/cihaz_tur.php Adresinde Kayıtlı */