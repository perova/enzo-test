(
	function( $ ) {
		"use strict";
		var $body              = $( 'body' );
		var $container         = $( '#one-page-scroll' );
		var dots               = true;
		var insightInitOnePage = function() {
			$container.fullpage( {
				navigation           : dots,
				navigationPosition   : 'right',
				lazyLoading          : true,
				scrollBar            : false,
				css3                 : true,
				scrollingSpeed       : 900,
				scrollOverflow       : true,
				scrollOverflowOptions: {
					click: true
				},
				verticalCentered     : true,
				afterLoad            : function( anchorLink, index ) {
					var $currentRow = $container.children( '.active' );
					var skin        = $currentRow.attr( 'data-skin' );
					$body.attr( 'data-row-skin', skin );

					$currentRow.find( '.tm-animation' ).addClass( 'animate' );

					$container.find( '> div' ).css( {
						'will-change'       : 'auto',
						'-webkit-transform' : 'translate3d(0,0,0)',
						'-moz-transform'    : 'translate3d(0,0,0)',
						'-ms-transform'     : 'translate3d(0,0,0)',
						'-o-transform'      : 'translate3d(0,0,0)',
						'transform'         : 'translate3d(0,0,0)',
						'-webkit-transition': 'none',
						'-moz-transition'   : 'none',
						'-ms-transition'    : 'none',
						'-o-transition'     : 'none',
						'transition'        : 'none'
					} );
				}
			} );
		};

		if ( $container.length > 0 ) {
			$( document ).ready( function() {
				if ( $( '#wpadminbar' ).length > 0 ) {
					$( 'html' ).addClass( 'admin-bar-enabled' );
				}
				dots = $container.data( 'enable-dots' );
				insightInitOnePage();
			} );
		}
	}
)( jQuery );
