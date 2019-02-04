/**
* Code to the page (check user activation) where user returns from the emailed link.
**/

// GET user id.
$user_id = filter_input( INPUT_GET, 'user', FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1 ) ) );
						    if ( $user_id ) {
                
						        // get user meta activation hash field
						        $code = get_user_meta( $user_id, 'has_to_be_activated', true );
                    
                    // Check GET key and activation code from user meta
						        if ( $code == filter_input( INPUT_GET, 'key' ) ) {
                    
						            delete_user_meta( $user_id, 'has_to_be_activated' );
                        
						            echo 'User Successfully activated.';
						            echo 'You can login with your account credentials.';
						            echo '<a href=" ' . get_permalink( get_page_by_title( 'login' ) )  . ' " class="btn btn-success btn-lg">Login</a>';

						        } else {
						        	echo 'Wrong Key. Please try again with provided key.' ;
						        }
						    }
