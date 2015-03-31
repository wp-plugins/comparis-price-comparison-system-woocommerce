;(function($) {

	var Res = {};

	$("#sort_price").hide();

	// filterign ajax call function
	function filter() {
		$( "#product-wrapper" ).empty();

		var fields = $( "form#product-search-fields" ).serializeArray();

		var start = $( ".range-slider .first-value").text();
		var end = $( ".range-slider .last-value").text();

		var posts_per_page = $(".posts_per_page").val();

		localStorage.setItem('posts_per_page', posts_per_page);

		$.ajax({
			type: "POST",				
			url: ajax_object.ajaxurl,
			dataType: "JSON",
			data: {
				'action' : 'uou_comparis_search', 
				'fields' : fields,
				'start'  : start,
				'end'    : end,
			},
			success: function(result){

				// Put the object into storage
				localStorage.setItem('response', JSON.stringify(result));
				
				var temp, len;
				var len  = result.length;

				if( len > 0 ) {

	    			var resultTemplate = _.template($("#product_box").html());
					var resultingHtml = resultTemplate({v : result});
					
					$("#product-wrapper").html(resultingHtml);
					$( ".pagination-wrapper" ).empty();
					$(".pagination-wrapper").customPaginate({
					
						itemsToPaginate : ".product-item",
						itemsPerPage : posts_per_page
						
					});

					$("#sort_price").show();

	            } 
	            else {
	            	var search_box_sorry = $("#product_box_sorry").html();
	            	$("#product-wrapper").html( _.template( search_box_sorry, v=result ));
	            }

			},
			async: false
		});

	}
	
	$('input.btn-search, input.btn-filter').on('click', function(e){
		
		e.preventDefault();

		filter();
		
	});

	$('form#product-search-fields').on('change', function(){

		filter();
		
	});

	$('input.search-fields').keyup(_.debounce(function(){

	    filter();
	    
	}, 300));

	if ($.fn.slider) {
		$('.compare-price-filter-widget .range-slider .slider').each(function () {
			var $this = $(this),
				min = $this.data('min'),
				max = $this.data('max');

			$this.slider({
				range: true,
				min: min,
				max: max,
				step: 1,
				values: [min, max],
				slide: function (event, ui) {
					$(this).parent().find('.first-value').text(ui.values[0]);
					$(this).parent().find('.last-value').text(ui.values[1]);
				},
				stop: function() {
					filter();
				}
			});
		});
	}

  $('select#sort_price').on('change',function(){
  	
  	var order = $(this).val();

  	var retrievedObject = localStorage.getItem('response');
	var data = JSON.parse(retrievedObject);

	var length, temps;
	var length  = data.length;

	if( length > 0 ) {

	  	if( order == 'asc') {
	  		data.sort(function(obj1, obj2) {
				// Ascending: first age less than the previous
				return obj1.price - obj2.price;
			});
	  	} 
	  	if( order == 'desc'){
	  		data.sort(function(obj1, obj2) {
				// Descending: first age less than the previous
				return obj2.price - obj1.price;
			});
	  	}

		var dataTemplate = _.template($("#product_box").html());
		var dataHtml = dataTemplate({v : data});
		
		$("#product-wrapper").html(dataHtml);
		$( ".pagination-wrapper" ).empty();
		$(".pagination-wrapper").customPaginate({
			itemsToPaginate : ".product-item",
			itemsPerPage : localStorage.getItem('posts_per_page')
			
		});
	}

  });

}(jQuery));
