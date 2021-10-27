<?php
namespace SD\Freelance_Cape_Town\Ajax;
session_start();
function setup() {
	
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	add_action( 'wp_ajax_sd_contact_freelancer', $n('sd_contact_freelancer') );
	add_action( 'wp_ajax_nopriv_sd_contact_freelancer', $n('sd_contact_freelancer') );

	add_action( 'wp_ajax_sd_contact_fcpt', $n('sd_contact_fcpt') );
	add_action( 'wp_ajax_nopriv_sd_contact_fcpt', $n('sd_contact_fcpt') );

    add_action( 'wp_ajax_sd_job_application', $n('sd_job_application') );
    add_action( 'wp_ajax_nopriv_sd_job_application', $n('sd_job_application') );

	add_filter('wp_mail_content_type', $n('set_content_type') );
	function set_content_type(){
		return 'text/html';
	}
	
}

	/* CONTACT FREELANCER
	========================================================================================== */

	function sd_contact_freelancer() {
				
		$sd_logged_in_user = (int) $_REQUEST['sd_logged_in_user'];
		$sd_logged_in_user_email = (string) $_REQUEST['sd_logged_in_user_email'];
		$freelancer_email = (string) $_REQUEST['sd_freelancer_email'];
		$message = (string) $_REQUEST['sd_message'];

		$captcha_response = $_REQUEST['g-recaptcha-response'];

		if( !$captcha_response || $captcha_response == false || !wp_verify_nonce( $_REQUEST['wp_nonce'], 'sd_message_freelancer' ) ){
			echo json_encode( ['success' => 'n'] ); 
			die(); 
			return;
		}

		$gCaptchaResponse = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcZpxwTAAAAALkk9boqzIr_2NaPTq8rFkrmIpZc&response=".$captcha_response."&remoteip=".$_SERVER["REMOTE_ADDR"]), true);
		
		if( !$gCaptchaResponse['success'] == true ){
			echo json_encode( ['success' => 'n'] ); die(); return;
		}

		// Include Email Building Class
		include( dirname( dirname( __FILE__ ) ) . '/classes/SdMessageEmail.class.php'  );
		$mailBuilder = new \SdMessageEmail;
		$mailBuilder->body = "
			<h3 style=\"margin:0 0 5px 0;font-size:1.2em;\">You've Received a New Message Via Freelanca Cape Town:</h3>
			<p style=\"font-size:1.25em;\">
				" . nl2br( $message ) . "
			</p>
			<p>
				This message was sent on " . date('Y-m-d') . " at " . date("H:i:s") .". You may respond to the sender at <a href=\"mailto:$sd_logged_in_user_email\">$sd_logged_in_user_email</a>
			</p>
		";

		$send_email_to_freelancer = wp_mail(
			'simondowdles@gmail.com', //$freelancer_email
			'New Message Sent Via Freelance Cape Town',
			$mailBuilder->buildSource(),
			"Charset: utf-8\r\nMIME-Version: 1.0\r\nFrom:Freelance Cape Town <no-reply@freelance.capetown>\r\nReply-To: $sd_logged_in_user_email\r\n"
		);
		
		if( $send_email_to_freelancer ){
			echo json_encode( ['success' => 'y'] );
		}else{
			echo json_encode( ['success' => 'n'] );
		}
		 die(); return;
	}

	/* CONTACT FREELANCE CAPE TOWN
	========================================================================================== */

	function sd_contact_fcpt() {
				
		$name = (int) $_REQUEST['sd_name'];
		$email = (string) $_REQUEST['sd_email'];
		$message = (string) $_REQUEST['sd_message'];
		
		$captcha_response = $_REQUEST['g-recaptcha-response'];

		/*( !$captcha_response || $captcha_response == false || !wp_verify_nonce( $_REQUEST['wp_nonce'], 'sd_message_fcpt' ) ){
			echo json_encode( ['success' => 'n'] ); 
			die(); 
			return;
		}

		$gCaptchaResponse = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcZpxwTAAAAALkk9boqzIr_2NaPTq8rFkrmIpZc&response=".$captcha_response."&remoteip=".$_SERVER["REMOTE_ADDR"]), true);
		
		if( !$gCaptchaResponse['success'] == true ){
			echo json_encode( ['success' => 'n'] ); die(); return;
		}*/

		// Include Email Building Class
		include( dirname( dirname( __FILE__ ) ) . '/classes/SdMessageEmail.class.php'  );
		$mailBuilder = new \SdMessageEmail;
		$mailBuilder->body = "
			<h3 style=\"margin:0 0 5px 0;font-size:1.2em;\">You've Received a New Message Via Freelanca Cape Town Contact Form:</h3>
			<p style=\"font-size:1.25em;\">
				<strong>From: $name <$email></strong><br><br>
				" . nl2br( $message ) . "
			</p>
			<p>
				This message was sent on " . date('Y-m-d') . " at " . date("H:i:s") .". You may respond to the sender at <a href=\"mailto:$email\">$email</a>
			</p>
		";

		$send_email_to_freelancer = wp_mail(
			'simondowdles@gmail.com', //$freelancer_email
			'New Message Sent Via Freelance Cape Town',
			$mailBuilder->buildSource(),
			"Charset: utf-8\r\nMIME-Version: 1.0\r\nFrom:Freelance Cape Town <no-reply@freelance.capetown>\r\nReply-To: $email\r\n"
		);
		
		if( $send_email_to_freelancer ){
			echo json_encode( ['success' => 'y'] );
		}else{
			echo json_encode( ['success' => 'n'] );
		}
		 die(); return;
	}

	/* JOB APPLICATION
	========================================================================================== */

	function sd_job_application(){

		if( ! wp_verify_nonce( $_POST[ 'sd_nonce' ], 'sd_ajax' ) ){
            die();
        }

        $apply_as = wp_get_current_user()->ID;
        $apply_for = (int) @openssl_decrypt($_POST[ 'sd_apply_for' ], 'aes128', '$1m0n');
		$application_message = wp_strip_all_tags( $_POST[ 'job_posting_notes' ] );

        if ( empty( $apply_as ) || empty( $apply_for ) || ! is_int( $apply_as ) || ! is_int( $apply_for ) ) {
        	wp_send_json_error();
        }

        $original_post = get_post( $apply_for );
		$profile_owner = new \WP_User( $original_post->post_author );
		$profile_owner_email = $profile_owner->user_email;

		ob_start();
		include( get_stylesheet_directory() . '/includes/templates/email/job_application_message.php' );
		$message_template = ob_get_clean();

		include( get_stylesheet_directory() . '/includes/classes/SdMessageEmail.class.php' );
		$email = new \SdMessageEmail();
		$current_user = wp_get_current_user();
		$email->body = sprintf(
			$message_template,
			esc_html( $current_user->display_name ),
			esc_html( get_the_title( $apply_for ) ),
			nl2br( $application_message ),
			esc_html( $current_user->display_name ),
			esc_html( $current_user->user_email ),
			esc_html( date( 'Y-m-d H:i:s' ) )
		);

		$send = wp_mail(
			$profile_owner_email,
			"Freelance Cape Town - New Job Application From {$current_user->display_name}",
			$email->buildSource(),
			array(
				'Content-Type: text/html' . "\r\n",
				'MIME-Version: 1.0' . "\r\n",
				'Bcc: simondowdles@gmail.com' . "\r\n",
				'Bcc: info@freelancecpt.com' . "\r\n",
			)
		);

		if ( $send ) {
			wp_send_json_success();
		} else {
			wp_send_json_error();
		}

    }
