<!-- Hero Page Home -->
<?php wc_print_notices(); ?>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/js/jquery-1.12.4.js">
</script>

<section class="hero uk-cover-background">
  <div class="overlay" style="z-index:2;"></div>
    <div class="hero-content">
      <div class="uk-container uk-container-center">
        <div class="uk-grid" data-uk-grid-match>
          <div class="uk-width-medium-3-10 uk-text-left" style="height:420px !important;">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/fct-logon.png">
          </div>
          <div class="uk-width-medium-7-10" style="height:420px !important;text-align: center;">
            <!--<h1>Freelance Cape Town is where the city’s creative talent connect and showcase their work.</h1>-->
           
           <!-- <p class="lead">Why not join them?</p>-->
           
          <!-- searching start -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php $args = array(
    'type'                     => 'freelancer',
    'orderby'                  => 'name',
    'order'                    => 'ASC',
    'taxonomy'                 => 'industry',
    'pad_counts'               => false 

    ); 
$categories = get_categories( $args );
$allind= array();
foreach ( $categories as $cat ) {
$allind[] = "'".$cat->name."'";

}

$group_ind[] =implode(",", $allind);

 ?>
 
 <style>
 

h1#smaller{
	font-size: 31px;
}
 </style>

  <script>
  $( function() {
    var availableTags = [ <?php echo $group_ind[0]; ?>];
    $( "#search_indstry" ).autocomplete({
    	minLength:1, 
      source: availableTags
    });
  } );
  </script>
	<section class="section quick-search" style="background:none; padding-top:0px;">
	  <div class="uk-container uk-container-center" style="padding:0;">
	    <div class="uk-width-1-1" style="text-align:left;">
			<h1 style="color:#fff;">Proudly Cape Town’s #1 outsource platform</h1>
	      <h1 id="smaller" style="color:#fff;">Need a freelancer?</h1>
	      <span class="section-lead">Use our search engine with ease</span>
	      <form class="uk-form" action="<?php echo site_url(); ?>/freelancer_industries/">
	        <fieldset data-uk-margin>

	          <div class="uk-autocomplete uk-width-medium-1-5" style="width: 100%; min-height: 60px;">
	            <input type="text" style="width: 100%; min-height:60px; font-size:14px;" name="search_ind" class="uk-form-large" id ="search_indstry" placeholder="What service are you looking for">
	          </div>
	            <button class="uk-button uk-button-red uk-form-button-red search_btn">Search&nbsp;&nbsp;<i class="fa fa-search"></i></button>

	        </fieldset>

	    </form>
	    </div>
	    
	  </div>
	</section>
	<!-- End Quick Search -->
          </div>
           <span class="search_below">Proudly Cape Town’s #1 outsource platform</span>
        </div>
       
      </div>
</div>
</section>
<!-- End Hero Page Home -->
