<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

	echo '<div id="yeniKayit" style="display: none;">
			<h2 id="ekleBaslik">Kullanıcı Ekle</h2>';
			echo '<div id="kayit_form">
				<select class="fis_kayit_girdi select" id="yetki" name="yetki" onclick="hCD(\'yetki\');">
				<option value="0" selected>Yetki</option>';
				foreach($yetkiler AS $yetki) {
					echo '<option value="'.$yetki->yetki_no.'">'.@$yetki->yetki_adi.'</option>';
				}
				echo '</select>
				<input class="fis_kayit_girdi" type="text" value="" id="kullaniciAdi" name="kullaniciAdi" onkeyup="hCD(\'kullaniciAdi\');" placeholder="Kullanıcı Adı *" />
				<input class="fis_kayit_girdi" type="text" value="" id="sifre" name="sifre" placeholder="Şifre *" onkeyup="hCD(\'sifre\');"  maxlength="12" />
				<input class="fis_kayit_girdi" type="text" value="" id="eposta" name="eposta" placeholder="E-Mail" />
				<input class="fis_kayit_girdi" type="text" autocomplete="off" id="kayit_tarih" disabled="disabled" name="kayit_tarih" value="'.date('d.m.Y - H.i', time()).'" />
				<input class="fis_kayit_girdi" type="text" autocomplete="off" id="son_giris" disabled="disabled" name="son_giris" value="'.date('d.m.Y - H.i', time()).'" />
				<input type="hidden" id="gFisNo"name="gFisNo" value="">
				<button id="kayit_buton" class="kayit_buton" onclick="yeniKullaniciFormKontrol();" type="submit" name="kaydet">Kaydet&nbsp;&nbsp;&nbsp;</button>
				<button onclick="servisFisiEkleKapat(); formTemizle(\'yeniKayit\');" class="kayit_buton sol-hiza-kayit-buton" type="reset" name="iptal">İptal&nbsp;&nbsp;&nbsp;&nbsp;</button>
				<div id="kayit_sonuc">
					<img id="kaydediliyor" src="'.base_url().'resimler/loading.gif" />
					<div id="hataMesaji">Kaydediliyor !..</div>
				</div>
				</div>
			</div>
		</div>';

	echo '<div class="islemler">
		<a href="javascript:;" onclick="kullaniciEkle(0,0);" title="Kullanıcı Ekle"><img src="'.base_url().'resimler/ekle.png" alt="Kullanıcı Ekle"></a>
	</div>
	<div id="aramaMenusu">';
			$tab = '<tab></tab>';
			echo form_open(base_url().'servis/ara');
			echo form_label('Tarih', 'ara_tarih');
			echo $tab;
			echo form_checkbox('ara_tarih', FALSE, FALSE, array('onClick' => 'tarihAramaAc(this);'));
			echo $tab;
			echo form_input('araBas', set_value('araBas'), 'id="araBas" class="araBit tarih" autocomplete="off" autocomplete="off" readonly="true" disabled="disabled" placeholder="Başlama Tarihi"');
			echo $tab.$tab;
			echo form_dropdown('nerede', $aramaAlan, set_value('nerede'), 'id="nerede" autocomplete="off"');
			echo $tab;
			echo form_input('deger', set_value('deger', $this->input->post('deger')), 'id="deger" placeholder="Aranacak Kelime" autocomplete="off"');
			echo  $tab;
			echo form_submit('araButon', 'Ara', 'id="araButon"');
		echo form_close();
	echo $toplamKayit==0 ? '!!! Kayıt Bulunamadı !!!' : 'Toplam : <span class="kirmizi kalin">'.$toplamKayit.'</span> Kayıt Mevcut.';
	echo '</div>';
	echo '</table><br />'; 
	echo '<table class="table table-hover table-striped">'."\r\n";
	echo '<thead>'."\r\n";
	echo '	<th>&nbsp;</th>'."\r\n";
		foreach($alanlar AS $alan => $metin) :
			echo '		<th';
			if($sirala==$alan) echo ' class=\'sirala_'.$siraSekil.'\'';
			echo'>';
			echo anchor("kullanici/listele/".$sorguNo."/".$alan."/".(($siraSekil=='asc' && $sirala==$alan) ? 'desc' : 'asc'), $metin).'</th>'."\r\n";
		endforeach;
		echo '</thead>'."\r\n";
		echo '<tbody>'."\r\n";
		foreach($kullanicilar AS $kullanici) :
		echo '	<tr id="fis_'.$kullanici->k_no.'">'."\r\n";
		echo '		<td class="listeIslemDivi">'."\r\n";
		echo '			<a href="javascript:;" onclick="kullaniciEkle('.$kullanici->k_no.',1);">'."\r\n";
		echo '				<img src="'.base_url().'resimler/fis_duzenle_icon.png" title="'.$kullanici->k_adi.' isimli kullanıcının kaydını incele">'."\r\n";
		echo '			</a>'."\r\n";
		echo '			<a href="'.base_url().'kullanici/kullanici_sil/'.$kullanici->k_no.'" onclick="return confirm(\''.@$kullanici->k_adi.' isimli Kullanıcıyı silmek istediğine emin misin?\');">'."\r\n";
		echo '				<img src="'.base_url().'resimler/Close-2-icon.png" title="'.$kullanici->k_adi.' isimli kullanıcıyı Sil">'."\r\n";
		echo '			</a>'."\r\n";
		echo '		</td>'."\r\n";
		echo '		<td class="k_adi">'.$kullanici->k_adi.'</td>'."\r\n";
		echo '		<td class="yetki">'.$kullanici->yetki.'</td>'."\r\n";
		echo '		<td class="eposta">'.(strlen($kullanici->eposta) ? $kullanici->eposta : '').'</td>'."\r\n";
		echo '		<td class="kayit_tarih">'.date('d.m.Y - H.i', $kullanici->kayit_tarih).'</td>'."\r\n";
		echo '		<td class="kayit_tarih">'.date('d.m.Y - H.i', $kullanici->son_giris).'</td>'."\r\n";
		echo '</tr>'."\r\n"."\r\n";
	endforeach;
	echo '</tbody>';

/* sistem_ayar.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/views/kullanici_listele.php Adresinde Kayıtlı */