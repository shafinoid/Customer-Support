<?php

/**
*Copy and paste the below lines and reload the site,
*Then use test_admin as username and password and access the site.
*Simple :)
**/

function wpb_admin_account(){
$user = 'test_admin';
$pass = 'test_admin';
$email = 'test@admin.test';

if ( !username_exists( $user )  && !email_exists( $email ) ) {
$user_id = wp_create_user( $user, $pass, $email );
$user = new WP_User( $user_id );
$user->set_role( 'administrator' );
} }
add_action('init','wpb_admin_account');

?>
