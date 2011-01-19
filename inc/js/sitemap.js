$( function() {
	
	var Sitemap = {
			
		init: function( options ) {
			
			var options = $.extend( { 
				
				url: '/sitemap2/inc/php/get_sitemap.php',
				mode: null
				
			}, options )
			
			$.ajax( { 
				
				url: options.url,
				error: function(){},
				success: function( respone ) {
					
					// show the returned sitemap
					$( 'fieldset#sitemap' ).html( respone );
					
					// init methods
					Mode.init();
					Undo.init();
					Add.init();
					Delete.init();
					Edit_name.init();
					Zoom.init();
					//Sort.init();
					Notes.init();
					
					// append div.first to remove excess lines
					$( 'fieldset#sitemap li' ).each( function() {
						
						if( $( this ).is( ':first-child' ) ) {
							$( this ).prepend( '<div class="first"></div>' );
						}
						
						if( $( this ).is( ':last-child' ) ) {
							$( this ).prepend( '<div class="last"></div>' );
						}
						
					} );
					
					// underline INFO if a note was set
					$( 'fieldset#sitemap p.info' ).each( function() {
			
						if( $( this ).text() != '' ) {
							
							$( this ).parents( 'div.page' ).children( 'p.add_notes' ).children( 'a' ).css( 'text-decoration', 'underline' );
							
						}
						
					} );
					
					// set a new page icon if the mode was set to list by Mode.init();
					if( options.mode == 'list' ) {
						$( 'img.page_icon' ).attr( 'src', 'inc/img/page_list.png' ); 
						
						$( 'fieldset#sitemap li' ).each( function() {
							
							if( $( this ).not( ':first' ) ) {
								$( this ).prepend( '<img src="inc/img/node.png" class="node" alt="node" />' );
							}
							
						} );
						
						// remove the first ul border and remove the first node
						$( 'fieldset ul li:first' ).css( 'border', 'none' );
						$( 'img.node:first' ).remove();
						
					}
					
				}
				
			} )
			
		},
		
		refresh: function( options ) {
			
			var options = $.extend( { 
				
				url: '/sitemap2/inc/php/get_sitemap.php'
				
			}, options )
			
			$.ajax( { 
				
				url: options.url,
				error: function(){},
				success: function( respone ) {
					
					// show the returned sitemap
					$( 'fieldset#sitemap' ).html( respone );
					
				}
			
			});
				
		}
			
	}
	
	var Mode = {
			
		init: function() {
			
			//TODO: remove Math.random when not developing to remove the stutter in firefox
			$( 'a.list' ).live( 'click', function() {
				$( $( 'link:eq(2)' ).attr( 'href', 'inc/css/list.css?' + Math.random() ) );
				Sitemap.init( { mode: 'list' } );
			} );
			
			$( 'a.piramid' ).live( 'click', function() {
				$( $( 'link:eq(2)' ).attr( 'href', 'inc/css/piramid.css?' + Math.random() ) );
				Sitemap.init();
			} );
			
		}
			
	}
	
	var Add = {
			
		init: function() {
			
			var clicked = 0;
			
			$( 'p.add_page' ).live( 'click', function() {
				
				clicked++;

				// uses var clicked to stop the inputs from stacking
				if( clicked == 1 ) {
					
					var liid = $( this ).parents( 'li' ).attr( 'id' );
					
					// append a textbox and remove when out of focus
					$( this ).append( '<input type="text" class="add_page_name" name="add_page_name" style="position: absolute; top: -5px; margin: 0 0 0 -70px; width: 120px; z-index: 9999;" />' );
					$( 'input.add_page_name' ).focus();
					$( 'input.add_page_name' ).blur( function() {
						$( this ).remove();
						clicked = 0;
					} );

					// remove textbox when esc is pressed
					$( 'input.add_page_name' ).bind( 'keystrokes', {
						keys: [ 'escape' ]				
					}, function( event ) {
						$( 'input.add_page_name' ).remove();
						clicked = 0;
					});
					
					// send when enter is pressed
					$( 'input.add_page_name' ).bind( 'keystrokes', {
						keys: [ 'enter' ]				
					}, function( event ) {
						
						// get the new page name and removes the input box
						var new_page_name = $( this ).val();
						
						if( new_page_name == '' ) {
							new_page_name = 'Not specified';
						}
							
						clicked = 0;
						$( 'input.add_page_name' ).remove();
						
						$.ajax( {
							
							type: 'POST',
							url: 'inc/php/add_page.php',
							data: 'add_page=1&liid=' + liid + '&livalue=' + new_page_name,
							success: function() {
								// reload the sitemap
								Sitemap.init();
							}
							
						} );	
						
					});
					
				}
				
			} );
			
		}
			
	}
	
	var Delete = {
			
		init: function() {
			
			$( 'p.delete_page' ).click( function() {
				
				confirm_delete = confirm( 'Weet je zeker dat je een pagina wilt verwijderen?' );
				
				if( confirm_delete == true ) {
					
					undo_del_name[0] = $( this ).attr( 'id' );
                    undo_del_liid[0] = $( this ).parents( 'li' ).parents( 'li' ).attr( 'id' );
					
					$.ajax( {
						
						type: 'POST',
						url: 'inc/php/delete_page.php',
						data: 'delete_page=1&lipid=' + $( this ).attr( 'title' ) + '&liid=' + $( this ).parents( 'li' ).attr( 'id' ),
						success: function() {
							Sitemap.init();
						}
						
					} );
					
				}
				
			} );
			
		}
			
	}
	
	var Edit_name = {
			
		init: function() {
			
			var clicked = 0;
			
			$( 'p.page_name' ).live( 'click', function() {
				
				clicked++;

				// uses clicked to stop the inputs from stacking
				if( clicked == 1 ) {
					
					var liid = $( this ).parents( 'li' ).attr( 'id' );
					
					// append a textbox and remove when out of focus
					$( this ).append( '<input type="text" class="edit_page_name" name="edit_page_name" value="' + $( this ).text() + '" style="position: absolute; top: -5px; margin: 0 0 0 -85px; width: 150px; z-index: 9999;" />' );
					$( 'input.edit_page_name' ).focus();
					$( 'input.edit_page_name' ).blur( function() {
						$( this ).remove();
						clicked = 0;
					} );

					// remove when esc is pressed
					$( 'input.edit_page_name' ).bind( 'keystrokes', {
						keys: [ 'escape' ]				
					}, function( event ) {
						$( 'input.edit_page_name' ).remove();
						clicked = 0;
					});
					
					// send when enter is pressed
					$( 'input.edit_page_name' ).bind( 'keystrokes', {
						keys: [ 'enter' ]				
					}, function( event ) {
						
						var edit_page_name = $( this ).val();
						clicked = 0;
						$( 'input.edit_page_name' ).remove();
						
						$.ajax( {
							
							type: 'POST',
							url: 'inc/php/edit_page_name.php',
							data: 'save_page=1&liid=' + liid + '&livalue=' + edit_page_name,
							success: function() {
								Sitemap.init();
							}
							
						} );
						
					});
					
				}
				
			} );
			
		}
			
	}
	
	var Undo = {
			
		init: function() {
			
			
			
		},
		
		undo_del: function() {
			
			$.ajax({
            	
               type: 'POST',
               url: 'inc/php/add_page.php',
               data: 'add_page=1&livalue=' +  undo_del_name[0] + '&liid=' + undo_del_liid[0],
               success: function(){
            	   undo_del_name[0] = [];
            	   undo_del_liid[0] = [];
                    Sitemap.init();               
               }
               
            });
			
		},
		
		undo_sort: function() {
			
			
		}
			
	}
	
	var Zoom = {
			
		init: function() {

			$( 'div#zoom' ).slider( {
				min: 10,
				max: 200,
				value: 100,
				handle: 'div#knob',
				orientation: 'vertical',
				slide: function( e, ui ) {
					$( 'fieldset#sitemap' ).css( 'font-size', ui.value + '%' );
				}
			} );

		}
			
	}
	
	var Sort = {
			
		init: function() {
			Sort.sort();
		},

		sort: function() {
			
			$( 'fieldset#sitemap ul:first' ).addClass( 'sortable' );
			
			$( 'fieldset#sitemap ul.sortable' ).nestedSortable( {
				
				forcePlaceholderSize: true,
				items: 'div',
				axis: 'x',
				//helper: 'original',
				listType: 'ul',
				placeholder: 'ui-state-highlight',
                revert: true
				
			} ).disableSelection();
			
		}
			
	}
	
	var Notes = {
			
		init: function() {
			
			// opens fancybox add_notes.php
			$( 'p.add_notes a' ).click( function() {
				
				//updates the p.info label
				window.info_value = null;
				window.info_value = $( this ).parents( 'div.page' ).children( 'p.info' );
			} );
			$( 'p.add_notes a' ).fancybox();
		}
			
	}
	
	//define vars
	var undo_del_name = [];
	var undo_del_liid = [];
	var redo_del_name = [];
	var redo_del_liid = [];
	
	// bind fancybox
	$( 'a#add_sitemap' ).fancybox();
		
	// bind hotkeys
	$( document ).bind( 'keystrokes', {
		keys: [ 'ctrl+x' ]				
	}, function( event ) {
		Undo.undo_sort();
	});
	
	$( document ).bind( 'keystrokes', {
		keys: [ 'ctrl+z' ]				
	}, function( event ) {
		Undo.undo_del();
	});
	
	// init sitemap
	Sitemap.init();
	
});