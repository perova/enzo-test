jQuery( document ).ready( function( $ ) {
	'use strict';

	$( window ).load( function() {
		$( '.vc_row' ).each( function() {

			if ( $( this ).data( 'row-effect' ) == 'firefly' ) {

				var $_wrap = $( this ).children( '.firefly-wrapper' );
				var _color = $( this ).data( 'firefly-color' ) ? $( this ).data( 'firefly-color' ) : '#fff';
				console.log( _color );
				$.firefly( {
					color: _color,
					minPixel: 1,
					maxPixel: 3,
					total: 30,
					on: $_wrap,
					borderRadius: 50
				} );
			}
		} );
	} );
} );
