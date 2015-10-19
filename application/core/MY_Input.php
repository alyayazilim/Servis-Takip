<?php header("Content-type:text/html; charset=utf-8");
	if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

class MY_Input extends CI_Input {

	function sorguKaydet($sorguDize) {
		$CI =& get_instance();
		$CI->db->insert(
			'ci_sorgulari', array(
				'sorgu_cumlesi' => http_build_query($sorguDize), 'kullanici_no' => $_SESSION['k_no']
			)
		);
		return $CI->db->insert_id();
	}

	function sorguGetir($sorguNo) {
		$CI =& get_instance();
		$sonuc = $CI->db->get_where(
			'ci_sorgulari', array(
				'sorgu_no' => $sorguNo,
				'kullanici_no' => $_SESSION['k_no']
			)
		)->result();
		if(isset($sonuc[0])) {
			parse_str($sonuc[0]->sorgu_cumlesi, $_GET);
		}
	}

}

/* MY_Input.php Dosyasının Sonu */
/*  Hazırlayan Güner ARIK  */
/*     0(546) 862 62 48    */
/*  guner@gunerarik.com.tr */
/* ./application/libraries/MY_Input.php Adresinde Kayıtlı */