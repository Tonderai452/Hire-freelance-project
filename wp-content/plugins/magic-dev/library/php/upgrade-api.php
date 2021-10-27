<?php
/**
 * Upgrade & Pro Activation API
 *
 * @author      Wilbertz
 * @category    Core
 * @version     1.2
*/

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

// Getting purchase code
function yp_setting_purchase_code(){

    if(defined("YP_THEME_MODE")){
        define("YP_PURCHASE_CODE","YELLOW_PENCIL_THEME_LICENSE"); // Extended theme mode
    }else{
        define("YP_PURCHASE_CODE",get_option('yp_purchase_code')); // personal user information
    }

}
add_action("admin_init","yp_setting_purchase_code");


// Basic update
function yp_install_plugin($plugin){

    // Getting file system
    WP_Filesystem();

    // plugin array; name, download uri, install path
    $plugin = $plugin[0];

    // Plugins path
    $path = ABSPATH.'wp-content/plugins/';

    // Zip file path
    $zip = $path.$plugin['name'].'.zip';

    // The plugin folder
    $install = $plugin['install'];

    // trying to download zip file
    $response = wp_remote_get( 
        $plugin['uri'], 
        array( 
            'timeout'  => 300, 
            'stream'   => true, 
            'filename' => $zip 
        ) 
    );

    // Unzip zip file
    unzip_file($zip,$path);

    // delete zip file
    wp_delete_file($zip);

    // Force active the plugin
    yp_plugin_activate($install);

    return true;

}

// Getting plugin download uri from Envato
function yp_get_download_uri_by_purchase(){

    // Checks download uri
    $download_uri = 'http://wilbertz.co.za/yellow-pencil/auto-update/download.php?purchase_code='.YP_PURCHASE_CODE;

    // Getting plugin download url
    $data = wp_remote_get($download_uri, array( 'sslverify' => false ));
    $data = wp_remote_retrieve_body( $data );

    if($data == ''){
        die('Unknown error');
    }
    
    // Data is the download URL
    return $data;

}


// Active new version.
function yp_plugin_activate($installer){

    $current = get_option('active_plugins');
    $plugin = plugin_basename(trim($installer));

    if(!in_array($plugin, $current)){
        $current[] = $plugin;
        sort($current);
        do_action('activate_plugin', trim($plugin));
        update_option('active_plugins', $current);
        do_action('activate_'.trim($plugin));
        do_action('activated_plugin', trim($plugin));
        return true;
    }else{
        return false;
    }

}

// Used for delete lite version when update to pro.
function yp_delete_all_directory($dir) {

    if (is_dir($dir)) {

        $objects = scandir($dir);

        foreach ($objects as $object) {

            if ($object != "." && $object != "..") {

                if (filetype($dir."/".$object) == "dir") {

                    yp_delete_all_directory($dir."/".$object); 

                }else{

                    wp_delete_file($dir."/".$object);

                }

            }

        }

        reset($objects);

        rmdir($dir);

    }

 }


// Begin to upgrade!
function yp_upgrade_now(){

    // Upgrade to Pro Version if is lite version.
    if(defined('WTFV') == false && current_user_can('delete_plugins') == true && current_user_can('install_plugins') == true){

        // Getting the path.
        $uri = yp_get_download_uri_by_purchase();

        // Update to PRO
        $re = yp_install_plugin(array(
            array('name' => 'yellow_pencil_update_pack', 'uri' => $uri, 'install' => 'magic-dev/yellow-pencil.php'),
        ));

        if(!$re){
            wp_die('Server doesn\'t support automatic upgrade. Please download Pro version from Codecanyon and install the plugin by manually.');
        }

        // Delete lite plugin
        delete_plugins(array('/yellow-pencil-visual-theme-customizer/yellow-pencil.php'));

        // Delete The Plugin Files.
        yp_delete_all_directory(ABSPATH . 'wp-content/plugins/yellow-pencil-visual-theme-customizer/');

    }

    wp_die("Magic Dev Activated");

}

// Ajax action.
add_action( 'wp_ajax_yp_upgrade_now', 'yp_upgrade_now' );


// Update javascript
function yp_update_javascript() { ?>
    <script type="text/javascript" >
    jQuery(document).ready(function($) {

        // Disable activation btn
        jQuery(".yp-product-activation").on("click",function(){
            jQuery(this).addClass("disabled");
        });


        // Trigger and send upgrade ajax if the current page is in upgrading.
        if(jQuery(".yp-upgrade-pro-action").length > 0){

            var data = {
                'action': 'yp_upgrade_now'
            };

            jQuery.post(ajaxurl,data, function(response) {

                // Resualt: Magic Dev Activated or error.
                jQuery(".yp-upgrade-pro-action").html(response);

                // Remove upgrade loading icon
                jQuery(".yp-upgrading-loading").remove();

                // remove .yp-upgrade-pro-action
                jQuery(".yp-upgrade-pro-action").removeClass("yp-upgrade-pro-action");

                // update desc
                jQuery(".yp-activation-section .description").html("Magic Dev Pro Successfully installed. <a href='<?php echo admin_url('admin.php?page=yp-welcome-screen'); ?>'>Let's Start</a>");

            });

        }

    });
    </script><?php
}

// Admin update script
add_action( 'admin_footer', 'yp_update_javascript' );