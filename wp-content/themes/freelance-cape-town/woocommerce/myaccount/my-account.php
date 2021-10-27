<?php
beans_uikit_enqueue_components( array( 'progres' ), 'add-ons' );
/**
 * My Account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
wc_print_notices(); ?>

<p class="myaccount_user uk-text-muted" style="font-size:1.1em;margin:0;">
	<?php
	printf(
		__( 'Hello <strong>%1$s</strong> (not %1$s? <a href="%2$s" class="uk-text-danger">Sign out</a>).', 'woocommerce' ) . ' ',
		$current_user->display_name,
		wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) )
	);

	/*echo '</p><p class="myaccount_user" style="font-size:.9em;">';

	printf( __( 'From your account dashboard you can view your recent orders, manage your shipping and billing addresses and <a href="%s">edit your password and account details</a>. You can also purchase premium listing space in our Online Listing Catalogue.', 'woocommerce' ),
		wc_customer_edit_account_url()
	);*/
	?>
</p>

<div class="clearfix">&nbsp;</div>
<hr style="margin:10px 0;padding:0;border:none;border-bottom:1px dotted #ccc;">

	<!--<h4 class="sdWooHeading">Order Premium Listing Space or Buy The 2016 Guide</h4>
	<div class="clearfix">&nbsp;</div>
	<?php echo do_shortcode('[products skus="premium_listing_one_year, buyers_guide"]'); ?>-->
		
	<p>
		<div class="uk-grid" data-uk-grid-match="{target:'.uk-panel'}">
			<div class="uk-width-medium-2-3">
				<div class="uk-panel uk-panel-box uk-panel-box-primary">
					<span class="uk-text-bold">IMPORTANT NOTICE:</span>
					<br>Once your listing has gone through the checkout and approval process, you will be able to build your listing, make any edits and add info.
				</div>
			</div>
			<div class="uk-width-medium-1-3">
				<div class="uk-panel uk-panel-box uk-panel-box-success">
					<a class="uk-button uk-button-large uk-button-success uk-width-1-1" href="<?php echo site_url(); ?>/shop/">Purchase Listings Online</a>
				</div>
			</div>
		</div>
	</p>

	<br><h3 class="uk-text-bold">Your Purchased Listings:</h3><br>

	<!--<p style="font-size:1.2em;">
		To edit your listing(s), click on the pencil icon to the right of each listing. Your listings will only be made live once a member of our team has confirmed payment. Listings are usually made live within 24 hours. <br>
		If you would like to purchase additional listings, please use the button below:<br><br>
		
	</p>-->
	
	<?php
		$post_type_map = [
			'freelancer' => 'Freelancer Listing',
			'co-working-space' => 'Co-Working Space Listing',
			'job-listing' => 'Job Listing',
		];
		$post_type_edit_link_map = [
			'freelancer' => 'manage-freelance-listing',
			'co-working-space' => 'manage-co-working-space-listing',
			'job-listing' => 'manage-job-listing',
		];
		global $current_user;
		//print_r($current_user->data->ID);
		$args = array(
			'post_type' => array( 'freelancer', 'co-working-space', 'job-listing' ),
			'post_status' => array( 'pending', 'draft', 'future', 'publish' ),
			//'author' => $current_user->data->ID,
			'posts_per_page' => '999',
			'meta_key' => 'fcpt_owned_by',
			'meta_value' => $current_user->data->ID,
			'meta_compare' => '='
		);
		$mylistings = new WP_Query($args);
		if( $mylistings->have_posts() ){
			echo '<table class="uk-table uk-table-striped uk-table-condesned" id="sdMyAccountListingOrders">';
			while( $mylistings->have_posts() ){ $mylistings->the_post();
				global $post;
				$progressArray = [];
				$progressArray['industries'] = implode(",",(array) @get_field('industries', $post->ID));
				$progressArray['skills'] = (string) implode(",",(array) @get_field('skills', $post->ID)[0]);
				$progressArray['tagline'] = (string) @get_field('tagline', $post->ID);
				$progressArray['mobile_number'] = (string) @get_field('mobile_number', $post->ID);
				$progressArray['tel_number'] = (string) @get_field('tel_number', $post->ID);
				$progressArray['email_address'] = (string) @get_field('email_address', $post->ID);
				$progressArray['website_url'] = (string) @get_field('website_url', $post->ID);
				$progressArray['facebook_url'] = (string) @get_field('facebook_url', $post->ID);
				$progressArray['tiwtter_url'] = (string) @get_field('tiwtter_url', $post->ID);
				$progressArray['linkedin_url'] = (string) @get_field('linkedin_url', $post->ID);
				$progressArray['behance_url'] = (string) @get_field('behance_url', $post->ID);
				$progressArray['profile_image'] = (string) @get_field('profile_image', $post->ID)['url'];
				$progressArray['portfolio_collection'] = (string) @get_field('portfolio_collection', $post->ID)[0]['portfolio_item_image']['url'];

				$progress = 0;

				global $p;
				$p = 0;

				array_walk($progressArray, function($v){
					global $p;
					if( (string) $v > "" ){
						$p++;
					}
				});

				$progress = ceil( ($p/(count($progressArray))*100) );

				/*$statusArray = array(
					'freelancer' => '<span class="text-danger">[ Awaiting Approval ]</span>',
					'listing' => '<span class="text-success">[ Approved ]</span>',
				);*/
				echo '<tr>';
					echo '<td><span class="uk-text-bold" style="font-size:1.25em;">' . get_the_title() . '</span><br><span class="uk-text-small uk-text-muted">' . ( $post_type_map[ $post->post_type ] ) . ': </span> <span class="uk-text-danger uk-text-small" style="font-size:.75em;">Expires '. get_field( 'expiry_date' ) .'</span> </td>';
					echo '<td>' . ( '<a style="margin-left:5px;background:#2980b9;" href="'.get_permalink( get_the_ID() ).'" class="uk-button uk-button uk-float-right uk-button-primary"><i class="fa fa-eye"></i> Preview</a><a title="Edit Listing" href="'.add_query_arg( array('fid' => get_the_id() ), site_url().'/'.$post_type_edit_link_map[ $post->post_type ] ).'" class="uk-button uk-button uk-button-primary uk-float-right"><i class="fa fa-pencil"></i> Edit</a></td>' ); //<span class="uk-float-right sdExpires uk-text-muted">Expires ' . date( 'Y-m-d', strtotime( get_the_date() . " + 1 year" ) ) . '</span>' ) . '
				echo '</tr>';
				echo '
				<tr style="height:4px;">
					<td colspan="2" style="padding:0;">
						<div class="uk-progress" style="background:#dedede;">
							<div class="uk-progress-bar" style="width:' . $progress . '%;background:#00a8e6;padding:1px 2px;height:4px;">
								<div style="overflow:hidden;clear:both;padding:1px;font-size:.6em;"></div>
							</div>
						</div>
					</td>
				</tr>
				<tr style="background:#fff;">
					<td colspan="2" style="font-size:1.35em;color:#ccc;padding:0;">
						<span class="uk-badge" style="background:#00a8e6;color:#fff;padding:2px 8px 4px 8px;margin-top:-5px;">' . $progress . '% Complete</span>
					</td>
				</tr>';

				echo '
				<tr style="background: none;"> 
					<td colspan="2">&nbsp;</td>
				</tr>
				';

			}
			echo '</table>';
		}else{
			echo '<table class="uk-table uk-table-striped uk-table-condesned" id="sdMyAccountListingOrders">';
				echo '<tr class="list-group-item"><td colspan="2">You have not purchased any listings yet. </td></tr>';
			echo '</table>';
		}
	?>

<?php do_action( 'woocommerce_before_my_account' ); ?>
<div class="clearfix">&nbsp;</div>
<hr style="margin:10px 0;padding:0;border:none;border-bottom:1px dotted #ccc;">
<div class="clearfix">&nbsp;</div>
<?php wc_get_template( 'myaccount/my-downloads.php' ); ?>
<?php wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>
<?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php do_action( 'woocommerce_after_my_account' ); ?>
