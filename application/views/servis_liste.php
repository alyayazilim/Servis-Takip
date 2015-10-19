<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

		echo '<div id="yeniKayit" style="display: none;">
			<h2 id="ekleBaslik">Yeni Servis Fişi</h2><h5 id="ekleNo">';
			
			echo empty($yeniFisNo) ? '00-KT0000' : $yeniFisNo;
			echo '</h5>
			<div id="kayit_form">
				<div id="musteriKontrol">
					<input class="fis_kayit_girdi" type="text" autocomplete="off" value="" id="musteri" name="musteri" onkeyup="hCD(\'musteri\'); kullaniciKontrol(this);" placeholder="Müşteri *" />
				<div id="isimler" class="golge"></div>
				</div>
				<input class="fis_kayit_girdi" type="text" value="" id="tel" name="tel" placeholder="Telefon *" onkeyup="sKontrol(this); hCD(\'tel\');"  maxlength="11" />
				<input class="fis_kayit_girdi" type="text" value="" id="email" name="email" placeholder="E-Mail" />
				<select class="fis_kayit_girdi select" id="sehir" name="sehir" onclick="hCD(\'sehir\');">
				<option value="0">Şehir</option>';
				foreach($iller AS $il) {
					echo '<option value="'.$il->il_no.'">'.@$il->il_adi.'</option>';
				}
				echo '</select>
				<textarea id="adres" name="adres" class="fis_kayit_girdi textAlani" placeholder="Adres" onkeyup="hCD(\'adres\');"></textarea>
				<select class="fis_kayit_girdi select" name="marka" id="marka" onclick="hCD(\'marka\');">
				<option value="0">Cihaz Markası *</option>';
				foreach(@$markalar AS $marka) {
					echo '<option value="'.@$marka->marka_id.'">'.@$marka->marka_adi.'</option>';
				}
				echo '</select>
				<select class="fis_kayit_girdi select" name="cihaz" id="cihaz" onclick="hCD(\'cihaz\');">
				<option value="0">Cihaz Türü *</option>';
				foreach(@$cihazTurleri AS $cihaz) {
					echo '<option value="'.@$cihaz->tur_no.'">'.@$cihaz->tur_adi.'</option>';
				}
				echo '</select>
				<input class="fis_kayit_girdi" type="text" id="urunKodu" name="urunKodu" value="" placeholder="Ürün Kodu" />
				<input class="fis_kayit_girdi" type="text" id="urunAdi" name="urunAdi" value="" placeholder="Ürün Adı" />
				<input class="fis_kayit_girdi" type="text" id="seriNo" name="seriNo" value="" placeholder="Seri No" />
				<input class="fis_kayit_girdi" type="text" id="belgeTuru" name="belgeTuru" value="" placeholder="Belge Türü" />
				<input class="fis_kayit_girdi tarih" type="text" autocomplete="off" id="garantiBaslangic" name="garantiBaslangic" value="" placeholder="Garanti Başlangıcı" />
				<input class="fis_kayit_girdi tarih" type="text" autocomplete="off" id="teslimTarihi" name="teslimTarihi" value="" placeholder="Teslim Tarihi" />
				<input class="fis_kayit_girdi" type="text" id="sayac" id="sayac" name="sayac" value="" onkeyup="sKontrol(this);" placeholder="Sayac" />
				<select class="fis_kayit_girdi select" id="durum" name="durum" value="">
					<option value="0">Durum</option>';
				foreach(@$durumlar AS $durum) {
					echo '<option value="'.@$durum->durum_no.'">'.@$durum->durum_aciklama.'</option>';
				}
				echo '</select>

				<textarea id="ariza" name="ariza" placeholder="Arıza" class="fis_kayit_girdi textAlani"></textarea>
				<textarea id="arizaTanim" name="arizaTanim" placeholder="Arıza Tanımı" class="fis_kayit_girdi textAlani"></textarea>
				<select class="fis_kayit_girdi select" id="servisSekli" name="servisSekli" value="">
					<option value="0">Servis Şekli</option>';
				foreach(@$servisSekilleri AS $servis) {
					echo '<option value="'.$servis->servis_tur_no.'">'.$servis->servis_tur_adi.'</option>';
				}
				echo '</select>
				<select class="fis_kayit_girdi select" id="gonderiSekli" name="gonderiSekli">
				<option value="0">Gönderi Şekli</option>';
				foreach(@$gonderiSekilleri AS $gonderi) {
					echo '<option value="'.$gonderi->gonderi_no.'">'.$gonderi->gonderi_aciklama.'</option>';
				}
				echo '</select>
				<input class="fis_kayit_girdi" type="text" id="servisUcret" name="servisUcret" value="" placeholder="Servis Ücreti" onkeyup="sKontrol(this);" />
				<input class="fis_kayit_girdi" type="text" id="pesinat" name="pesinat" value="" placeholder="Peşinat" onkeyup="sKontrol(this);" />
				<input class="fis_kayit_girdi" type="text" id="gonderiDokuman" name="gonderiDokuman" value="" placeholder="Gönderi Döküman" />
				<input class="fis_kayit_girdi" type="text" id="gonderiUcret" name="gonderiUcret" value="" placeholder="Gönderi Ücreti" onkeyup="sKontrol(this);" />
				<textarea id="islemler" name="islemler" placeholder="Yapılan İşlemler" class="fis_kayit_girdi textAlani"></textarea>
				<input type="hidden" id="gFisNo"name="gFisNo" value="">
				<button id="kayit_buton" class="kayit_buton" onclick="yeniKayitFormKontrol();" type="submit" name="kaydet">Kaydet&nbsp;&nbsp;&nbsp;</button>
				<button onclick="servisFisiEkleKapat(); formTemizle(\'yeniKayit\');" class="kayit_buton sol-hiza-kayit-buton" type="reset" name="iptal">İptal&nbsp;&nbsp;&nbsp;&nbsp;</button>
				<div id="kayit_sonuc">
					<img id="kaydediliyor" src="'.base_url().'resimler/loading.gif" />
					<div id="hataMesaji">Kaydediliyor !..</div>
				</div>
				
				</div>
			</div>
		</div>';

	echo '<div class="islemler">
		<a href="javascript:;" onclick="servisFisiEkle(0, 0);" title="Servis Ekle"><img src="'.base_url().'resimler/ekle.png" alt="Yeni Servis Ekle"></a>
		<a href="'.base_url().'servis/excel_yaz/'.$sorguNo.'" title="Listeyi Excele Aktar"><img src="'.base_url().'resimler/excele_aktar.png" alt="Listeyi Excele Aktar"></a>
		<a href="'.base_url().'servis/excel_oku" title="Excel\'den siteye Aktar"><img src="'.base_url().'resimler/excelden_aktar.png" alt="Excel\'den siteye Aktar"></a>
	</div>
	<div id="aramaMenusu">';
			$tab = '<tab></tab>';
			echo form_open(base_url().'servis/ara');
			echo form_label('Tarih', 'ara_tarih');
			echo $tab;
			echo form_checkbox('ara_tarih', FALSE, FALSE, array('onClick' => 'tarihAramaAc(this);'));
			echo $tab;
			echo form_input('araBas', set_value('araBas'), 'id="araBas" class="araBas tarih" autocomplete="off" autocomplete="off" readonly="true" disabled="disabled" placeholder="Başlangıç Tarihi"');
			echo $tab;
			echo form_input('araBit', set_value('araBit'), 'id="araBit" class="araBit tarih" autocomplete="off" autocomplete="off" readonly="true" disabled="disabled" placeholder="Bitiş Tarihi"');
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
			echo anchor("servis/listele/".$sorguNo."/".$alan."/".(($siraSekil=='asc' && $sirala==$alan) ? 'desc' : 'asc'), $metin).'</th>'."\r\n";
		endforeach;
		echo '</thead>'."\r\n";
		echo '<tbody>'."\r\n";
		foreach($fisler AS $fis) :
		echo '	<tr id="fis_'.$fis->fis_no.'">'."\r\n";
		echo '		<td class="listeIslemDivi">'."\r\n";
		echo '			<a href="javascript:;" onclick="servisFisiEkle('.$fis->fis_no.', \''.$fis->is_numarasi.'\');">'."\r\n";
		echo '				<img src="'.base_url().'resimler/fis_duzenle_icon.png" title="'.$fis->musteri_adi.' isimli Müşterinin Fişini İncele">'."\r\n";
		echo '			</a>'."\r\n";
		echo '			<a href="'.base_url().'servis/servis_fis_sil/'.$fis->fis_no.'" onclick="return confirm(\''.@$fis->musteri_adi.' isimli Müşterinin Fişini Silmek istediğinize emin misiniz?\');">'."\r\n";
		echo '				<img src="'.base_url().'resimler/Close-2-icon.png" title="'.$fis->musteri_adi.' isimli Müşterinin Fişini Sil">'."\r\n";
		echo '			</a>'."\r\n";
		echo '		</td>'."\r\n";
		echo '		<td class="isNumarasi">'.$fis->is_numarasi.'</td>'."\r\n";
		echo '		<td class="gelisTarihi">'.date('d.m.Y', $fis->gelis_tarihi).'</td>'."\r\n";
		echo '		<td class="musteriAdi">'.$fis->musteri_adi.'</td>'."\r\n";
		echo '		<td class="tel">'.$fis->tel.'</td>'."\r\n";
		echo '		<td class="email">'.(strlen($fis->email) ? $fis->email : '').'</td>'."\r\n";
		echo '		<td class="durum"><img src="'.base_url().'resimler/durumlar/durum_'.$fis->durum.'.png" width="30"> '.$fis->durum_aciklama.'</td>
		<td class="urunTur"><img src="'.base_url().'resimler/markalar/marka_'.$fis->marka.'.png" width="30">&nbsp;<img src="'.base_url().'resimler/cihazlar/'.$fis->tur_resim.'"></td>
		<td class="urunKodu">'.$fis->urun_kodu.'</td>
		<td class="urunAdi">'.$fis->urun_adi.'</td>
		<td class="seriNo">'.$fis->seri_no.'</td>
	</tr>'."\r\n"."\r\n";
	endforeach;
	echo '</tbody>';

/* servis_liste.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/views/servis_liste.php Adresinde Kayıtlı */