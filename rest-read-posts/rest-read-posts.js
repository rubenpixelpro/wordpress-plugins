/*
	
	REST API Example: Display Posts
	
*/

var button    = document.getElementById( 'rest-button' );
var container = document.getElementById( 'rest-container' );

if ( button ) {
	
	button.addEventListener( 'click', function() {
		
		var request = new XMLHttpRequest();
		
		var query = 'wp/v2/posts';
		
		request.open( 'GET', rest_read_posts.root + query );
		
		request.onload = function() {
			
			if ( request.status >= 200 && request.status < 400 ) {
				
				var data = JSON.parse( request.responseText );
				
				displayContent( data );
				
				button.remove();
				
			} else {
				
				console.log( 'Status: ' + request.status );
				
			}
			
		};
		
		request.onerror = function() {
			
			console.log( 'Connection error.' );
			
		};
		
		request.send();
		
	});
	
}

function displayContent( data ) {
	
	var output = '';
	
	for ( i = 0; i < data.length; i++ ) {
		
		var title   = data[i].title.rendered;
		var excerpt = data[i].excerpt.rendered;
		var url     = data[i].link;
		
		output += '<h2>' + title + '</h2>' + excerpt;
		
		output += '<p><a target="_blank" href="' + url + '">';
		
		output += 'Leer más</a></p>';
		
	}
	
	container.innerHTML = output;
	
}
