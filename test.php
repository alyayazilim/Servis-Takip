<?php header("Content-type:text/html; charset=utf-8");
	/*
	a:4:{
		s:9:"firma_adi";s:28:"Kadir TUTAK - Tutak Bilişim";
		s:4:"mail";s:22:"satis@tutakbilisim.com";
		s:2:"il";s:11:"Diyarbakır";
		s:10:"firma_logo";s:68:"99f935be4d1f1290503db44912337ac9089b0f2b4f264163a162f27c3d7d5d48.png";

	}
	*/
	$veriler = array(
		'firma_adi'			=> 'Güner ARIK',
		'mail'				=> 'guner@gunerarik.com.tr',
		'il'					=> 'İZMİR',
		'firma_logo'		=> '99f935be4d1f1290503db44912337ac9089b0f2b4f264163a162f27c3d7d5d48.png',
		'mail_sunucusu'	=> 'gunerarik.com.tr',
		'mail_kull_adi'	=> 'guner@gunerarik.com.tr',
		'mail_sifresi'		=> 'Burak2K3'
	);
	echo serialize($veriler);
	echo '<br/ >'.md5('11223344as');
?>