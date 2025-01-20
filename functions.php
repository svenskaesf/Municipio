<?php //Municipio functions file

define('MUNICIPIO_PATH', get_template_directory() . '/');

require_once MUNICIPIO_PATH . '/library/Bootstrap.php';


//Extend login session to 1 year
add_filter( 'auth_cookie_expiration', 'extend_login_session' );
function extend_login_session( $expire ) {
  return 31556926; // seconds for 1 year time period
}

// Function to verify a signed cookie
function verify_signed_cookie($name, $key) {

    if (isset($_COOKIE[$name])) {
        
        $secret_key = $key; // Use the same secure secret key

        list($value, $signature) = explode('|', $_COOKIE[$name], 2);
    
        $expected_signature = hash_hmac('sha256', $value, $secret_key);
        
		settype ($expected_signature, "string");
		settype ($signature, "string");

        if (hash_equals($expected_signature, $signature)) {
            return $value;
        } else {
            // Invalid signature
            return false;
        }
        
    }
    return false; // Cookie not set
}

//Check the cookie on wp init
add_action( 'init', 'read_ad_cookie' );
function read_ad_cookie() {

	  $cookie_name    = "wordpress_AD";

	  //Get the AD username from the cookie
	  $username = verify_signed_cookie($cookie_name, AUTH_KEY); 

	  if($username){
		$user = get_user_by('login', $username );
		$current_user = wp_get_current_user();
  
		 //Need to check if already logged in
		  if(!$current_user->exists()){
        
			  if ($_SERVER['REQUEST_URI']=="/") {
             
				  // Check if the user exists
				 if ($user) {
                    wp_clear_auth_cookie();
				  	wp_set_current_user($user->ID, $username);
				  	wp_set_auth_cookie($user->ID);
                    //wp_redirect( home_url(), 301 );
                    //exit;
                    header("Refresh: 0.1");
				}
			}
		  }
	  }
}

add_action('after_setup_theme', function () {
    load_theme_textdomain('municipio', get_template_directory() . '/languages');
});
