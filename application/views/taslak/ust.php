<?php header("Content-type: text/html; charset=utf-8");
if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

	echo '<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>'.$firma_adi.' - Servis Takip</title>
		<link rel="stylesheet" href="'.base_url().'css/bootstrap.min.css">
		<link rel="stylesheet" href="'.base_url().'css/jquery-ui.min.css">
		<link rel="stylesheet" href="'.base_url().'css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="'.base_url().'css/servis.css" type="text/css" />
		<link rel="shortcut icon" href="'.base_url().'resimler/favicon.ico"/>
		<script type="text/javascript" src="'.base_url().'javascript/jquery-1.11.2.min.js"></script>
		<!-- <script src="'.base_url().'javascript/TweenLite.min.js"></script> -->
		<script src="'.base_url().'javascript/bootstrap.min.js"></script>
		<script src="'.base_url().'javascript/jquery-2.1.4.js"></script>
		<script src="'.base_url().'javascript/jquery-ui.min.js"></script>
		<script src="'.base_url().'javascript/jquery.inputmask.js"></script>
		<script src="'.base_url().'javascript/jquery-ui.min.js"></script>
		<script src="'.base_url().'javascript/datepicker-tr.js"></script>
		<script src="'.base_url().'javascript/servis_takip.js"></script>
	</head>
	<body>
	<div id="golge">
	</div>
	<div id="container">';
		
	if($this->config->item('oturumDok') == TRUE) {
		echo '<pre class="od">';
		print_r($this->session->all_userdata());
		echo '</pre>';
	}

	if($gosterilecekSayfa != 'giris') {
		echo '<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li';
						echo $this->uri->segment(1) == 'servis' ? ' class="active"' : '';
						echo '><a href="'.base_url().'servis/listele">Servis Fişleri</a></li>
						<li';
						echo $this->uri->segment(1) == 'kullanici' ? ' class="active"' : '';
						echo '><a href="'.base_url().'kullanici/listele">Kullanıcı İşlemleri</a></li>
						<li';
						echo $this->uri->segment(1) == 'sistem_yonetimi' ? ' class="active"' : '';
						echo '><a href="'.base_url().'sistem_yonetimi/sistem_ayar">Sistem Ayarları</a></li>';
					echo '</ul><div id="sonAktivite"><span style="color:red;">'.$this->session->userdata('k_adi').'</span><tab>Son Giriş:'.$this->session->userdata('sonGiris').'</div>
					<ul class="nav navbar-nav navbar-right">
						<li><a id="cikisTus" href="'.base_url().'servis/cikis" title="Çıkış">Çıkış</a></li>
					</ul>
				</div>
			</div>
		</nav>';
		if($this->uri->segment(1) == "sistem_yonetimi") {
			echo '<ul class="altLink golge collapse navbar-collapse">
				<li><a';
				echo $this->uri->segment(2)=='sistem_degisken' ?  ' class="secili"' : '';
				echo ' href="'.base_url().'sistem_yonetimi/sistem_degisken">Firma Bilgileri</a></li>
				<li><a';
				echo $this->uri->segment(2)=='cihaz_tur' ?  ' class="secili"' : '';
				echo ' href="'.base_url().'sistem_yonetimi/cihaz_tur">Cihaz Türleri</a></li>
				<li><a';
				echo $this->uri->segment(2)=='markalar' ?  ' class="secili"' : '';
				echo ' href="'.base_url().'sistem_yonetimi/markalar">Markalar</a></li>
				<!-- <li><a';
				echo $this->uri->segment(2)=='site_ayar' ?  ' class="secili"' : '';
				echo ' href="'.base_url().'sistem_yonetimi/site_ayar">Site Ayarları</a></li> -->
			</ul>';
		}
	}