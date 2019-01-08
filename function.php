add_filter( 'authenticate', 'user_activation_check_code', 11, 3 );
function user_activation_check_code( $user, $user_login, $password )
	{
		// get error class
		$error = new \WP_Error();

		$activation_code = '';

		//check empty login fields
		if ( empty( $user_login ) || empty( $password ) )
		{
			//add error message to each
			if ( empty( $user_login ) )
				$error->add( 'empty_username', __( 'The username field is empty.', 'indoexpo' ) );

			if ( empty( $password ) )
				$error->add( 'empty_password', __( 'The password field is empty.', 'indoexpo' ) );

			//remove authenticate if empty
			remove_action( 'authenticate', 'wp_authenticate_username_password', 20 );

			//return error
			return $error;
		}

		$user_info = get_user_by( 'login', $user_login );

		//invalid if empty uname
		if( empty( $user_info ) )
		{
			//add the error message
			$error->add( 'incorrect_user', __( 'Username does not exist', 'indoexpo' ) );

			// remove the ability to authenticate
			remove_action( 'authenticate', 'wp_authenticate_username_password', 20 );

			//return error
			return $error;
		}
		else
		{
			//get activation code saved for user while regestration
			$activation_code =  get_user_meta( $user_info->ID, 'has_to_be_activated', true ) ;
			//var_dump($activation_code);
		}

		if(  empty($activation_code ) )
		{
			return $user;
			exit;
		}
		else
		{
			//remove authenticate
			remove_action('authenticate', 'wp_authenticate_username_password', 20);
			remove_action('authenticate', 'wp_authenticate_email_password', 20);

			 //error to return to user
			return new WP_Error( 'denied', __("<strong>ERROR</strong>: You're account is not activated.") );


			//}
		}

	}
