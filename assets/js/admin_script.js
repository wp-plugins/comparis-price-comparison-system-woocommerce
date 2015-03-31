(function($){

	/*admin panel include map start*/
	

	$('#_uou_pc_meta_box_id_map_canvas').closest("table").addClass("google_map");
	jQuery(".google_map").parent().append('<div id="map_canvas" style="height: 450px; width: 100%">' );

	$('#_uou_pc_meta_box_id_status').hide();
	/*admin panel include map end*/

	$('#_cat_icon').iconpicker();

})(jQuery);