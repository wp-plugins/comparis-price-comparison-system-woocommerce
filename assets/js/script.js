;(function($) {

"use strict";

	$('body').on('added_to_cart', function(event, data) {

		$('.fa-spin').hide();

        $('.added_to_cart').addClass('btn btn-default').show( function(){
        	$(this).prev('.add_to_cart_button').hide();
        });
    });

    $('body').on('adding_to_cart', function(e, button) {
    	e.preventDefault();
        $(button).append().html('<i class="fa fa-refresh fa-spin" style="width: 77px"></i>');
    });

}(jQuery));