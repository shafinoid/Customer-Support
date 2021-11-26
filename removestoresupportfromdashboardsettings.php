<? php
  
//copy from line 5 - 11

//remove support button from the vendor dashboard > settings > store

add_action( 'init', 'dokan_remove_store_support_action' );

function dokan_remove_store_support_action() {
	remove_action( 'dokan_settings_form_bottom', array( dokan_pro()->module->store_support,'add_support_btn_title_input' ), 13 );
}

  ?>
