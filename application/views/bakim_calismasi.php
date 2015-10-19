<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

	if($this->config->item('bakimModu') == FALSE) {
		header('Location:'.base_url().'servis');
	} else {
		echo '<!DOCTYPE html>
		<html lang="en">
			<head>
				<meta charset="utf-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<title>'.@$firmaAdi.' - Servis Takip</title>
				<script type="text/javascript" src="'.base_url().'javascript/jquery-1.11.2.min.js"></script>
				<!-- <script src="'.base_url().'javascript/TweenLite.min.js"></script> -->
				<link rel="stylesheet" href="'.base_url().'css/bootstrap.min.css">
				<link rel="stylesheet" href="'.base_url().'css/bootstrap-theme.min.css">
				<script src="'.base_url().'javascript/bootstrap.min.js"></script>
				<script src="'.base_url().'javascript/jquery-2.1.4.js"></script>
				<script src="'.base_url().'javascript/servis_takip.js"></script>
				<link rel="shortcut icon" href="'.base_url().'resimler/favicon.ico"/>
				<link href="'.base_url().'css/servis.css" rel="stylesheet" type="text/css" />
			</head>
			<body>
				<div class="jumbotron bakimUyarisi">
					<h1>SİTE BAKIMI</h1>
					<p>Ulaşmaya çalıştığınız site teknik sebeplerden dolayı,<br />belli bir süreliğine bakıma alınmıştır.<br />Lütfen daha sonra tekrar deneyiniz !!!</p>
				</div>
			</body>
		</html>';
	}

/*  Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */