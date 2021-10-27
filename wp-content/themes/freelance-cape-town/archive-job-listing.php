<?php
/**
 * This core file should strictly be overwritten via your child theme.
 *
 * We strongly recommend to read Beans documentation to find out more how to
 * customize Beans theme.
 *
 * @author Beans
 * @link   http://www.getbeans.io
 */

beans_uikit_enqueue_components( array( 'autocomplete', 'form-file', 'progress', 'upload', 'notify' ), 'add-ons' );
beans_modify_action( 'beans_content_template', 'beans_main_append_markup', 'sd_view_content' );
beans_remove_action( 'beans_breadcrumb' );
beans_remove_attribute( 'beans_main', 'class', 'uk-block' );

// Temporarily remove comments for this page 
beans_remove_action('beans_comments_template');

beans_remove_markup('beans_post_meta_item_author');
add_filter('beans_post_meta_item_author_text_output', function( $in ){ return false; });

// Get logged in users profiles
$userProfileQuery = [
	'post_type' => 'freelancer',
	'author' => get_current_user_id(),
	'meta_query' => [
		[
			'key' => 'admin_approved_listing',
			'value' => 'yes'
		]
	]
];

$userProfiles = new WP_Query($userProfileQuery);
global $usersProfiles;
$usersProfiles = [];

if( $userProfiles->have_posts() ){
	while($userProfiles->have_posts()){ $userProfiles->the_post();
		$usersProfiles[get_the_ID()] = get_the_title();
	}
}

wp_reset_postdata();

// Get all industries and sub industries...
$industriesArgs = array (
	'type' => 'job-listing',
	'taxonomy' => 'industry',
	'orderby' => 'name',
	'order' => 'ASC',
	'hide_empty' => 1,
	// 'parent' => 0
);
global $industries;
$industries = get_categories( $industriesArgs );
// echo "Count is " . count($industries) . "<br>";
foreach( $industries as $k=>$industry ){
	$q = new WP_Query(
		[
			'post_type' => 'job-listing',
			'post_status' => 'publish',
			'tax_query' => [
				[
					'taxonomy' => 'industry',
					'field' => 'term_id',
					'terms' => $industry->term_id

				]
			]
		]
	);
	if( !$q->post_count > 0 ){
		unset($industries[$k]);
	}
}
// echo "Count is now " . count($industries)."<br>";
// End get all industries and sub industries ...



add_action( 'wp_footer', 'sd_modal_job_application', 30 );
function sd_modal_job_application(){
	?>
		<!-- This is the modal -->
		<div id="my-id" class="uk-modal">
		    <div class="uk-modal-dialog">
		        <a class="uk-modal-close uk-close"></a>
		        ...
		    </div>
		</div>
	<?php
}

function sd_view_content() {

?>

	<section class="section top-freelancers">

      <div class="uk-container uk-container-center">
        <div class="uk-grid">

			<span id="listings"></span>
          <div class="uk-width-1-1">
          	<h4 class="uk-text-bold uk-text-right">Want to add your own job listing?</h4>
          	
          	<a href="<?php echo esc_url( get_site_url() . '/registration-step-1?upload_brief=yes' ); ?>" class="uk-button uk-button-small uk-button-primary uk-float-right">Upload brief</a>
          </div>

          <div class="uk-clearfix">&nbsp;</div>
			
		  <div class="uk-width-1-1">
          <?php
          	if( have_posts() ){
          		echo '<table class="uk-table uk-table-striped">';
          	?>
				<thead>
					<tr style="background:#999;">
						<th colspan="3">
							<form class="uk-form uk-form-blank" method="GET" action="#listings">
							    <div class="uk-grid">
							        <div class="uk-width-medium-1-1">
							        	<select name="jobs_industry" id="jobs_industry" class="">
											<option value="-1">All Industries</option>
							        		<?php global $industries; foreach($industries as $industry): ?>
												<option value="<?php echo $industry->term_id; ?>"><?php echo ($industry->parent > 0 ? null : null) . $industry->name; ?></option>
											<?php endforeach; ?>
							        	</select>
										<input type="submit" value="Filter Jobs" class=" uk-button" style="background:#111;color:#fff;border-radius:5px;">
							        </div>
							        <!--<div class="uk-width-1-4">
							        	<select name="jobs_sub_industry" id="jobs_sub_industry" class="uk-width-1-1">
							        		<option value="-1">All Sub Industries</option>
							        		<option value="1">Web Development</option>
							        		<option value="2">Real Estate</option>
							        	</select>
							        </div>-->
							        <!--<div class="uk-width-medium-1-3">
							        	<select name="jobs_type" id="jobs_type" class="uk-width-1-1">
							        		<option value="-1">All Types</option>
							        		<option value="1">Contract Pay</option>
							        		<option value="2">Hourly Pay</option>
							        	</select>
							        </div>-->
							        <!--<div class="uk-width-medium-1-3">
							        	<input type="submit" value="Filter Jobs" class=" uk-button" style="background:#111;color:#fff;border-radius:5px;">
							        </div>-->
							    </div>
							</form>
						</th>
					</tr>
				</thead>
          	<?php
          		$type_of_work_map = [
          			'hourly' => 'Hourly Fee',
          			'project' => 'Project Fee',
          			'contract' => 'Contract Work'
          		];
          		$type_of_earnings = [
          			'hourly' => 'Hour',
          			'project' => 'Project Completed',
          			'contract' => 'Per Contract Honoured'
          		];
          		global $jobModals;
          		while( have_posts() ){ the_post();
          		$admin_approved = get_field( 'admin_approved_listing' );
          		if($admin_approved == 'yes'){
          			?>
						<tr>
							<!--<td class="uk-width-1-5 uk-text-center">
								<span class="uk-text-bold" style="display:inline-block;background:#ccc;color:#333;padding:5px 10px;width:80%;"><?php echo get_term_by( 'id', get_the_id(), 'industry' )->name; ?></span>
							</td>-->
							<td class="uk-width-3-5" style="padding:5px 15px;">
								<div class="uk-clearfix"></div>
								<h3><?php echo get_the_title(); ?></h3>
								<p>
									<span class="uk-badge">
										<?php echo $type_of_work_map[ get_field( 'type_of_work' ) ]; ?>
									</span>
									<?php if( get_field( 'price_from' ) ): ?>
										<span class="uk-badge">
											<?php echo 'R' . get_field( 'price_from' ) . ' - ' . ( get_field( 'price_to' ) ? 'R' . get_field( 'price_to' ) : '?' ) . ' / ' . ( $type_of_earnings[ get_field( 'type_of_work' ) ] ) ; ?>
										</span>
									<?php endif; ?>
								</p>
								<p><?php echo get_the_excerpt(); ?> <br><a style="text-decoration:underline;" href="#" data-uk-modal="{target:'#job-modal-<?php echo get_the_ID(); ?>'}" class="uk-text-small uk-text-danger">View Full Description</a></p>
								<p>&nbsp;</p>
								<p>
									<?php if( $industries = get_the_terms( get_the_ID(), 'industry' ) ): ?>
										<span class="uk-text-small uk-text-muted"><strong>Posted in:</strong> <?php $c = count($industries); $i = 0; foreach( $industries as $industry ) : $i++; ?><span class="uk-text-muted"><?php echo $industry->name; ?></span> <?php echo $i < $c ? ' | ' : NULL; endforeach; ?></span>
									<?php endif; ?>
								</p>
								<?php
									global $jobModals;
									global $more;
									$more = 1;
									$jobModals .= '
										<div id="job-modal-' . get_the_ID() . '" class="uk-modal">
										    <div class="uk-modal-dialog">
										        <a class="uk-modal-close uk-close"></a>
										        <div>
													<h2> ' . get_the_title() . '</h2>
													<span class="uk-badge">
														' . $type_of_work_map[ get_field( 'type_of_work' ) ] . '
													</span>
													' . ( get_field( 'price_from' ) ? '
														<span class="uk-badge">
															R ' . get_field( 'price_from' ) . ' - ' . ( get_field( 'price_to' ) ? 'R' . get_field( 'price_to' ) : '?' ) . ' / ' . ( $type_of_earnings[ get_field( 'type_of_work' ) ] ) . '
														</span>
													' : NULL ) . '
													<p>' . wpautop( get_the_content() ) . '</p>
										        </div>
										    </div>
										</div>
									';
								?>
								<div class="uk-clearfix">&nbsp;</div>
							</td>
							<td class="uk-width-1-5 uk-text-center" style="padding:5px 15px;">
								<?php $doc = false; if( $doc = get_field( 'job_brief_document' ) ) : ?>
									<a href="<?php echo $doc['url']; ?>" target="_blank" class="uk-button uk-button-small uk-button-primary uk-float-right" style="margin-left:5px;">
										View Brief
									</a>
								<?php endif; ?>
								<a href="#" id="triggerJobApplication" data-sd-job-name="<?php echo get_the_title(); ?>" data-sd-apply-for="<?php echo @openssl_encrypt(get_the_ID(), 'aes128', '$1m0n'); ?>" class="uk-button uk-button-small uk-button-danger uk-float-right">
									Apply Online
								</a>
							</td>
						</tr>
          			<?php
          		}
          	}
          		echo '
          			</table>
					</div>
          		';
          		/*$pagination = paginate_links();
          		if( ! empty( $pagination ) ){
          			echo '<div class="uk-width-1-1">';
	          			echo '<ul class="uk-pagination">';
	          				foreach( $pagination as $paged ){
	          					echo '<li>' . $paged . '</li>';
	          				}
	          			echo '</ul>';
          			echo '</div>';
          		}*/
          	}
          ?>

        </div>
      </div>
  </section>

<?php

}

add_action( 'wp_footer', function(){
	global $jobModals;
	echo $jobModals;
	?>
	<!-- Sign In Modal -->

		<script>
			jQuery(document).ready(function(){

				jobApplicationModal = UIkit.modal("#jobApplication");

				jQuery('#jobApplication').on({
					'show.uk.modal': function(e){

					},

					'hide.uk.modal': function(e){
						//console.log('hide');
					}
				});

				jQuery(document).on('click', '#triggerJobApplication', fn_buttonmodal_habndler);

				function fn_buttonmodal_habndler(e)
				{

					window.jobName = jQuery(e.currentTarget).data('sd-job-name');
					jQuery("#sdModalJobTitle").text(jQuery(e.currentTarget).data('sd-job-name'));
					jQuery("#sdModalJobApplyingFor").val(jQuery(e.currentTarget).data('sd-apply-for'));
					jobApplicationModal.show();

					e.returnValue = false;
					e.preventDefault();
					e.defaultPrevented;
					return false;

				}

				jQuery(document).on('submit', 'form#submitJobApplication', function(e){
					var ajaxurl = '<?php echo admin_url( 'admin-ajax.php', 'absolute' ); ?>';
                    /*console.log(jQuery(e.currentTarget).serialize());*/
					jQuery.ajax({
						url: ajaxurl,
                        data: jQuery(e.currentTarget).serialize() + '&action=sd_job_application',
						method: 'POST',
						dataType: 'json',
                        success: function( data ){
                            switch( data.success ){
								case true :
									UIkit.notify("<i class='uk-icon-check'></i> Your application was sent to the relevant parties.", {timeout: 5000, pos:'bottom-center', status:'success'});
									jobApplicationModal.hide();
									break;
								default :
									UIkit.notify("<i class='uk-icon-remove'></i> Your application failed to send.", {timeout: 0, pos:'bottom-center', status:'danger'})
									jobApplicationModal.hide();
									break;
							}
                        }
					});
					e.preventDefault();
					e.defaultPrevented;
					e.returnValue = false;
					return false;
				})

			});

			jQuery(function(){

				var progressbar = jQuery("#progressbar"),
					bar         = progressbar.find('.uk-progress-bar'),
					allFiles		= File,
					settings    = {

						action: '/', // upload url

						allow : '*.(jpg|jpeg|gif|png)', // allow only images

						loadstart: function() {
							bar.css("width", "0%").text("0%");
							progressbar.removeClass("uk-hidden");
						},

						progress: function(percent) {
							percent = Math.ceil(percent);
							bar.css("width", percent+"%").text(percent+"%");
						},

						allcomplete: function(response) {

							bar.css("width", "100%").text("100%");

							setTimeout(function(){
								progressbar.addClass("uk-hidden");
							}, 250);

							console.log(response)
						},

						single: false,

						params: {
							'job_listing_id' : 89,
							'applicant_id' : 23
						},
						notallowed: function(){
							UIkit.modal.alert("Only image files area allowed, thank you.");
						},
						before: function(settings, files){
							//allFiles[]
							console.log(files);
							drop.trigger('loadstart');
							return false;
						}
					};

				var select = UIkit.uploadSelect(jQuery("#upload-select"), settings),
					drop   = UIkit.uploadDrop(jQuery("#upload-drop"), settings);
			});
			
		</script>
		<!-- Application Dialogue -->
		<div class="uk-modal" id="jobApplication">
          <div class="uk-modal-dialog">
              <div class="uk-modal-header">
		        <h3 class="uk-modal-title">Job Application: <span id="sdModalJobTitle"></span></h3>
		      </div>
              <div>
                
                <!-- application form -->
				<form method="post" class="uk-form" id="submitJobApplication">
					<?php wp_nonce_field('sd_ajax', 'sd_nonce'); ?>
                    <fieldset>
						<?php global $usersProfiles; if( !empty($usersProfiles) ): ?>
							<!--<div class="uk-form-row">
								<label for="sd_apply_as" class="uk-form-label uk-text-bold">Apply As:</label>
								<select name="sd_apply_as" id="sdApplyAs" class="uk-form-control uk-width-1-1">
									<?php /*foreach( $usersProfiles as $usersProfileID=>$usersProfileName ): */?>
									<option value="<?php /*echo $usersProfileID; */?>"><?php /*echo $usersProfileName; */?></option>
									<?php /*endforeach; */?>
								</select>
							</div>-->
						<?php endif; ?>
						<div class="uk-form-row">
							<label for="job_posting_notes" class="uk-form-label uk-text-bold">Please motivate your application:</label>
							<textarea name="job_posting_notes" rows="10" id="sd_job_posting_notes" class="uk-form uk-width-1-1" placeholder="Your motivation here..."></textarea>
						</div>
						<!--<div class="uk-form-row">
							<div id="upload-drop" class="uk-placeholder uk-margin-remove">
								<i class="uk-icon-cloud-upload uk-icon-medium uk-text-muted uk-margin-small-right"></i> Attach (image) samples of your work by dropping them here or <a class="uk-form-file">selecting them<input id="upload-select" multiple type="file"></a>.
							</div>
							<div id="progressbar" class="uk-progress uk-progress-medium uk-hidden">
								<div class="uk-progress-bar" style="width: 0%;"></div>
							</div>
						</div>-->
						<div class="uk-form-row">
							<input id="submitJobApplication" type="submit" class="uk-button uk-button-large uk-button-primary" value="Submit Application">
						</div>
					</fieldset>
					<input type="hidden" name="sd_apply_for" id="sdModalJobApplyingFor" value="">
				</form>
                <!-- end application form -->

              </div>
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
		<!-- End Application Dialogue -->
	<?php
}, 30 );

beans_load_document();
