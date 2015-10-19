<?php header("Content-type:text/html; charset=utf-8");
	
	$veri = array(
		'firma_adi'		=> 'Güner ARIK Firması',
		'mail'			=> 'h.guner.arik@gmail.com',
		'il'				=>	'İZMİR',
		'firma_logo'	=> '7253c89c00d88f1e2270e950b64646d4bc9f50fbc72fe6125478ab7633492cb4.png'
	);
	echo serialize($veri);
