/*
	
	Ajax Example - JavaScript for public pages
	
*/
(function($) {
	
	$(document).ready(function() {
		
		// when user clicks the link
		$('.ajax-learn-more a').on( 'click', function(event) {
			
			// prevent default
			event.preventDefault();
			
			// add loading message
			$('.ajax-response').html('Loading...');
			
			// define url
			var author_id = $(this).data('id');
			
			// submit the data
			$.post(ajax_public.ajaxurl, {
				
				nonce:     ajax_public.nonce,
				action:    'public_hook',
				author_id: author_id
				
			}, function(data) {
				
				// log data
				console.log(data);
				
				// display data
				$('.ajax-response').html(data);
				
			});
			
		});
		
	});
	
})( jQuery );
