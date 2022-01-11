<? php

//add line no.5-42 on your child theme's function.php file

//Vendor Setup Wizard Style
function vendor_setup_wizard_styles(){
  ?>
  <style>
  
    a.button-primary.button.button-large.button-next.lets-go-btn.dokan-btn-theme {
    box-shadow: unset !important;
    text-shadow: unset !important;
  }
    
  input.button-primary.button.button-large.button-next.store-step-continue.dokan-btn-theme{
    box-shadow: unset !important;
    text-shadow: unset !important;
  }
    
  input.button-primary.button.button-large.button-next.payment-continue-btn.dokan-btn-theme{
  box-shadow: unset !important;
    text-shadow: unset !important; 
  }
    
  .wc-setup-actions a.button.button-primary.dokan-btn-theme{
  box-shadow: unset !important;
    text-shadow: unset !important;    
  }
  .wc-setup .wc-setup-steps li.done, .wc-setup .wc-setup-steps li.active {
    color: #9450E6;
    border-color: #9450E6;
  }
  
  .wc-setup .wc-setup-steps li.done:before, .wc-setup .wc-setup-steps li.active:before {
    background: #9450E6;
    border-color: #9450E6;
  }

  </style>
  <?php
};
add_action( 'dokan_setup_wizard_styles', 'vendor_setup_wizard_styles', 30 );

?>
