jQuery( document ).ready( function( $ ) {
	'use strict';

	$( window ).load( function() {
		$( '.tm-svg' ).each( function() {
			var _file = $( this ).data( 'svg' );
			new Vivus( $( this )[0], {
				type    : 'oneByOne',
				file    : _file,
				duration: 150
			} );
		} );
	} );
} );
