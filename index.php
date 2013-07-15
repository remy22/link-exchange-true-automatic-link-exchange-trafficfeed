<?php 
/* 
Plugin Name: Wp-Trafficfeed
Description: Wordpress plugin for displaying links.
Author: Iqbal Chintaman and www.TrafficFeed.com
Version: 1.0 
*/ 

class tf{

	private $div_html = null;
	private $encoding = null;
	private $server_url = 'http://trafficfeed.com/api.php';

	public function __construct() {

		add_filter('widget_text', 'do_shortcode');

		add_shortcode("TF-SHOW", array($this, 'tf_shortcode')); 

		add_action( 'admin_menu', array( &$this, 'tf_menu' ) );

	}
	function tf_menu() {
		add_menu_page('TF Help', 'TF Help', 'administrator', __FILE__, array( &$this, 'tf_help' ),plugins_url('/icon/icon.ico', __FILE__));
	}
	function tf_help(){
		include('help.php');
	}
	function tf_shortcode( $atts ) { 
		extract( shortcode_atts( array( 
			'show' => '' 
		), $atts ) ); 
		$the_html = $this->get_html($show); 
		return $the_html; 
	} 
	function get_html($show){
		if($show=="receive_dir"){
			$REQ_URI =  "";
		}else {
			$REQ_URI =  $this->_env('REQUEST_URI');
		}
		$div_url = $this->_env('HTTP_HOST') . $REQ_URI ;
		if(isset($_REQUEST['category'])){
			$query =  '&category='.$_REQUEST['category'];
		}else{
			$query =  '';
		}
		$div_url = (substr($div_url, -1) == '/' ? substr($div_url, 0, -1) : $div_url);
		$div_url = (substr($div_url, 0, 7) == 'http://' ? substr($div_url, 7) : $div_url);
		$div_url = (substr($div_url, 0, 4) == 'www.' ? substr($div_url, 4) : $div_url);
		$this->div_html = file_get_contents($this->server_url . '?mod='.$show.$query.'&act=licence&obj='.$div_url);
		if(isset($encoding)) {
			$this->encoding = strtoupper($encoding);
		}
		if($this->encoding) {
			return iconv('UTF-8', $this->encoding, $this->div_html);
		}
		return $this->div_html;
	}
	public function receiveDiv() {
		if($this->encoding) {
			return iconv('UTF-8', $this->encoding, $this->div_html);
		}
		return $this->div_html;
	}

	public function receiveDirectory() {
		if($this->encoding) {
			return iconv('UTF-8', $this->encoding, $this->div_html);
		}
		return $this->div_html;

	}

	public function __toString() {

		if($this->encoding) {
			return iconv('UTF-8', $this->encoding, $this->div_html);
		}
		return $this->div_html;

	}


	private function _env($key) {
		if (isset($_SERVER[$key])) {
			return $_SERVER[$key];
		} elseif (isset($_ENV[$key])) {
			return $_ENV[$key];
		} elseif (getenv($key) !== false) {
			return getenv($key);
		}
		return null;
	}

}
$tf = new tf();