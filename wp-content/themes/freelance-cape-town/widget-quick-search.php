<?php
	add_action( 'wp_footer', function(){
	?>
		<script>
			jQuery(document).ready(function(){
				var autocomplete = jQuery.UIkit.autocomplete(jQuery('#fcptAutoComplete'), {

				    'source': function(release) {

				        var data = [];

				        // fill the data array e.g. via ajax

				        jQuery.getJSON('/wp-json/fcpt-api/v1/all-industries/' + this.input.val(), function(data) {
				            if (data) {
				                release(data);
				            } else {
				                release([]);
				            }
				        });
				    }
				});
				autocomplete.on('selectitem.uk.autocomplete', function( event, data, acobject ){
					window.location = "<?php echo site_url(); ?>/freelancers/industry/" + data.value.split(' ').join('-');
				});
			});
		</script>
	<?php
}, 30 );
?>
<!-- Quick Search -->
<section class="section quick-search" style="background:#128ac6;color:#fff;">
  <div class="uk-container uk-container-center">
    <div class="uk-width-1-1 uk-text-center">

      <h3 style="color:#fff;">Find Talent Quick</h3>
      <p class="section-lead">Choose an industry you’re interested in to get started</p>
      <form class="uk-form">
        <fieldset data-uk-margin>

          <div class="uk-autocomplete uk-width-medium-1-1" id="fcptAutoComplete" data-uk-autocomplete>
          	<input type="text" style="width:100%;font-size:1.5em;" class="uk-form-large uk-text-center" placeholder="Type in Your Industry to Begin">
          </div>
          <!--<button class="uk-button uk-button-red uk-form-button-red">Search&nbsp;&nbsp;<i class="fa fa-search"></i></button>-->

        </fieldset>

    </form>
    </div>
  </div>
</section>
<!-- End Quick Search -->
