/*
	
	REST API Example: Create Posts
	
*/
(function($) {
$(document).ready(function() {
	
	'use strict';
	
	$('.rest-create-post').on('submit', function(event) {
		
		event.preventDefault();
		
		var url     = rest_create_posts.root + 'wp/v2/posts';
		var nonce   = rest_create_posts.nonce;
		
		var title   = '.rest-create-post [name="title"]';
		var content = '.rest-create-post [name="content"]';
		var result  = '.rest-post-result';
		
		var data = {
			title:   $(title).val(),
			content: $(content).val(),
			status:  'draft'
		};
		
		$.ajax({
			method:   'POST',
			dataType: 'json',
			timeout:   5000,
			url:       url,
			data:      data,
			async:     true,
			
			beforeSend: function(xhr, settings) {
				
				// console.log(xhr, settings);
				
				$(result).html('Creating post...');
				
				xhr.setRequestHeader('X-WP-Nonce', nonce);
				
			},
			success: function(response, status, xhr) {
				
				console.log(response, status, xhr);
				
				$(result).fadeIn(300);
				$(result).html(rest_create_posts.success);
				$(result).fadeOut(3000);
				
				$(title).val('');
				$(content).val('');
				
			},
			error: function(xhr, status, error) {
				
				// console.log(xhr, status, error);
				
				$(result).fadeIn(300);
				$(result).html(rest_create_posts.failure);
				
			},
			complete: function(xhr, status) {
				
				// console.log(xhr, status);
				
			}
			
		});
		
	});
	
});
})( jQuery );