<?php
// Template Name: Contact Us
/**
 * This core file should strictly be overwritten via your child theme.
 *
 * We strongly recommend to read Beans documentation to find out more how to
 * customize Beans theme.
 *
 * @author Beans
 * @link   http://www.getbeans.io
 */

beans_uikit_enqueue_components( array( 'autocomplete' ), 'add-ons' );

beans_modify_action( 'beans_content_template', 'beans_main_append_markup', 'sd_view_content' );
beans_remove_action( 'beans_breadcrumb' );
beans_remove_attribute( 'beans_main', 'class', 'uk-block' );

// Temporarily remove comments for this page 
beans_remove_action('beans_comments_template');

beans_remove_markup('beans_post_meta_item_author');
add_filter('beans_post_meta_item_author_text_output', function( $in ){ return false; });

function sd_view_content() {

?>

	<section class="section contact-page">
      <div class="uk-container uk-container-center">
        <div class="uk-grid">
          <div class="uk-width-medium-1-1">
          <h3>Contact Us</h3>
          <p>Please fill in the contact form below and we’ll get back to you as soon as possible</p>
          </div>
        </div>

        <div class="uk-grid">
          <div class="uk-width-medium-2-3">
          <?php echo do_shortcode('[contact-form-7 id="1907" title="Contact us"]');?>
           <!-- <form class="uk-form uk-form-stacked" method="post" id="sd_message_fcpt">

                <div class="uk-form-row">
                  <label class="uk-form-label">Name &amp; Surname</label>
                  <div class="uk-form-controls">
                  <input type="text" id="sd_name" name="sd_name" class="uk-form-large uk-width-1-1" placeholder="Name & Surname">
                  <p style="display: none;" class="uk-form-help-block"></p>
                </div>

                </div>

                <div class="uk-form-row">
                  <label class="uk-form-label">Email Address</label>
                  <div class="uk-form-controls">
                  <input type="email" id="sd_email" name="sd_email" class="uk-width-1-1 uk-form-large" placeholder="you@domain.xyz">
                  <p style="display:none;" class="uk-form-help-block"></p>
                </div>
              </div>

                <div class="uk-form-row">
                  <label class="uk-form-label">Message</label>
                  <div class="uk-form-controls">
                  <textarea id="sd_message" type="email" rows="15" class="uk-width-1-1 uk-form-large" placeholder="Speak your mind, we love honesty ;)"></textarea>
                  <p style="display:none;" class="uk-form-help-block"></p>
                </div>
                </div>
              <br>
              <div class="uk-grid" data-uk-grid-match>

                  <div class="uk-width-1-2">
                    <script src='https://www.google.com/recaptcha/api.js'></script>
                    <div class="g-recaptcha" data-sitekey="6LcZpxwTAAAAAB3xgwObdLAwB71wvZ8TU_vmLtmc"></div>
                  </div>

                  <div class="uk-width-1-2 uk-text-right">
                    <img id="sd_message_loader" style="display:none;" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/ajax-preloader.gif" width="25" height="25" alt="..."> <span id="sd_message_response"></span>
                    <button class="uk-button uk-button-red">Submit</button>
                  </div>

              </div>
          </form>-->
          <br><br>
          </div>

          <div class="uk-width-medium-1-3">
            <h4>Contact Details</h4>
            <ul>
              <li><i class="fa fa-envelope-square">&nbsp;</i>&nbsp;<a href="mailto:info@freelancecapetown.com">info@freelancecapetown.com</a></li>
              <li><i class="fa fa-globe">&nbsp;</i>&nbsp;<a href="http://www.freelancecapetown.com">freelancecapetown.com</a></li>
              <li><i class="fa fa-facebook-square">&nbsp;</i>&nbsp;<a href="http://www.freelancecapetown.com">freelanceCT</a></li>
              <li><i class="fa fa-twitter-square">&nbsp;</i>&nbsp;<a href="http://www.freelancecapetown.com">freelanceCT</a></li>
            </ul>

            <div class="uk-width-1-2"id="gmaps"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6814.788078060123!2d18.4229596021125!3d-33.93104025345937!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1dcc677eb48288fb%3A0xa3753a6f5ede29e1!2sWembley+Square+Offices!5e0!3m2!1sen!2sin!4v1491282080166" width="400" height="378" frameborder="0" style="border:0" allowfullscreen></iframe></div>

        </div>
      </div>
    </section>

<?php
$to = $_REQUEST[sd_email];
$subject = 'The subject';
$body = 'The email body content';
$headers = array('Content-Type: text/html; charset=UTF-8','From: My Site Name <support@example.com');
 
wp_mail( $to, $subject, $body, $headers );

}

add_action( 'wp_footer', 'sd_inject_ajax_logic', 30 );
function sd_inject_ajax_logic(){
  ?>
 
  <script>
    jQuery(document).ready(function(){
    
      jQuery(document).on('submit', 'form#sd_message_fcpt', function(e){
      	
        jQuery('img#sd_message_loader').attr('style','');
        jQuery('span#sd_message_response').html('');
        // Send message to ajax action
        jQuery.ajax({
          url: '<?php echo admin_url(); ?>admin-ajax.php',
          data: { 
            action : 'sd_contact_fcpt',
            sd_name : jQuery('#sd_name').val(),
            sd_email : jQuery('#sd_email').val(),
            sd_message : jQuery('#sd_message').val(),
            "g-recaptcha-response" : grecaptcha.getResponse(),
            wp_nonce : '<?php echo wp_create_nonce( 'sd_message_fcpt' ); ?>'
          },
         
          method: 'POST',
          dataType: 'text',
          success : function( r ){
            // r.success
            if( r.success !== 'y' ){
              // Replace spinner with error message
              jQuery('span#sd_message_response').html("<i class=\"uk-icon uk-icon-close uk-text-danger\"></i> Error sending message... &nbsp;");
            }else{
              if( r.success == 'y' ){
                // Replace spinner with success message
                jQuery('span#sd_message_response').html("<i class=\"uk-icon uk-icon-check uk-text-success\"></i> Message sent, thank you! &nbsp;");
              }
            }
            jQuery('img#sd_message_loader').attr('style','display:block;');
          }

        });
        return false;
        e.returnValue = false;
        e.preventDefault;
      });
    });
  </script>
  <?php
}

beans_load_document();
