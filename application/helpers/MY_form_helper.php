<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

	function set_value ($inputAdi, $varsayilanDurum='') {
		$CI =& get_instance();
		$cikis = $varsayilanDurum;
		if($CI->input->post()) {
			$cikis = $CI->input->post($inputAdi);
		}

		if($CI->input->get()) {
			$cikis = $CI->input->get($inputAdi);
		}
		return $cikis;
	}
//}

/* MY_form_helper.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/helpers/MY_form_helper.php Adresinde Kayıtlı */