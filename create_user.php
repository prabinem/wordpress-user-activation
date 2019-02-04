/**
* Insert user from your form data
**/

// get variables from your form data
$user_data = array(
                'user_login' => $username_var,
                'user_email' => $email_var,
                'user_pass' => $password_var,
                'first_name' => $firstname_var,
                'last_name'  => $lastname_var,
                'role' => $role_var,
                );

    		 //user_insertion($user_data);
     	$user_id = wp_insert_user($user_data);

            if ( $user_id && !is_wp_error( $user_id ) ) {
                    
                    // activation code generation (i've used here user id and time function)
                    $code = sha1( $user_id . time() );
                    
                    // generate activation link adding key - code and user - user id to the permalink 
                    $activation_link = add_query_arg( array( 'key' => $code, 'user' => $user_id ), get_permalink( 'id' ));
                    
                    $mail_message = 'CONGRATS for submitting your form. Your account has been created with following credentials:

                    Username: ' . $username_var . '
                    Password: ' . $password_var . '
                   Please go through the following link to activate your account. YOUR ACTIVATION LINK: ' . $activation_link;

                    wp_mail( $s_email, 'ACCOUNT ACTIVATION [<site>]', $mail_message );
                    
                    // add code to user meta in order to check activation and compare code while activation.
                    add_user_meta( $user_id, 'has_to_be_activated', $code, true );
                }
