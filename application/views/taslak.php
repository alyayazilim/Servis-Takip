<?php header("Content-type: text/html; charset=utf-8");
if(!defined('BASEPATH')) exit('Bu Sayfaya Direk Erişim Sağlayamazsınız');

	if( $this->config->item('bakimModu') == TRUE ) {
		redirect('bakim_calismasi');
	} elseif( !$this->session->has_userdata('k_no') || !$this->session->has_userdata('k_adi') || !$this->session->has_userdata('yetki') ) {
		redirect('giris');
	} else {
		$this->load->view('taslak/ust');
		$this->load->view($gosterilecekSayfa);
		$this->load->view('taslak/alt');
	}