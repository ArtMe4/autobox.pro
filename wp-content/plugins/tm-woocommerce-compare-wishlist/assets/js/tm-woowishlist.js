( function( $ ) {

	'use strict';

	$( document ).ready( function() {

		var tmWooLoadingClass = 'loading',
			tmWooAddedClass   = 'added in_wishlist',
			buttonSelector    = 'button.tm-woowishlist-button';

        $( document ).on( 'tm_woowishlist_update_fragments', updateFragments );

		function productButtonsInit() {

			$( document ).on( 'click', buttonSelector, function ( event ) {

				var button = $( this );

				event.preventDefault();

				// if( button.hasClass( 'in_wishlist' ) ) {
                //
				// 	return;
				// }

				var url  = tmWoowishlist.ajaxurl,
					data = {
						action: 'tm_woowishlist_add',
						pid:    button.data( 'id' ),
						nonce:  button.data( 'nonce' ),
						single: button.hasClass( 'tm-woowishlist-button-single' )
					};

				button
					.removeClass( tmWooAddedClass )
					.addClass( tmWooLoadingClass );

				$.post(
					url,
					data,
					function( response ) {

						button.removeClass( tmWooLoadingClass );

						if( response.success ) {

						    // console.log()

                            // switch ( response.data.action ) {
                            //
                            //     case 'add':
                            //
                            //         $( buttonSelector + '[data-id=' + data.id + ']' )
                            //             .addClass( tmWooAddedClass )
                            //             .find( '.text' )
                            //             .text( tmWoowishlist.removeText );
                            //
                            //         if( response.data.wishlistPageBtn ) {
                            //
                            //             button.after( response.data.wishlistPageBtn );
                            //         }
                            //         break;
                            //
                            //     case 'remove':
                            //
                            //         $( buttonSelector + '[data-id=' + data.id + ']' )
                            //             .removeClass( tmWooAddedClass )
                            //             .find( '.text' )
                            //             .text( tmWoowishlist.wishlistText );
                            //
                            //         $( '.tm-woowishlist-page-button' ).remove();
                            //
                            //         break;
                            //
                            //     default:
                            //
                            //         break;
                            // }

						    button
								.addClass( tmWooAddedClass )
								.find( '.text' )
								.text( tmWoowishlist.addedText );

							if( response.data.wishlistPageBtn ) {

								button.after( response.data.wishlistPageBtn );
							}
							var data = {
								action: 'tm_woowishlist_update'
							};
							tmWoowishlistAjax( null, data );
						}

                        if ( undefined !== response.data.counts ) {
                            $( document ).trigger( 'tm_woowishlist_update_fragments', { response: response.data.counts } );
                        }
					}
				);
			} );
		}

		function tmWoowishlistAjax( event, data ) {

			if( event ) {
				event.preventDefault();
			}

			var url           = tmWoowishlist.ajaxurl,
				widgetWrapper = $( 'div.tm-woocomerce-wishlist-widget-wrapper' ),
				wishList      = $( 'div.tm-woowishlist' );

			data.isWishlistPage = !!wishList.length;
			data.isWidget       = !!widgetWrapper.length;

			if ( 'tm_woowishlist_update' === data.action && !data.isWishlistPage && !data.isWidget ) {
				return;
			}
			if( data.isWishlistPage ) {

				data.wishListData = JSON.stringify( wishList.data() );
			}
			wishList.addClass( tmWooLoadingClass );

			widgetWrapper.addClass( tmWooLoadingClass );

			$.post(
				url,
				data,
				function( response ) {

					wishList.removeClass( tmWooLoadingClass );

					widgetWrapper.removeClass( tmWooLoadingClass );

					if( response.success ) {

						if( data.isWishlistPage ) {

							$( 'div.tm-woowishlist-wrapper' ).html( response.data.wishList );
                            // $( document ).trigger( 'enhance.tablesaw' );
						}
                        if( data.isWidget ) {

                            widgetWrapper.html( response.data.widget );
                        }
                        if ( 'tm_woowishlist_empty' === data.action ) {

                            $( buttonSelector )
                                .removeClass( tmWooAddedClass )
                                .find( '.text' )
                                .text( tmWoowishlist.wishlistText );

                            $( '.tm-woowishlist-page-button' ).remove();
                        }
                        if ( 'tm_woowishlist_remove' === data.action ) {

                            $( buttonSelector + '[data-id=' + data.pid + ']' ).removeClass( tmWooAddedClass ).find( '.text' ).text( tmWoowishlist.wishlistText );

                            $( buttonSelector + '[data-id=' + data.pid + ']' ).next( '.tm-woowishlist-page-button' ).remove();

                            // $( buttonSelector + '[data-id=' + data.pid + ']' )
                            //     .removeClass( tmWooAddedClass )
                            //     .find( '.text' )
                            //     .text( tmWoowishlist.wishlistText );
                            //
                            // $( '.tm-woowishlist-page-button' ).remove();
                        }
					}
                    if ( undefined !== response.data.counts ) {
                        $( document ).trigger( 'tm_woowishlist_update_fragments', { response: response.data.counts } );
                    }

					widgetButtonsInit();
				}
			);
		}

		function tmWoowishlistRemove( event ) {

			console.log(event);

			var button = $( event.currentTarget ),
				data   = {
					action: 'tm_woowishlist_remove',
					pid:    button.data( 'id' ),
					nonce:  button.data( 'nonce' )
				};

			tmWoowishlistAjax( event, data );
		}

        function tmWoowishlistEmpty( event ) {

            var data = {
                action: 'tm_woowishlist_empty'
            };

            tmWoowishlistAjax( event, data );
        }

		function widgetButtonsInit() {

			$( '.tm-woowishlist-remove' )
				.off( 'click' )
				.on( 'click', function ( event ) {
					tmWoowishlistRemove( event );
				} );

            $( '.tm-woowishlist-empty' )
                .off( 'click' )
                .on( 'click', function( event ) {
                    tmWoowishlistEmpty( event );
                } );
		}

        function getRefreshedFragments() {

            $.ajax({
                url: tmWoowishlist.ajaxurl,
                type: 'get',
                dataType: 'json',
                data: {
                    action: 'tm_woowishlist_get_fragments'
                }
            }).done( function( response ) {

                $( document ).trigger( 'tm_woowishlist_update_fragments', { response: response.data } );

            });

        }

        function updateFragments( event, data ) {

            if ( ! $.isEmptyObject( data.response.defaultFragments ) ) {
                $.each( data.response.defaultFragments, function( key, val ) {
                    var $item  = $( key ),
                        $count = $( '.wishlist-count', $item );
                    if ( 0 === $count.length ) {
                        $item.append( tmWoowishlist.countFormat.replace( '%count%', val ) );
                    } else {
                        $item.find( '.wishlist-count' ).html( val );
                    }
                } );
            }

            if ( ! $.isEmptyObject( data.response.customFragments ) ) {
                $.each( data.response.customFragments, function( key, val ) {
                    var $item = $( key );
                    if ( $item.length ) {
                        $item.html( val );
                    }
                } );
            }

        }

		widgetButtonsInit();
		productButtonsInit();
        getRefreshedFragments();

	} );
}( jQuery) );