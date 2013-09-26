<?php 
/* 
Plugin Name: Wp-Trafficfeed
Description: Wordpress plugin for link exchange, automatic link exchange/automatic backlinks.
Author: Iqbal Chintaman and www.TrafficFeed.com
Version: 1.0 
*/ 

class tf{

	private $div_html = null;
	private $encoding = null;
	private $server_url = 'http://trafficfeed.com/api.php';

	public function __construct() {
		$this->plugin_url = plugins_url();
		//$this->service_url = 'http://192.168.1.16/tf/services.php';
		$this->service_url = 'http://www.trafficfeed.com/services.php';
		$this->plugin_folder = dirname (__FILE__); 
		add_action( 'init', array($this, $this->prefix.'tf_plugin_init' ) );
		
	}
	
	function tf_plugin_init(){
		wp_enqueue_script('tf_ajax',   $this->plugin_url . '/js/system.js', array( 'jquery'));  
		wp_localize_script( 'tf_ajax', 'tf_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
		add_action( 'wp_ajax_tf_login',array( &$this, 'tf_login'));
		add_action( 'wp_ajax_tf_logout',array( &$this, 'tf_logout'));
		add_action( 'wp_ajax_tf_register',array( &$this, 'tf_register'));
		add_action( 'wp_ajax_tf_domian_activate',array( &$this, 'tf_domian_activate'));
		add_action( 'wp_ajax_tf_manage_domain',array( &$this, 'tf_manage_domain'));
		add_action( 'wp_ajax_tf_reset',array( &$this, 'tf_reset'));
		add_filter('widget_text', 'do_shortcode');
		add_shortcode("TF-SHOW", array($this, 'tf_shortcode')); 
		add_action( 'admin_menu', array( &$this, 'tf_menu' ) );
	}
	
	function tf_manage_domain(){
		$token = get_option('tf_token');
		if(!$token){
			die();	
		}
		$title = urlencode($_POST['title']);
		$tf_category = urlencode($_POST['tf_category']);
		$domain_url = urlencode($_POST['domain']);
		$description = urlencode($_POST['description']);
		$home_url = urlencode(home_url());
		$domain   = urlencode($token['domain']);
		$username = urlencode($token['username']);
		$token    = urlencode($token['token']);
		$string ="token=$token&username=$username&domain=$domain";
		$string .="&title=$title&category=$tf_category";
		$string .="&domain_url=$domain_url&description=$description&url=$home_url";
		$ch = curl_init($this->service_url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL,$this->service_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,"act=manage_site&$string");
		$response = curl_exec ($ch);
		
		if($response){
		  $result = json_decode($response);
		  if($result->status==1){
			  echo "<script>jQuery(':input','#tf_add_site')
					 .not(':button, :submit, :reset, :hidden')
					 .val('')
					 .removeAttr('checked')
					 .removeAttr('selected');";
			  echo "jQuery('.tf_success').html('".$result->msg."');jQuery('.tf_success').show();</script>";
		  }else {
			  echo "<script>jQuery('.tf_error').html('".$result->msg."');jQuery('.tf_error').show();</script>";
		  }
	   }
	   
	  curl_close ($ch); 
	  die();
	}
	
	function tf_register(){
			$tf_first_name = urlencode($_POST['tf_first_name']);
			$tf_last_name = urlencode($_POST['tf_last_name']);
			$tf_username = urlencode($_POST['tf_username']);
			$tf_email = urlencode($_POST['tf_email']);
			$tf_password = urlencode($_POST['tf_password']);
			$tf_c_password = urlencode($_POST['tf_c_password']);
			$string ="first_name=$tf_first_name&last_name=$tf_last_name";
			$string .="&username=$tf_username&email=$tf_email";
			$string .="&password=$tf_password&cpassword=$tf_c_password";
			$ch = curl_init($this->service_url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL,$this->service_url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,"act=register&$string");
			$response = curl_exec ($ch);
			
			if($response){
				
				$result = json_decode($response);
				
				if($result->status==1){
					echo "<script>jQuery(':input','#frm_tf_reg')
					 .not(':button, :submit, :reset, :hidden')
					 .val('')
					 .removeAttr('checked')
					 .removeAttr('selected');";
					echo "jQuery('.tf_error').hide();jQuery('.tf_success').html('".$result->message."');jQuery('.tf_success').show();</script>";
				}else {
					echo "<script>jQuery('.tf_success').hide();jQuery('.tf_error').html('".$result->message."');jQuery('.tf_error').show();</script>";
				}
			}
			 
			curl_close ($ch); 
			die();
		
	}
	
	function tf_domian_activate(){
			
		$token = get_option('tf_token');
		if($token){
			
			$domain   = urlencode($token['domain']);
			$username = urlencode($token['username']);
			$token    = urlencode($token['token']);
			$response = file_get_contents($this->service_url."?act=activate_domain&domain=$domain&username=$username&token=$token");
		
			$response = json_decode($response);
			
			switch($response->domain->status){
				
				case 1:
					echo "<script>jQuery('#domain_status').html('<p>Your site has been verified.</p>');</script>";
					die();
				break;
				default :
					echo "<script>jQuery('#domain_act_response').html('".$result->domain->message."');</script>";
					die();
				break;
					
			}
		}else{
			echo "<script>jQuery('#domain_act_response').html('Bad request.');</script>";	
			die();
		}
		die();
	}
	
	function tf_login(){
		if(!empty($_POST['tf_username']) && !empty($_POST['tf_password'])){ 
			$domain = trim(home_url());
			$username = urlencode($_POST['tf_username']);
			$password = urlencode($_POST['tf_password']);
			$ch = curl_init($this->service_url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL,$this->service_url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,
						  "act=login&username=$username&password=$password&domain=$domain");
			$response = curl_exec ($ch);
			
			if($response){
				$result = json_decode($response);
				
				if($result->login->status==1){
					$domain = $this->fix_url(trim(home_url()));
					$token['username']=trim($username);
					$token['domain']=$domain;
					$token['token']=$result->login->token;
					update_option('tf_token',$token);
					echo "<script>window.location.href=window.location.href;</script>";
				}else {
					echo "<script>jQuery('.tf_error_msg').html('".$result->login->message."');jQuery('.tf_error_msg').show();</script>";
				}
			}
			 
			curl_close ($ch); 
			die();
		}else{
			echo "<script>jQuery('.tf_error_msg').html('Invalid Login Details.');jQuery('.tf_error_msg').show();</script>";
			die();
		}
	}
	
	function get_user_info(){
		$token = get_option('tf_token');
		if($token){
			$domain   = urlencode($token['domain']);
			$username = urlencode($token['username']);
			$token    = urlencode($token['token']);
			$url = $this->service_url."?act=user_info&domain=$domain&username=$username&token=$token";
			$user = file_get_contents($url);
			
			$user = json_decode($user);
			return $user;
		}
	}
	
	function tf_reset(){
		 delete_option('tf_token');
		 echo "<script>window.location.href=window.location.href;</script>";
		 die();
	}
	function tf_logout(){
		$token = get_option('tf_token');
		if($token){
			$domain   = urlencode($token['domain']);
			$username = urlencode($token['username']);
			$token    = urlencode($token['token']);
			$url = $this->service_url."?act=logout&domain=$domain&username=$username&token=$token";
			$response = $this->send_request($url);
			$response = json_decode($response);
			if($response->status==1){
				delete_option('tf_token');
				echo "<script>window.location.href=window.location.href;</script>";
			}else{
				echo "<script>alert('Bad request please try again later');</script>";	
			}
		}else{
			echo "<script>alert('Bad request please try again later');</script>";	
			die();
		}
		die();
	
	}
	
	function send_request($url){
		$options = array(
			CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_FOLLOWLOCATION => true,     // follow redirects
			CURLOPT_ENCODING       => "",       // handle all encodings
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 180,      // timeout on connect
			CURLOPT_TIMEOUT        => 180,      // timeout on response
		 
		);
		$ch      = curl_init( $url );
		curl_setopt_array( $ch, $options );
		$curl_scraped_page = curl_exec( $ch );
		
		curl_close( $ch );
		return $curl_scraped_page;
	}
	
	function fix_url($url) {
		
		if (substr($url, 0, 4) == 'www.') { return $url; }
		if (substr($url, 0, 7) == 'http://') { 
			if (substr($url, 0, 10) == 'http://www') { 
				return substr($url, 7); 
			}else{
				return "www.".substr($url, 7); 
			}
		}
		if (substr($url, 0, 8) == 'https://') { 
			if (substr($url, 0, 11) == 'https://www') { 
				return substr($url, 8); 
			}else{
				return "www.".substr($url, 8); 
			}
		}
		
		
		
		return  $url;
	}
	
	function redirect_url($url) {
		if (substr($url, 0, 4) == 'http://') { return $url; }
		if (substr($url, 0, 4) == 'www.') { return $url; }
		if (substr($url, 0, 12) == 'https://www') { return $url; }
		if (substr($url, 0, 12) == 'http://www') { return $url;; }
		return  'http://'. $url;
	}
	
	function tf_menu() {
		add_menu_page('TF Help', 'TF Help', 'administrator', 'tf_admin_menu', array( &$this, 'tf_help' ),plugins_url('/icon/icon.ico', __FILE__));
		add_submenu_page( "tf_admin_menu", 'TF Settings', 'TF Settings', 5,'tf_settings',  array($this, 'tf_settings' ));
	}
	function tf_help(){
		include('help.php');
	}
	
	function tf_settings(){
		include($this->plugin_folder.'/includes/settings.php');
	}
	
	function get_tf_categories(){
		$response = file_get_contents($this->service_url."?act=categories");
		return $response;
	}
	
	function tf_check_domain($token=array()){
		if(count($token)>0){
			
			$domain   = urlencode($token['domain']);
			$username = urlencode($token['username']);
			$token    = urlencode($token['token']);
			
			$response = file_get_contents($this->service_url."?act=domain_check&domain=$domain&username=$username&token=$token");
			
			return $response;
		}else{
			$domain = urlencode(home_url());
			//die($domain);
			//echo $this->service_url."?act=domain_check&domain=$domain";
			$response = file_get_contents($this->service_url."?act=domain_check&domain=$domain");
			
			
			return $response;
		}
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