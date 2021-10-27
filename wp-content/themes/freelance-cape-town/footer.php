<?php
/**
 * This file content is situated in /lib/templates/structure/footer.php and should
 * strictly be overwritten via your child theme.
 *
 * We strongly recommend to read Beans documentation to find out more how to
 * customize Beans theme.
 *
 * @author Beans
 * @link   http://www.getbeans.io
 */

// Template situated in /lib/templates/structure/footer.php
?>

 <script>
               jQuery(document).ready(function(){
               jQuery("#subcatid").change(function(){
                      	//alert("Hello");	
                         var subcat = jQuery("#subcatid").val();
                         var sub_cat = subcat.split(',');
                       //  alert(sub_cat[1]);
                         var subcat_name = sub_cat[1]; 	
                           jQuery.ajax({
                    url: "<?php echo admin_url(); ?>admin-ajax.php",
                    type: 'POST',
                    data: {termid_find: subcat,  action: 'my_action_find'},
                 
                    success: function (data) {
                     jQuery('#sub_category').html(data);
                    }
               });
            });


    jQuery("#subcatid_find").change(function(){
                      	//alert("Hello");	
                         var subcat_find = jQuery("#subcatid_find").val();
                         var sub_cat_find = subcat_find.split(',');
                       //  alert(sub_cat[1]);
                         var subcat_name_find = sub_cat_find[1]; 	
                           jQuery.ajax({
                    url: "<?php echo admin_url(); ?>admin-ajax.php",
                    type: 'POST',
                    data: {termid_find: subcat_find,  action: 'my_action_find'},
                 
                    success: function (data) {
                     jQuery('#sub_category_find').html(data);
                    }
               });
            });

  /* jQuery('#email_free').on('keyup', function(){
              var email_free = jQuery("#email_free").val();
              jQuery.ajax({
                    url: "<?php echo admin_url(); ?>admin-ajax.php",
                    type: 'POST',
                    data: {email_free: email_free,  action: 'my_action_email'},
                 
                    success: function (data) {
                      var data_new = jQuery.trim(data);
                      //alert(data_new);
                      jQuery('#email_existfree').html(data_new);
                      if(data=="OK")
                      {
                        return true;
                      }
                      else{
                        return false;
                      }
                  }
            });         
            });
                  */
 }); 
				   //end step 2
</script>
<?php beans_load_default_template( __FILE__ );
?>
