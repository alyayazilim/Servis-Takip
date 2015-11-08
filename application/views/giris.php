<?php header("Content-type: text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

	echo '<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>'.$firma_adi.' - Servis Takip</title>
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
	<body>';
	if($this->config->item('bakimModu') != TRUE) {
		echo '<div class="container">
			<div class="row vertical-offset-100">
				<div class="col-md-4 col-md-offset-4">
					<div class="panel panel-default">
						<div class="panel-heading">                                
							<div class="row-fluid user-row">
								<img src="'.base_url().'resimler/firma/'.$firma_logo.'" class="img-responsive" title="'.$firma_adi.'"/>
							</div>
						</div>
						<div class="panel-body">
							<form accept-charset="UTF-8" role="form" class="form-signin"  action="'.base_url().'servis/giris_islem" method="POST">
								<fieldset>
									<label class="panel-login">
										<div class="login_result"></div>
									</label>
									<input class="form-control" placeholder="kullanıcı adı" id="kAdi" name="kAdi" type="text" value="'.set_value('kAdi').'">';
									if(form_error('kAdi')) {
										echo '<div class="alert alert-danger" role="alert">'.form_error('kAdi').'</div>';
									}
									echo '<input class="form-control" placeholder="şifre" name="kSifre" id="kSifre" type="password">';
									if(form_error('kSifre')) {
										echo '<div class="alert alert-danger" role="alert">'.form_error('kSifre').'</div>';
									}
									echo '</br>
									<div class="gkod" style="text-align: center;"><img src="'.base_url().'sistem_yonetimi/guvenlik_resmi" style="border: 1px solid red;"></div>'."\r\n".'
									<div class="gkoda" ><br />
										<input name="gKodu" type="text" class="form-control" autocomplete="off" /></div>';
										if(form_error('gKodu')) {
										echo '<div class="alert alert-danger" role="alert">'.form_error('gKodu').'</div>';
									}
									echo '<input class="btn btn-lg btn-success btn-block" type="submit" id="login" value="Giriş »">
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>';
}
	echo '<div class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
			<div id="frmBilgi">'.$frmCopyright.'</div>
			<div class="container">'.@$sayfalama.'</div>
			
		</div>
	</body>
</html>';