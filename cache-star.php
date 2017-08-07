<?php
/*

Plugin Name: Cache Star!
Plugin URI:  https://wpgo.com.au/
Version: v0.1
Description: Caching Management Plugin for WPGO.com.au Users
Author:  WordPress Go 
Author URI:  https://wpgo.com.au/


*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


add_action( 'admin_menu', 'cache_star_plugin_menu' );

function cache_star_plugin_menu() {

	//add_options_page( 'My Plugin Options', 'Cache Star', 'manage_options', 'cache-star', 'cache_star_plugin' );
	//add_submenu_page('tools.php','Cache Star','manage_options','cache-star','cache_star_plugin');
	add_management_page( 'My Plugin Options', 'Cache Star', 'manage_options', 'cache-star', 'cache_star_plugin');
}

function cache_star_plugin() {

	if ( !current_user_can( 'manage_options' ) )  {

		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );

	}

	$force_https_status = cache_star_is_enabled_force();
	$gzip_status = cache_star_is_enabled_gzip();
	$pagespeed_status = cache_star_is_enabled_pagespeed();

	if($force_https_status == true){
		$force_https_text = '<span class="cache-star-status cache-star-enabled">ENABLED</span>';
		$force_summary_status = '<span class="cache-star-enabled"><strong>COMPLETED</strong></span>';
	}else{
		$force_https_text = '<span class="cache-star-status cache-star-disabled">DISABLED</span>';
		$force_summary_status = '<span class="cache-star-disabled"><strong>FALSE</strong></span>';
	}

	if( $gzip_status == true){
		$gzip_text = '<span class="cache-star-status cache-star-enabled">ENABLED</span>';
		$gzip_summary_status = '<span class="cache-star-enabled"><strong>COMPLETED</strong></span>';
	}else{
		$gzip_text = '<span class="cache-star-status cache-star-disabled">DISABLED</span>';
		$gzip_summary_status = '<span class="cache-star-disabled"><strong>FALSE</strong></span>';
	}	

	if( $pagespeed_status == true ){
		$pagespeed_text = '<span class="cache-star-status cache-star-enabled">ENABLED</span>';
		$pagespeed_summary_status = '<span class="cache-star-enabled"><strong>COMPLETED</strong></span>';
	}else{
		$pagespeed_text = '<span class="cache-star-status cache-star-disabled">DISABLED</span>';
		$pagespeed_summary_status = '<span class="cache-star-disabled"><strong>FALSE</strong></span>';
	}


	//$check_modpagespeed = check_pagespeed();
	$check_modpagespeed = cache_star_headers();
	
	
	if( !$check_modpagespeed || gethostname() != 's1.wpgo.com.au'){

		$modepagespeed_summary = '<span class="cache-star-disabled"><strong>FALSE</strong></span>';
		$modpagespeed = '<span class ="cache-top-span">Note: </span><p>Your Hosting account does not have Google Mod Page Speed installed.</p>';
	}else{
		$modepagespeed_summary = '<span class="cache-star-enabled"><strong>COMPLETED</strong></span>';
	}

	?>
	<div class="cache-star-container">
		<div class ="cache-star-top">
			<div class = "cache-star-title">
				<h1>WPGO CACHE STAR</h1>
			</div>
			
		</div>
		
		<div class ="cache-top">
	
			<?php echo $modpagespeed; ?>

			<button id="cache-star-purge" class="btn btn-primary">PURGE GOOGLEPAGESPEED CACHE</button>
		</div>
		<div class="alerts-container"></div>
		<div class ="cache-star-controls">
			<div class ="cache-star-option">
				<h4><strong>Page Cache </strong></h4>
				<div class ="cache-status-wrap">
					<label>Enabled/Disabled: </label>
					<?php echo $pagespeed_text; ?>
				
					<div class ="cache-star-btn-wrap">
						<button id="cache-star-enable" class="btn btn-success" type="button">Enable</button><button id="cache-star-disable" class="btn btn-danger" type="button">Disable</button>
					</div>
				</div>
			</div>

			<div class ="cache-star-option">
				<h4><strong>GZIP</strong></h4>
				<div class ="cache-status-wrap">
					<label>Enabled/Disabled: </label>
					<?php echo $gzip_text; ?>
					
					<div class ="cache-star-btn-wrap">
						<button id="cache-gzip-enable" class="btn btn-success" type="button">Enable</button>
						<button id="cache-gzip-disable" class="btn btn-danger" type="button">Disable</button>
					</div>
				</div>	
			</div>
			

		</div>

		<div class ="cache-star-summary">
			
			
			<div class="https-note">
				<ul>
					<li>It will redirect all your traffic through HTTPS. Thus, your site will always load through a secure connection and you will avoid duplicate content.</li>
					<li>It will also make the connection to any resource your site includes secure. This way the visitors will not see mixed content warning in the browser. <strong>Note:</strong> If your site includes a resource from an external location that cannot be reached via HTTPS this resource will no longer be loaded on your site.</li>
					<li>Once your site is loaded through HTTPS it will also automatically take advantage of the HTTP/2 protocol too.</li>
				</ul>
				<span><strong>Important:</strong> You may have to login again if you decide to disable the force HTTPS functionality!</span>
				<span><strong>Important:</strong> Once you switch your site to go through HTTPS, please check all third-party services that you're using on your site like Gogle Analytics, social networks sharing icons, etc.</span>
			</div>
			<div class ="cache-star-option cache-star-https-option">
					<h4><strong>Force HTTPS</strong></h4>
					<div class ="cache-status-wrap">
						<label>Enabled/Disabled: </label>
						<?php echo $force_https_text; ?>
						
						<div class ="cache-star-btn-wrap">
							<button id="cache-star-force-enable" class="btn btn-success" type="button">Enable</button>
							<button id="cache-star-force-disable" class="btn btn-danger" type="button">Disable</button>
						</div>
					</div>	
				</div>
				



		</div>
		<div class ="cache-star-logo">
			<!--<img src="<?php echo plugin_dir_url( __FILE__ ); ?>images/logo.png">-->
			<h4><strong>OPTIMIZATION SUMMARY: </strong></h4>
			<div class = "single-summary">
				<p>Hosted with WPGO: <?php echo $modepagespeed_summary; ?></p>
				
			</div>
			<div class = "single-summary">
				<p>HTTPS Enabled: <?php echo $force_summary_status; ?></p>
			</div>	
			<div class = "single-summary">
				<p>GZIP Enabled: <?php echo $gzip_summary_status; ?></p>	
			</div>
			<div class = "single-summary">		
				<p>Page Speed: <?php echo $pagespeed_summary_status; ?></p>
			</div>	
		</div>




		<div class="cache-star-htaccess-wrap">
			<h4><strong>WP Text Editor</strong></h4>
			<textarea rows="10" col="40" id="cache-star-htaccess"><?php echo cache_star_get_htaccess(); ?></textarea>
			<br>
			<button id="save_htaccess" class="btn btn-success">Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>

		</div>
	</div>
<?	
}

function get_htaccess_content(){


}


add_action( 'admin_footer', 'my_action_javascript' ); 

function my_action_javascript() { ?>
	<script type="text/javascript" >
	jQuery(document).ready(function($) {
		jQuery("#cache-star-force-enable").on('click', function(){
			
			var data = {

				'action': 'cache_star_force_enable'

			};
			
			
			jQuery.post(ajaxurl, data, function(response) {


				if( response.trim() == 'success' ){
					
					location.reload();

				}else{
					//location.reload();
					jQuery(".alerts-container").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Failed to enable Cache</div>');
				}
			});
		});

		jQuery("#cache-star-force-disable").on('click', function(){
			
			var data = {

				'action': 'cache_star_force_disable'

			};
			
			jQuery.post(ajaxurl, data, function(response) {


				if( response.trim() == 'success' ){
					
					location.reload();

				}else{
					//location.reload();
					jQuery(".alerts-container").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Failed to enable Cache</div>');
				}
			});
		});

		jQuery("#cache-star-purge").on('click', function(){
			
			var data = {

				'action': 'cache_star_purge'

			};
			
			jQuery.post(ajaxurl, data, function(response) {

				console.log(response);

				if( response.indexOf("Purge successful1") !== -1 ){

					jQuery(".alerts-container").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Purge Successfull</div>');
					//location.reload();

				}else{

					jQuery(".alerts-container").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Purge Failed</div>');

				}
			});
		});


		jQuery("#cache-star-enable").on('click', function(){

			var data = {
				'action': 'cache_star_enable'
			};

			jQuery.post(ajaxurl, data, function(response) {
				
				if( response.trim() == 'success' ){
					

					/*jQuery(".cache-star-status").addClass('cache-star-enabled');
					jQuery(".cache-star-status").removeClass('cache-star-disabled');
					jQuery(".cache-star-status").html("ENABLED");
					jQuery(".alerts-container").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Successfully enabled Cache</div>');*/
					location.reload();

				}else{
					jQuery(".alerts-container").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Failed to enable Cache</div>');
				}
			});
		});


		jQuery("#cache-star-disable").on('click', function(){

			var data = {
				'action': 'cache_star_disable'
			};

			jQuery.post(ajaxurl, data, function(response) {
				if( response.trim() == 'success' ){
					/*jQuery(".cache-star-status").addClass('cache-star-disabled');
					jQuery(".cache-star-status").html("DISABLED");
					jQuery(".alerts-container").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Successfully disabled Cache</div>');*/
					location.reload();
				}else{
					jQuery(".alerts-container").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Failed to disable Cache</div>');

				}
			});
		});


		jQuery("#cache-gzip-enable").on('click', function(){
			
			var data = {
				'action': 'cache_star_gzip_enable'				
			};
			
			jQuery.post(ajaxurl, data,function(response) {
				if( response.trim() == 'success' ){
					/*jQuery(".cache-star-status").addClass('cache-star-enabled');
					jQuery(".cache-star-status").html("ENABLED");
					jQuery(".alerts-container").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Successfully enabled GZIP</div>');*/
					location.reload();
				}else{
					jQuery(".alerts-container").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Failed to enable GZIP</div>');
				}

			});

		});



		jQuery("#cache-gzip-disable").on('click', function(){
			var data = {
				'action': 'cache_star_gzip_disable'
			};

			jQuery.post(ajaxurl, data, function(response) {
				if( response.trim() == 'success' ){
					
					location.reload();
				}else{
					jQuery(".alerts-container").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Failed to disable GZIP</div>');

				}
			});

		});

		
		jQuery("#save_htaccess").on('click', function(){
			text = jQuery("#cache-star-htaccess").val();
			var data = {
				'action': 'cache_star_htaccess',
				'text' : text

			};

			jQuery.post(ajaxurl, data, function(response) {
				alert(response);
				if( response.trim() == 'success' ){
					
					location.reload();
				}else{
					jQuery(".alerts-container").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Failed to disable GZIP</div>');

				}
			});

		});


	});

	</script> <?php

}

//save htaccess file
add_action( 'wp_ajax_cache_star_htaccess', 'cache_star_htaccess' );
function cache_star_htaccess(){

	 
	$htaccess = get_home_path().".htaccess";
	if( !file_get_contents( $htaccess ) ){
		echo "failed";
	}else{
		$htaccessContent = file_get_contents($htaccess);
		$text = $_POST['text'];
	 	

	    $fp = fopen($htaccess, "w+");

	    if (flock($fp, LOCK_EX)) { // do an exclusive lock
	        fwrite($fp, $text);
	        flock($fp, LOCK_UN); // release the lock
	       echo "success";
	    } else {
	       echo "failed";
	    }
	}

	wp_die(); // this is required to terminate immediately and return a proper response*/

}	
//check if x-mod-pagespeed is present in website headers
function cache_star_headers() {
	
	$request = new WP_Http;
	$result = $request->request( 'https://wpgo.com.au' );

	if( $result['headers']['x-mod-pagespeed'] ){
		return true;
	}else{
		return false;
	}
	
	wp_die();

}


//purge cache
add_action( 'wp_ajax_cache_star_purge', 'cache_star_purge' );
function cache_star_purge() {
	$purge_url = get_home_url()."/*";
 	$ch = curl_init();
 	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PURGE');
    curl_setopt($ch, CURLOPT_URL, $purge_url);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
    curl_setopt($ch, CURLOPT_NOBODY  , true);  // we don't need body
    $response = curl_exec($ch);
   	echo $response;
	wp_die(); // this is required to terminate immediately and return a proper response

}


add_action( 'wp_ajax_cache_star_force_enable', 'cache_star_force_enable' );
function cache_star_force_enable( ) {
	
	 
	$htaccess = get_home_path().".htaccess";
	if( !file_get_contents( $htaccess ) || cache_star_is_enabled_force() == true){
		echo "failed";
	}else{
		$htaccessContent = file_get_contents($htaccess);
	
	 	$forceSSL = '# HTTPS force by Cache Star' . PHP_EOL;
	    $forceSSL .= '<IfModule mod_rewrite.c>' . PHP_EOL;
	    $forceSSL .= 'RewriteEngine On' . PHP_EOL;
	    $forceSSL .= 'RewriteCond %{HTTPS} off' . PHP_EOL;
	    $forceSSL .= 'RewriteRule ^(.*)$ https://%{SERVER_NAME}%{REQUEST_URI} [R=301,L]' . PHP_EOL;
	    $forceSSL .= '</IfModule>' . PHP_EOL;
	    $forceSSL .= '# END HTTPS';
	   
	    if (substr($htaccessContent, 0, 1) !== PHP_EOL) {
	        $htaccessNewContent = $forceSSL . PHP_EOL . $htaccessContent;
	    } else {
	        $htaccessNewContent = $forceSSL . $htaccessContent;
	    }

	    $fp = fopen($htaccess, "w+");

	    if (flock($fp, LOCK_EX)) { // do an exclusive lock
	        fwrite($fp, $htaccessNewContent);
	        flock($fp, LOCK_UN); // release the lock
	       echo "success";
	    } else {
	       echo "failed";
	    }
	}
	

	


	wp_die(); // this is required to terminate immediately and return a proper response*/
}


add_action( 'wp_ajax_cache_star_force_disable', 'cache_star_force_disable' );
function cache_star_force_disable() {
	
	 
	$htaccess = get_home_path().".htaccess";
	if( !file_get_contents( $htaccess ) || cache_star_is_enabled_force() == false){
		echo "failed";
	}else{
		$htaccessContent = file_get_contents($htaccess);

        $htaccessNewContent = preg_replace("/\#\s+HTTPS\s+force\s+by\s+Cache Star(.+?)\#\s+END\s+HTTPS/ims", '', $htaccessContent);

        if (substr($htaccessNewContent, 0, 1) === PHP_EOL) {
            $htaccessNewContent = substr($htaccessNewContent, 1);
           
        }

        $fp = fopen($htaccess, "w+");
        if (flock($fp, LOCK_EX)) { // do an exclusive lock
            fwrite($fp, $htaccessNewContent);
            flock($fp, LOCK_UN); // release the lock
            echo "success";
        } else {
            echo "failed";
        }
	}

	wp_die(); // this is required to terminate immediately and return a proper response*/
}


add_action( 'wp_ajax_cache_star_enable', 'cache_star_enable' );

function cache_star_enable() {
	$htaccess = get_home_path().".htaccess";
	$lines = array();
	$lines[] = "<IfModule pagespeed_module>
    ModPagespeed on
</IfModule>";
	/*$lines = '<IfModule pagespeed_module>' . PHP_EOL;
	$lines .= 'ModPagespeed on' . PHP_EOL;
	$lines .= '</IfModule>' . PHP_EOL;*/

	$insert = insert_with_markers( $htaccess, "Cache Star Pagespeed", $lines);
	if( $insert ){
		echo "success";
	}else{
		echo "failed";
	}
	wp_die(); // this is required to terminate immediately and return a proper response
}


add_action( 'wp_ajax_cache_star_gzip_enable', 'cache_star_gzip_enable' );

function cache_star_gzip_enable() {
	$htaccess = get_home_path().".htaccess";
	$htaccessContent = file_get_contents($htaccess);

	if( cache_star_is_enabled_gzip() == true){
		echo "failed";
	}else{
		/*$lines = array();
		$lines[] = "<IfModule mod_deflate.c>
		AddOutputFilterByType DEFLATE text/plain
		AddOutputFilterByType DEFLATE text/html
		AddOutputFilterByType DEFLATE text/xml
		AddOutputFilterByType DEFLATE text/css
		AddOutputFilterByType DEFLATE application/xml
		AddOutputFilterByType DEFLATE application/xhtml+xml
		AddOutputFilterByType DEFLATE application/rss+xml
		AddOutputFilterByType DEFLATE application/javascript
		AddOutputFilterByType DEFLATE application/x-javascript
		AddType x-font/otf .otf
		AddType x-font/ttf .ttf
		AddType x-font/eot .eot
		AddType x-font/woff .woff
		AddType image/x-icon .ico
		AddType image/png .png
	</IfModule>";
	$insert = insert_with_markers( $htaccess, "Cache Star GZIP", $lines);
	if( $insert ){
		echo "success";
	}else{
		echo "failed";
	}*/
		$lines = PHP_EOL;
		$lines .= '# BEGIN Cache Star GZIP' . PHP_EOL;
		$lines .= '<IfModule mod_deflate.c>' . PHP_EOL;
		$lines .= 'AddOutputFilterByType DEFLATE text/plain' . PHP_EOL;
		$lines .= 'AddOutputFilterByType DEFLATE text/html' . PHP_EOL;
		$lines .= 'AddOutputFilterByType DEFLATE text/xml' . PHP_EOL;
		$lines .= 'AddOutputFilterByType DEFLATE text/css' . PHP_EOL;
		$lines .= 'AddOutputFilterByType DEFLATE application/xml' . PHP_EOL;
		$lines .= 'AddOutputFilterByType DEFLATE application/xhtml+xml' . PHP_EOL;
		$lines .= 'AddOutputFilterByType DEFLATE application/rss+xml' . PHP_EOL;
		$lines .= 'AddOutputFilterByType DEFLATE application/javascript' . PHP_EOL;
		$lines .= 'AddOutputFilterByType DEFLATE application/x-javascript' . PHP_EOL;
		$lines .= 'AddType x-font/otf .otf' . PHP_EOL;
		$lines .= 'AddType x-font/ttf .ttf' . PHP_EOL;
		$lines .= 'AddType x-font/eot .eot' . PHP_EOL;
		$lines .= 'AddType x-font/woff .woff' . PHP_EOL;
		$lines .= 'AddType image/x-icon .ico' . PHP_EOL;
		$lines .= 'AddType image/png .png' . PHP_EOL;
		$lines .= '</IfModule>' . PHP_EOL;
		$lines .= '# END Cache Star GZIP';
		
		$count = strlen($htaccessContent);
		
	 	if (substr($htaccessContent, $count-1, 1) !== PHP_EOL) {
	        $htaccessNewContent = $htaccessContent . PHP_EOL . $lines;
	    } else {
	        $htaccessNewContent = $htaccessContent . $lines;
	    }

	    $fp = fopen($htaccess, "w+");

	    if (flock($fp, LOCK_EX)) { // do an exclusive lock
	        fwrite($fp, $htaccessNewContent);
	        flock($fp, LOCK_UN); // release the lock
	       echo "success";
	    } else {
	       echo "failed";
	    }
	}
	
	wp_die(); // this is required to terminate immediately and return a proper response
}

/*function check_pagespeed() {

    ob_start(); // Required due to PHPInfo output style
    phpinfo();
    $content = ob_get_contents();
    ob_end_clean(); 
    return strstr($content, "mod_pagespeed"); 
}*/

add_action( 'wp_ajax_cache_star_gzip_disable', 'cache_star_gzip_disable' );

function cache_star_gzip_disable() {
	$htaccess = get_home_path().".htaccess";
	if( !file_get_contents( $htaccess ) || cache_star_is_enabled_gzip() == false){
		echo "failed";
	}else{
		$htaccessContent = file_get_contents($htaccess);

        $htaccessNewContent = preg_replace("/\#\s+BEGIN\s+Cache\s+Star\s+GZIP(.+?)\#\s+END\s+Cache Star GZIP/ims", '', $htaccessContent);
       	$count = strlen($htaccessNewContent);

        if (substr($htaccessNewContent, $count-1, 1) === PHP_EOL) {
            $htaccessNewContent = substr($htaccessNewContent, 0, $count-1);
        }

        $fp = fopen($htaccess, "w+");
        if (flock($fp, LOCK_EX)) { // do an exclusive lock
            fwrite($fp, $htaccessNewContent);
            flock($fp, LOCK_UN); // release the lock
            echo "success";
        } else {
            echo "failed";
        }
	}

	wp_die(); // this is required to terminate immediately and return a proper response*/
}


add_action( 'wp_ajax_cache_star_disable', 'cache_star_disable' );



function cache_star_disable() {
$htaccess = get_home_path().".htaccess";
	if( !file_get_contents( $htaccess ) || cache_star_is_enabled_pagespeed() == false){
		echo "failed";
	}else{
		$htaccessContent = file_get_contents($htaccess);

		$lines = '# BEGIN Cache Star Pagespeed' . PHP_EOL;
		$lines .= '<IfModule pagespeed_module>' . PHP_EOL;
		$lines .= 'ModPagespeed off' . PHP_EOL;
		$lines .= '</IfModule>' . PHP_EOL;
		$lines .= '# END Cache Star Pagespeed';

        $htaccessNewContent = preg_replace("/\#\s+BEGIN\s+Cache\s+Star\s+Pagespeed(.+?)\#\s+END\s+Cache Star Pagespeed/ims",
         $lines, 
         $htaccessContent);

        if (substr($htaccessNewContent, 0, 1) === PHP_EOL) {
            $htaccessNewContent = substr($htaccessNewContent, 1);
        }

        $fp = fopen($htaccess, "w+");
        if (flock($fp, LOCK_EX)) { // do an exclusive lock
            fwrite($fp, $htaccessNewContent);
            flock($fp, LOCK_UN); // release the lock
            echo "success";
        } else {
            echo "failed";
        }
	}

	wp_die(); // this is required to terminate immediately and return a proper response*/

}



function cache_star_get_htaccess(){

	$htaccess = get_home_path().".htaccess";

	$content = file_get_contents($htaccess);

	return $content;

}



function cache_star_enqueue_style()

{   

	wp_enqueue_style( 'cache_star_bootstrap_style', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css' );

    wp_enqueue_style( 'cache_star_style', plugin_dir_url( __FILE__ ) . 'css/cachestar.css',array(), '4.9' );

    wp_enqueue_script( 'cache_star_bootstrap_script', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array(), '1.0' );

}

add_action('admin_enqueue_scripts', 'cache_star_enqueue_style');




/*  */
function cache_star_is_enabled_force()
{                
    $htaccess = get_home_path().".htaccess";
    if (!file_get_contents( $htaccess )) {
    	return false;
    }
    
    $htaccessContent = file_get_contents($htaccess);

    if (preg_match('/HTTPS force by Cache Star/s', $htaccessContent, $m)) {
        return true;
    }

    return false;
}

function cache_star_is_enabled_gzip()
{                
    $htaccess = get_home_path().".htaccess";
    if (!file_get_contents( $htaccess )) {
    	return false;
    }
    
    $htaccessContent = file_get_contents($htaccess);

    if (preg_match('/BEGIN Cache Star GZIP/s', $htaccessContent, $m)) {
        return true;
    }

    return false;
}

function cache_star_is_enabled_pagespeed()
{                
    $htaccess = get_home_path().".htaccess";
    if (!file_get_contents( $htaccess )) {
    	return false;
    }
    
    $htaccessContent = file_get_contents($htaccess);

    if (preg_match('/BEGIN Cache Star Pagespeed(.+)ModPagespeed on(.+)END Cache Star Pagespeed/s', $htaccessContent, $m)) {
        return true;
    }

    return false;
}




?>