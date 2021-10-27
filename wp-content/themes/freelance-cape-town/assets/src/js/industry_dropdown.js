
jQuery(".dropdown dt a").on('click', function(e) {
	e.preventDefault();
  jQuery(".dropdown dd ul").slideToggle('fast');
e.preventDefault();
});

jQuery(".dropdown dd ul li a").on('click', function(e) {
	
  jQuery(".dropdown dd ul").hide();
});

function getSelectedValue(id) {
  return jQuery("#" + id).find("dt a span.value").html();
}

jQuery(document).bind('click', function(e) {
  var $clicked = jQuery(e.target);
  if (!$clicked.parents().hasClass("dropdown")) jQuery(".dropdown dd ul").hide();
});

jQuery('.mutliSelect input[type="checkbox"]').on('click', function() {

  var title = jQuery(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
    title = jQuery(this).val() + ",";
	 var a = [];
    var cboxes = jQuery('input[type="checkbox"]:checked');
	 var len = cboxes.length;	    
    jQuery('.dropdown  dt a p.multiSel').html(len + 'selected');
  if (jQuery(this).is(':checked')) {
    var html = '<span title="' + title + '">' + title + '</span>';
    //jQuery('.multiSel').append(html);
    //jQuery('.multiSel').val(len);
    
    jQuery(".hida").hide();
  } else {
    jQuery('span[title="' + title + '"]').remove();
    var ret = jQuery(".hida");
    jQuery('.dropdown dt a').append(ret);

  }
  
});
 
