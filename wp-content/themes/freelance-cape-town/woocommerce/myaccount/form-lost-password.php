<?php
/**
 * Lost password form
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action('wp_footer', function(){
	?>
		<style type="text/css">
			h1.uk-article-title{ font-size:1.75em !important;  }
		</style>
	<?php
},30);

?>

<?php wc_print_notices(); ?>

<div class="uk-panel">

<form method="post" class="lost_reset_password form uk-form">

	<?php if( 'lost_password' == $args['form'] ) : ?>

		<p style="font-size:1.1em;"><?php echo apply_filters( 'woocommerce_lost_password_message', __( 'Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p>
		
		<p class="form-row form-row-first uk-form-row">
			<!--<label for="user_login"><?php _e( 'Username or email', 'woocommerce' ); ?></label>-->
			<input class="input-text form-control uk-form-large" type="text" name="user_login" id="user_login" />
		</p>

	<?php else : ?>

		<p><?php echo apply_filters( 'woocommerce_reset_password_message', __( 'Enter a new password below.', 'woocommerce') ); ?></p>

		<p class="form-row form-row-first uk-form-row">
			<label for="password_1"><?php _e( 'New password', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="password" class="input-text form-control uk-form-large" name="password_1" id="password_1" />
		</p>
		<p class="form-row form-row-last uk-form-row">
			<label for="password_2"><?php _e( 'Re-enter new password', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="password" class="input-text form-control uk-form-large" name="password_2" id="password_2" />
		</p>

		<input type="hidden" name="reset_key" value="<?php echo isset( $args['key'] ) ? $args['key'] : ''; ?>" />
		<input type="hidden" name="reset_login" value="<?php echo isset( $args['login'] ) ? $args['login'] : ''; ?>" />

	<?php endif; ?>


	<div class="clear"></div>

	<?php do_action( 'woocommerce_lostpassword_form' ); ?>

	<p class="form-row">
		<input type="hidden" name="wc_reset_password" value="true" />
		<input type="submit" class="btn btn-md btn-default uk-button uk-button-large uk-button-blue" value="<?php echo 'lost_password' == $args['form'] ? __( 'Reset Password', 'woocommerce' ) : __( 'Save', 'woocommerce' ); ?>" />
	</p>

	<div class="uk-clearfix">&nbsp;</div>

	<?php wp_nonce_field( $args['form'] ); ?>

</form>

</div>
