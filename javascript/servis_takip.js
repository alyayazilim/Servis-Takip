var protokol	= window.location.protocol;
var domain = "http://"+window.location.host;

function nesneOlustur() {
	var nesne;
	var tarayici = navigator.appName;
	if(tarayici == "Microsoft Internet Explorer"){
		nesne = new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		nesne = new XMLHttpRequest();
	}
	return nesne;
}

function sKontrol(nesne) {
	var GecerliNesneler = "0123456789.";
	var Numara=true;
	var Karakter;
	for(i=0; i<nesne.value.length && Numara==true; i++) {
		Karakter = nesne.value.charAt(i);
		if(GecerliNesneler.indexOf(Karakter) == -1) {
			nesne.value = nesne.value.substring(0,i);
			break;
		}
	}
	return Numara;
}

function servisFisiIncele(fisNo) {
	golgeAc();
	var fisNo;
	var istek =  nesneOlustur();
	var islemDosyasi = domain+"/ajax_istekleri/fis_incele";
	var veri = 'fisNo='+fisNo;
	istek.open('POST', islemDosyasi, true);
	istek.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	istek.send(veri);
	istek.onreadystatechange = function() {
		if(istek.readyState == 4) {
			document.getElementById("icerik").innerHTML=istek.responseText;
		}
	}
}

function servisFisiEkle(fisNo,isNo) {
	golgeAc();
	document.getElementById("yeniKayit").style.display="inline-block";
	var istek =  nesneOlustur();
	if(fisNo != 0 || isNo != 0) {
		document.getElementById('ekleBaslik').innerHTML=isNo+" No'lu Kaydı Düzenle";
		document.getElementById('ekleNo').innerHTML=isNo;
		var postVerisi = "istek=bilgi&fisNo="+fisNo;
		var islemDosyasi = domain+"/ajax_istekleri/servis_fisi_getir";
		istek.open('POST', islemDosyasi, true);
		istek.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		istek.send(postVerisi);
		istek.onreadystatechange = function() {
			if(istek.readyState == 4) {
				var veri = JSON.parse(istek.responseText)[0];
				document.getElementById('ekleNo').innerHTML=veri.is_numarasi;
				document.getElementById('kayit_buton').setAttribute('onclick','kayitDuzenleFormKontrol('+fisNo+');');
				document.getElementById('gFisNo').value=fisNo;
				document.getElementById("musteri").value=veri.musteri_adi;
				document.getElementById("tel").value=veri.tel;
				document.getElementById("email").value=veri.email;
				document.getElementById("durum").value=veri.durum;
				document.getElementById('sehir').value=veri.sehir;
				document.getElementById("adres").value=veri.musteri_adresi;
				document.getElementById("marka").value=veri.marka; // Select
				document.getElementById("adres").value=veri.musteri_adresi;
				document.getElementById("marka").value=veri.marka;
				document.getElementById("cihaz").value=veri.cihaz_tur; // Select
				document.getElementById("urunKodu").value=veri.urun_kodu;
				document.getElementById("urunAdi").value=veri.urun_adi;
				document.getElementById("seriNo").value=veri.seri_no;
				document.getElementById("belgeTuru").value=veri.garanti_belge_turu;
				document.getElementById("garantiBaslangic").value=veri.garanti_baslangic;
				document.getElementById("teslimTarihi").value=veri.teslim_tarihi;
				document.getElementById("sayac").value=veri.sayac_durumu;
				document.getElementById("ariza").value=veri.bildirilen_ariza;
				document.getElementById("arizaTanim").value=veri.ariza_tanimi;
				document.getElementById("servisSekli").value=veri.servis_sekli; // Select
				document.getElementById("gonderiSekli").value=veri.gonderi_sekli; //Select
				document.getElementById("servisUcret").value=veri.servis_ucreti;
				document.getElementById("pesinat").value=veri.pesinat;
				document.getElementById("gonderiDokuman").value=veri.gonderi_dokuman;
				document.getElementById("gonderiUcret").value=veri.gonderi_ucreti;
				document.getElementById("islemler").value=veri.yapilan_islem;
			}
		}
	} else {
		var postVerisi = "istek=yeni";
		var islemDosyasi = domain+"/ajax_istekleri/servis_no_getir";
		istek.open('POST', islemDosyasi, true);
		istek.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		istek.send(postVerisi);
		istek.onreadystatechange = function() {
			if(istek.readyState == 4) {
				document.getElementById('ekleNo').innerHTML=istek.responseText;
			}
		}
		document.getElementById('ekleBaslik').innerHTML="Yeni Kayıt Ekle";
	}
}

function kullaniciEkle(kullaniciNo, islem) {
	golgeAc();
	document.getElementById("yeniKayit").style.display="inline-block";
	var istek =  nesneOlustur();
	if(islem==1) {
		var postVerisi = "istek=bilgi&kullaniciNo="+kullaniciNo;
		var islemDosyasi = domain+"/ajax_istekleri/kullanici_getir";
		istek.open('POST', islemDosyasi, true);
		istek.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		istek.send(postVerisi);
		istek.onreadystatechange = function() {
			if(istek.readyState == 4) {
				var veri = JSON.parse(istek.responseText)[0];
				document.getElementById('ekleBaslik').innerHTML=veri.k_adi+" Kullanıcısının Kaydını Düzenle";
				document.getElementById('kayit_buton').setAttribute('onclick','kullaniciDuzenleFormKontrol('+kullaniciNo+');');
				document.getElementById('kullaniciAdi').value=veri.k_adi;
				document.getElementById('yetki').value=veri.yetki;
				document.getElementById("eposta").value=veri.eposta;
				var kayitTarihi = new Date(veri.kayit_tarih*1000),
				dd=('0'+kayitTarihi.getDate()).slice(-2),
				mm=('0'+(kayitTarihi.getMonth()+1)).slice(-2),
				yyyy=kayitTarihi.getFullYear(),
				hh=kayitTarihi.getHours(),
				min=('0'+kayitTarihi.getMinutes()).slice(-2);
				kayit = dd+'.'+mm+'.'+yyyy+' - '+hh+':'+min;
				document.getElementById("kayit_tarih").value=kayit;
				var sonGiris = new Date(veri.son_giris*1000),
					dd=('0'+sonGiris.getDate()).slice(-2),
					mm=('0'+(sonGiris.getMonth()+1)).slice(-2),
					yyyy=sonGiris.getFullYear(),
					hh=sonGiris.getHours(),
					min=('0'+sonGiris.getMinutes()).slice(-2);
				son = dd+'.'+mm+'.'+yyyy+' - '+hh+':'+min;
				document.getElementById("son_giris").value=son;
			}
		}
	} else {
		document.getElementById('ekleBaslik').innerHTML="Kullanıcı Ekle";
	}
}

function servisFisiEkleKapat() {
	document.getElementById("yeniKayit").style.display="none";
	document.getElementById("golge").style.display="none";
}

function golgeAc() {
	document.getElementById("golge").style.display="block";
}

function golgeKapat() {
	document.getElementById("golge").style.display="none";
}

function yeniKayitFormKontrol() {
	document.getElementById('kayit_sonuc').style.display="block";
	var mesajDivi 				= document.getElementById('hataMesaji');
	var mus						= document.getElementById("musteri");
	var tMus						= mus.value.trim();
	var adres					= document.getElementById("adres");
	var tAdres					= adres.value.trim();
	var sehir					= document.getElementById("sehir");
	var tSehir					= sehir.value.trim();
	var tel						= document.getElementById("tel");
	var tTel						= tel.value.trim();
	var email					= document.getElementById("email");
	var tEmail					= email.value.trim();
	var durum					= document.getElementById("durum");
	var tDurum					= durum.value.trim();
	var marka					= document.getElementById("marka");
	var tMarka					= marka.value.trim();
	var cihaz					= document.getElementById("cihaz");
	var tCihaz					= cihaz.value.trim();
	var urunKodu				= document.getElementById("urunKodu");
	var tUrunKodu				= urunKodu.value.trim();
	var urunAdi					= document.getElementById("urunAdi");
	var tUrunAdi				= urunAdi.value.trim();
	var seriNo					= document.getElementById("seriNo");
	var tSeriNo					= seriNo.value.trim();
	var garantiBaslangic		= document.getElementById("garantiBaslangic");
	var tGarantiBaslangic	= garantiBaslangic.value.trim();
	var belgeTuru				= document.getElementById("belgeTuru");
	var tBelgeTuru				= belgeTuru.value.trim();
	var ariza					= document.getElementById("ariza");
	var tAriza					= ariza.value.trim();
	var arizaTanim				= document.getElementById("arizaTanim");
	var tArizaTanim			= arizaTanim.value.trim();
	var islemler				= document.getElementById("islemler");
	var tIslemler				= islemler.value.trim();
	var sayac					= document.getElementById("sayac");
	var tSayac					= sayac.value.trim();
	var teslimTarihi			= document.getElementById("teslimTarihi");
	var tTeslimTarihi			= teslimTarihi.value.trim();
	var servisSekli			= document.getElementById("servisSekli");
	var tServisSekli			= servisSekli.value.trim();
	var gonderiSekli			= document.getElementById("gonderiSekli");
	var tGonderiSekli			= gonderiSekli.value.trim();
	var gonderiDokuman		= document.getElementById("gonderiDokuman");
	var tGonderiDokuman		= gonderiDokuman.value.trim();
	var gonderiUcret			= document.getElementById("gonderiUcret");
	var tGonderiUcret			= gonderiUcret.value.trim();
	var servisUcret			= document.getElementById("servisUcret");
	var tServisUcret			= servisUcret.value.trim();
	var pesinat					= document.getElementById("pesinat");
	var tPesinat				= pesinat.value.trim();
	if(tMus.length < 5) {
		mesajDivi.innerHTML="Müsteri Adı En az 5 Karakter Olmalıdır !!!";
		mus.style.border="1px solid #F00";
		mus.focus();
		return false;
	}
	if(tTel.length < 11) {
		mesajDivi.innerHTML="Telefon En az 11 Karakter Olmalıdır !!!";
		tel.style.border="1px solid #F00";
		tel.focus();
		return false;
	}
	if(tCihaz == 0) {
		mesajDivi.innerHTML="Cihaz Türü Seçilmelidir !!!";
		cihaz.style.border="1px solid #F00";
		cihaz.focus();
		return false;
	}
	var postVerisi = "mus="+tMus
		+"&adres="+tAdres
		+"&sehir="+tSehir
		+"&tel="+tTel
		+"&email="+tEmail
		+"&durum="+tDurum
		+"&marka="+tMarka
		+"&cihaz="+tCihaz
		+"&urunKodu="+tUrunKodu
		+"&urunAdi="+tUrunAdi
		+"&seriNo="+tSeriNo
		+"&garantiBaslangic="+tGarantiBaslangic
		+"&belgeTuru="+tBelgeTuru
		+"&ariza="+tAriza
		+"&arizaTanim="+tArizaTanim
		+"&islemler="+tIslemler
		+"&sayac="+tSayac
		+"&teslimTarihi="+tTeslimTarihi
		+"&servisSekli="+tServisSekli
		+"&gonderiSekli="+tGonderiSekli
		+"&gonderiDokuman="+tGonderiDokuman
		+"&gonderiUcret="+tGonderiUcret
		+"&servisUcret="+tServisUcret
		+"&pesinat="+tPesinat;
	var istek =  nesneOlustur();
	var islemDosyasi = domain+"/ajax_istekleri/yeni_fis_kayit";
	istek.open('POST', islemDosyasi, true);
	istek.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	istek.send(postVerisi);
	istek.onreadystatechange = function() {
		if(istek.readyState == 4) {
			if(istek.responseText == 1) {
				servisFisiEkleKapat();
				golgeKapat();
				location.reload(true);
			} else {
				alert('Ajax İstekleri Dosyasında Hata : '+istek.responseText);
			}
		}
	}
}

function yeniKullaniciFormKontrol() {
	document.getElementById('kayit_sonuc').style.display="block";
	var mesajDivi 		= document.getElementById('hataMesaji');
	var yetki			= document.getElementById("yetki");
	var tYetki			= yetki.value.trim();
	var kullaniciAdi	= document.getElementById("kullaniciAdi");
	var tKullaniciAdi	= kullaniciAdi.value.trim();
	var sifre			= document.getElementById("sifre");
	var tSifre			= sifre.value.trim();
	var eposta			= document.getElementById("eposta");
	var tEposta			= eposta.value.trim();
	if(tYetki.length == 0) {
		mesajDivi.innerHTML="Yetki Seçmelisiniz !!!";
		yetki.style.border="1px solid #F00";
		yetki.focus();
		return false;
	}
	if(tKullaniciAdi.length < 5) {
		mesajDivi.innerHTML="Kullanıcı Adı En az 5 Karakter Olmalıdır !!!";
		kullaniciAdi.style.border="1px solid #F00";
		kullaniciAdi.focus();
		return false;
	}
	if(tSifre < 8) {
		mesajDivi.innerHTML="Şifre En az 8 Hane Olmalıdır !!!";
		sifre.style.border="1px solid #F00";
		sifre.focus();
		return false;
	}
	if(tEposta < 8) {
		mesajDivi.innerHTML="Email Adresi En az 8 Hane Olmalıdır !!!";
		eposta.style.border="1px solid #F00";
		eposta.focus();
		return false;
	}
	var postVerisi = "k_adi="+tKullaniciAdi
		+"&sifre="+tSifre
		+"&yetki="+tYetki
		+"&eposta="+tEposta;
	var istek =  nesneOlustur();
	var islemDosyasi = domain+"/ajax_istekleri/yeni_kullanici_kayit";
	istek.open('POST', islemDosyasi, true);
	istek.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	istek.send(postVerisi);
	istek.onreadystatechange = function() {
		if(istek.readyState == 4) {
			if(istek.responseText == 1) {
				servisFisiEkleKapat();
				golgeKapat();
				location.reload(true);
			} else {
				mesajDivi.innerHTML="Bu Kullanıcı Daha Önceden Kaydedilmiş !!!";
			}
		}
	}
}

function kullaniciDuzenleFormKontrol(kullaniciNo) {
	document.getElementById('kayit_sonuc').style.display="block";
	var mesajDivi 		= document.getElementById('hataMesaji');
	var yetki			= document.getElementById("yetki");
	var tYetki			= yetki.value.trim();
	var kullaniciAdi	= document.getElementById("kullaniciAdi");
	var tKullaniciAdi	= kullaniciAdi.value.trim();
	var sifre			= document.getElementById("sifre");
	var tSifre			= sifre.value.trim();
	var eposta			= document.getElementById("eposta");
	var tEposta			= eposta.value.trim();
	if(tYetki.length == 0) {
		mesajDivi.innerHTML="Yetki Seçmelisiniz !!!";
		yetki.style.border="1px solid #F00";
		yetki.focus();
		return false;
	}
	if(tKullaniciAdi.length < 5) {
		mesajDivi.innerHTML="Kullanıcı Adı En az 5 Karakter Olmalıdır !!!";
		kullaniciAdi.style.border="1px solid #F00";
		kullaniciAdi.focus();
		return false;
	}
	if(tSifre < 8) {
		mesajDivi.innerHTML="Şifre En az 8 Hane Olmalıdır !!!";
		sifre.style.border="1px solid #F00";
		sifre.focus();
		return false;
	}
	if(tEposta < 8) {
		mesajDivi.innerHTML="Email Adresi En az 8 Hane Olmalıdır !!!";
		eposta.style.border="1px solid #F00";
		eposta.focus();
		return false;
	}
	var postVerisi = "k_adi="+tKullaniciAdi
		+"&sifre="+tSifre
		+"&yetki="+tYetki
		+"&eposta="+tEposta;
	var istek =  nesneOlustur();
	var islemDosyasi = domain+"/ajax_istekleri/kullanici_duzenle/"+kullaniciNo;
	istek.open('POST', islemDosyasi, true);
	istek.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	istek.send(postVerisi);
	istek.onreadystatechange = function() {
		if(istek.readyState == 4) {
			if(istek.responseText == 1) {
				servisFisiEkleKapat();
				golgeKapat();
				location.reload(true);
			} else {
				alert('Ajax İstekleri Dosyasında Hata : '+istek.responseText);
			}
		}
	}
}

function kayitDuzenleFormKontrol(fisNo) {
	document.getElementById('kayit_sonuc').style.display="block";
	var mesajDivi 				= document.getElementById('hataMesaji');
	var mus						= document.getElementById("musteri");
	var tMus						= mus.value.trim();
	var adres					= document.getElementById("adres");
	var tAdres					= adres.value.trim();
	var sehir					= document.getElementById("sehir");
	var tSehir					= sehir.value.trim();
	var tel						= document.getElementById("tel");
	var tTel						= tel.value.trim();
	var email					= document.getElementById("email");
	var tEmail					= email.value.trim();
	var durum					= document.getElementById("durum");
	var tDurum					= durum.value.trim();
	var marka					= document.getElementById("marka");
	var tMarka					= marka.value.trim();
	var cihaz					= document.getElementById("cihaz");
	var tCihaz					= cihaz.value.trim();
	var urunKodu				= document.getElementById("urunKodu");
	var tUrunKodu				= urunKodu.value.trim();
	var urunAdi					= document.getElementById("urunAdi");
	var tUrunAdi				= urunAdi.value.trim();
	var seriNo					= document.getElementById("seriNo");
	var tSeriNo					= seriNo.value.trim();
	var garantiBaslangic		= document.getElementById("garantiBaslangic");
	var tGarantiBaslangic	= garantiBaslangic.value.trim();
	var belgeTuru				= document.getElementById("belgeTuru");
	var tBelgeTuru				= belgeTuru.value.trim();
	var ariza					= document.getElementById("ariza");
	var tAriza					= ariza.value.trim();
	var arizaTanim				= document.getElementById("arizaTanim");
	var tArizaTanim			= arizaTanim.value.trim();
	var islemler				= document.getElementById("islemler");
	var tIslemler				= islemler.value.trim();
	var sayac					= document.getElementById("sayac");
	var tSayac					= sayac.value.trim();
	var teslimTarihi			= document.getElementById("teslimTarihi");
	var tTeslimTarihi			= teslimTarihi.value.trim();
	var servisSekli			= document.getElementById("servisSekli");
	var tServisSekli			= servisSekli.value.trim();
	var gonderiSekli			= document.getElementById("gonderiSekli");
	var tGonderiSekli			= gonderiSekli.value.trim();
	var gonderiDokuman		= document.getElementById("gonderiDokuman");
	var tGonderiDokuman		= gonderiDokuman.value.trim();
	var gonderiUcret			= document.getElementById("gonderiUcret");
	var tGonderiUcret			= gonderiUcret.value.trim();
	var servisUcret			= document.getElementById("servisUcret");
	var tServisUcret			= servisUcret.value.trim();
	var pesinat					= document.getElementById("pesinat");
	var tPesinat				= pesinat.value.trim();
	if(tMus.length < 5) {
		mesajDivi.innerHTML="Müsteri Adı En az 5 Karakter Olmalıdır !!!";
		mus.style.border="1px solid #F00";
		mus.focus();
		return false;
	}
	if(tTel.length < 11) {
		mesajDivi.innerHTML="Telefon En az 11 Karakter Olmalıdır !!!";
		tel.style.border="1px solid #F00";
		tel.focus();
		return false;
	}
	if(tCihaz == 0) {
		mesajDivi.innerHTML="Cihaz Türü Seçilmelidir !!!";
		cihaz.style.border="1px solid #F00";
		cihaz.focus();
		return false;
	}
	var postVerisi = "mus="+tMus
		+"&adres="+tAdres
		+"&sehir="+tSehir
		+"&tel="+tTel
		+"&email="+tEmail
		+"&durum="+tDurum
		+"&marka="+tMarka
		+"&cihaz="+tCihaz
		+"&urunKodu="+tUrunKodu
		+"&urunAdi="+tUrunAdi
		+"&seriNo="+tSeriNo
		+"&garantiBaslangic="+tGarantiBaslangic
		+"&belgeTuru="+tBelgeTuru
		+"&ariza="+tAriza
		+"&arizaTanim="+tArizaTanim
		+"&islemler="+tIslemler
		+"&sayac="+tSayac
		+"&teslimTarihi="+tTeslimTarihi
		+"&servisSekli="+tServisSekli
		+"&gonderiSekli="+tGonderiSekli
		+"&gonderiDokuman="+tGonderiDokuman
		+"&gonderiUcret="+tGonderiUcret
		+"&servisUcret="+tServisUcret
		+"&pesinat="+tPesinat;		
	var istek =  nesneOlustur();
	var islemDosyasi = domain+"/ajax_istekleri/fis_duzenle/"+fisNo;
	istek.open('POST', islemDosyasi, true);
	istek.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	istek.send(postVerisi);
	istek.onreadystatechange = function() {
		if(istek.readyState == 4) {
			if(istek.responseText == 1) {
				servisFisiEkleKapat();
				golgeKapat();
				location.reload(true);
			} else {
				alert('Ajax İstekleri Dosyasında Hata : '+istek.responseText);
			}
		}
	}
}

function hCD(nesneAdi) {
	document.getElementById(nesneAdi).style.border="1px solid #999999";
	document.getElementById('hataMesaji').innerHTML="Bekleniyor";
}

function formTemizle(divAdi) {
  jQuery("#"+divAdi).find(':input').each(function() {
	 switch(this.type) {
		  case 'password':
		  case 'text':
		  case 'textarea':
		  case 'file':
		  case 'select-one':       
				jQuery(this).val('');
				break;
		  case 'checkbox':
		  case 'radio':
				this.checked = false;
	 }
  });
	document.getElementById('kayit_buton').setAttribute('onclick','yeniKayitFormKontrol();');
	document.getElementById('gFisNo').value='';
}

function tarihAramaAc(secici) {
	if(secici.checked) {
		document.getElementById('araBas').readOnly=false;
		document.getElementById('araBas').disabled=false;
		document.getElementById('araBit').readOnly=false;
		document.getElementById('araBit').disabled=false;
	} else {
		document.getElementById('araBas').disabled=true;
		document.getElementById('araBas').readOnly=true;
		document.getElementById('araBas').value='';
		document.getElementById('araBit').disabled=true;
		document.getElementById('araBit').readOnly=true;
		document.getElementById('araBit').value='';
	}
}

function dosyaBoyutu() {
	if(window.ActiveXObject) {
		var dosyaObje		= new ActiveXObject("Scripting.FileSystemObject");
		var dosyaAdresi	= document.getElementById('excel_dosyasi').value;
		var dosyaAdi		= dosyaObje.getFile(dosyaAdresi);
		var dosyaBoyut		= dosyaAdi.size;
	} else {
		var dosyaBoyut		= document.getElementById('excel_dosyasi').files[0].size;
	}
	var boyut				= Math.floor(Math.round(dosyaBoyut*100)/100000);
	if(boyut >= 2048) {
		alert("Dosya Boyutu EN FAZLA 2 MB OLMALIDIR!!!")+boyut;
		document.getElementById("excel_dosyasi").value="";
	}
}

function kullaniciKontrol() {
	var musteri 		= document.getElementById("musteri");
	var tMusteri		= musteri.value.trim();
	postVerisi			= "musteri_adi="+tMusteri;
	var istek			= nesneOlustur();
	var islemDosyasi	= domain+"/ajax_istekleri/kullanici_kontrol";
	istek.open('POST', islemDosyasi, true);
	istek.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	istek.send(postVerisi);
	istek.onreadystatechange = function() {
		if(istek.readyState == 4) {
			if(istek.responseText != 0) {
				document.getElementById("isimler").style.display="block";
				document.getElementById("isimler").innerHTML=istek.responseText;
			} else {
				document.getElementById("isimler").style.display="none";
				document.getElementById("isimler").innerHTML="";	
			}
		}
	}
}

function kBilgiYaz(kNo) {
	postVerisi			= "musteri_no="+kNo;
	var istek			= nesneOlustur();
	var islemDosyasi	= domain+"/ajax_istekleri/kullanici_bilgi_json";
	istek.open('POST', islemDosyasi, true);
	istek.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	istek.send(postVerisi);
	istek.onreadystatechange = function() {
		if(istek.readyState == 4) {
			var veri = JSON.parse(istek.responseText);
			document.getElementById("isimler").style.display="none";
			document.getElementById("isimler").innerHTML="";
			document.getElementById('musteri').value=veri[0].musteri_adi;
			document.getElementById('tel').value=veri[0].tel;
			document.getElementById('email').value=veri[0].email;
			document.getElementById('sehir').value=veri[0].sehir;
			document.getElementById('adres').innerHTML=veri[0].musteri_adresi;
		}
	}
}

function cihazTurGetir(turNo) {
	var sahneDivi		= document.getElementById('turDokum');
	postVerisi			= "islem=duzenle&tur_no="+turNo;
	var istek			= nesneOlustur();
	var islemDosyasi	= domain+"/ajax_istekleri/cihaz_tur_ekle";
	istek.open('POST', islemDosyasi, true);
	istek.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	istek.send(postVerisi);
	istek.onreadystatechange = function() {
		if(istek.readyState == 4) {
			sahneDivi.innerHTML=istek.responseText;			
		}
	}
}

function turMukerrerKontrol(obje) {
	postVerisi			= "cihaz_turu="+obje.value;
	var istek			= nesneOlustur();
	var islemDosyasi	= domain+"/ajax_istekleri/cihaz_tur_mukerrermi";
	istek.open('POST', islemDosyasi, true);
	istek.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	istek.send(postVerisi);
	istek.onreadystatechange = function() {
		if(istek.readyState == 4) {
			if(istek.responseText == "var") {
				document.getElementById('kaydetButon').style.display="none";
			} else {
				document.getElementById('kaydetButon').style.display="inline-block";
			}
		}
	}
}

function yeniTurEkle(nesne) {
	var sahneDivi		= document.getElementById('turDokum');
	postVerisi			= "islem=ekle";
	var istek			= nesneOlustur();
	var islemDosyasi	= domain+"/ajax_istekleri/cihaz_tur_ekle";
	istek.open('POST', islemDosyasi, true);
	istek.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	istek.send(postVerisi);
	istek.onreadystatechange = function() {
		if(istek.readyState == 4) {
			sahneDivi.innerHTML=istek.responseText;			
		}
	}
}

function cihaz_tur_kaydet_kontrol() {
	var cihazTuru	= document.getElementById("cihaz_turu");
	var tCihazTuru	= cihazTuru.value.trim();
	var dosyaAdresi	= document.getElementById("tur_resim").value;
	if(tCihazTuru.length < 3) {
		alert("Cihaz Türü En az 3 Karakter Olmalıdır !!!");
		cihazTuru.style.border="1px solid #F00";
		cihazTuru.focus();
		return false;
	}
	if(dosyaAdresi=="") {
		alert('Resim Seçmelisiniz');
		return false;
	}
}

function cihaz_tur_duzenle_kontrol() {
	var cihazTuru	= document.getElementById("cihaz_turu");
	var tCihazTuru	= cihazTuru.value.trim();
	var dosyaAdresi	= document.getElementById("tur_resim").value;
	if(tCihazTuru.length < 3) {
		alert("Cihaz Türü En az 3 Karakter Olmalıdır !!!");
		cihazTuru.style.border="1px solid #F00";
		cihazTuru.focus();
		return false;
	}
}

function yeniMarkaEkle(nesne) {
	var sahneDivi		= document.getElementById('turDokum');
	postVerisi			= "islem=ekle";
	var istek			= nesneOlustur();
	var islemDosyasi	= domain+"/ajax_istekleri/cihaz_marka_ekle";
	istek.open('POST', islemDosyasi, true);
	istek.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	istek.send(postVerisi);
	istek.onreadystatechange = function() {
		if(istek.readyState == 4) {
			sahneDivi.innerHTML=istek.responseText;			
		}
	}
}

function cihazMarkaGetir(markaNo) {
	var sahneDivi		= document.getElementById('turDokum');
	postVerisi			= "islem=duzenle&marka_no="+markaNo;
	var istek			= nesneOlustur();
	var islemDosyasi	= domain+"/ajax_istekleri/cihaz_marka_ekle";
	istek.open('POST', islemDosyasi, true);
	istek.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	istek.send(postVerisi);
	istek.onreadystatechange = function() {
		if(istek.readyState == 4) {
			sahneDivi.innerHTML=istek.responseText;			
		}
	}
}