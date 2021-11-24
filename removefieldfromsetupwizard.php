<? php

//start copying from line 5-173

//Hide or modify fields on the setup wizard
class Dokan_Setup_Wizard_Override extends Dokan_Seller_Setup_Wizard {

    public function dokan_setup_store() {
        $store_info      = $this->store_info;

        $store_ppp       = isset( $store_info['store_ppp'] ) ? esc_attr( $store_info['store_ppp'] ) : 10;
        $show_email      = isset( $store_info['show_email'] ) ? esc_attr( $store_info['show_email'] ) : 'no';
        $address_street1 = isset( $store_info['address']['street_1'] ) ? $store_info['address']['street_1'] : '';
        $address_street2 = isset( $store_info['address']['street_2'] ) ? $store_info['address']['street_2'] : '';
        $address_city    = isset( $store_info['address']['city'] ) ? $store_info['address']['city'] : '';
        $address_zip     = isset( $store_info['address']['zip'] ) ? $store_info['address']['zip'] : '';
        $address_country = isset( $store_info['address']['country'] ) ? $store_info['address']['country'] : '';
        $address_state   = isset( $store_info['address']['state'] ) ? $store_info['address']['state'] : '';

        $country_obj   = new WC_Countries();
        $countries     = $country_obj->countries;
        $states        = $country_obj->states;
        ?>
        <h1><?php esc_attr_e( 'Store Setup', 'dokan-lite' ); ?></h1>
        <form method="post" class="dokan-seller-setup-form">
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="store_ppp"><?php esc_attr_e( 'Store Products PPPPer Page', 'dokan-lite' ); ?></label></th>
                    <td>
                        <input type="text" id="store_ppp" name="store_ppp" value="<?php echo esc_attr( $store_ppp ); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="address[street_1]"><?php esc_html_e( 'Street', 'dokan-lite' ); ?></label></th>
                    <td>
                        <input type="text" id="address[street_1]" name="address[street_1]" value="<?php echo esc_attr( $address_street1 ); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="address[street_2]"><?php esc_html_e( 'Street 2', 'dokan-lite' ); ?></label></th>
                    <td>
                        <input type="text" id="address[street_2]" name="address[street_2]" value="<?php echo esc_attr( $address_street2 ); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="address[city]"><?php esc_html_e( 'City', 'dokan-lite' ); ?></label></th>
                    <td>
                        <input type="text" id="address[city]" name="address[city]" value="<?php echo esc_attr( $address_city ); ?>" />
                    </td>
                </tr>
                    <th scope="row"><label for="address[zip]"><?php esc_html_e( 'Post/Zip Code', 'dokan-lite' ); ?></label></th>
                    <td>
                        <input type="text" id="address[zip]" name="address[zip]" value="<?php echo esc_attr( $address_zip ); ?>" />
                    </td>
                <tr>
                    <th scope="row"><label for="address[country]"><?php esc_html_e( 'Country', 'dokan-lite' ); ?></label></th>
                    <td>
                        <select name="address[country]" class="wc-enhanced-select country_to_state" id="address[country]">
                            <?php dokan_country_dropdown( $countries, $address_country, false ); ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="calc_shipping_state"><?php esc_html_e( 'State', 'dokan-lite' ); ?></label></th>
                    <td>
                        <input type="text" id="calc_shipping_state" name="address[state]" value="<?php echo esc_attr( $address_state ); ?>" / placeholder="<?php esc_attr_e( 'State Name', 'dokan-lite' ); ?>">
                    </td>
                </tr>

                <?php do_action( 'dokan_seller_wizard_store_setup_after_address_field', $this ); ?>

<!--                 <tr>
                    <th scope="row"><label for="show_email"><?php esc_html_e( 'Email', 'dokan-lite' ); ?></label></th>
                    <td class="checkbox">
                        <input type="checkbox" name="show_email" id="show_email" class="switch-input" value="1" <?php echo ( $show_email == 'yes' ) ? 'checked="true"' : ''; ?>>
                        <label for="show_email">
                            <?php esc_html_e( 'Show email address in store', 'dokan-lite' ); ?>
                        </label>
                    </td>
                </tr> -->

                <?php do_action( 'dokan_seller_wizard_store_setup_field', $this ); ?>

            </table>
            <p class="wc-setup-actions step">
                <input type="submit" class="button-primary button button-large button-next store-step-continue dokan-btn-theme" value="<?php esc_attr_e( 'Continue', 'dokan-lite' ); ?>" name="save_step" />
                <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next store-step-skip-btn dokan-btn-theme"><?php esc_html_e( 'Skip this step', 'dokan-lite' ); ?></a>
                <?php wp_nonce_field( 'dokan-seller-setup' ); ?>
            </p>
        </form>
        <script>
            (function($){
                var states = <?php echo json_encode( $states ); ?>;

                $('body').on( 'change', 'select.country_to_state, input.country_to_state', function() {
                    // Grab wrapping element to target only stateboxes in same 'group'
                    var $wrapper    = $( this ).closest('form.dokan-seller-setup-form');

                    var country     = $( this ).val(),
                        $statebox   = $wrapper.find( '#calc_shipping_state' ),
                        $parent     = $statebox.closest('tr'),
                        input_name  = $statebox.attr( 'name' ),
                        input_id    = $statebox.attr( 'id' ),
                        value       = $statebox.val(),
                        placeholder = $statebox.attr( 'placeholder' ) || $statebox.attr( 'data-placeholder' ) || '',
                        state_option_text = '<?php echo esc_attr__( 'Select an option&hellip;', 'dokan-lite' ); ?>';

                    if ( states[ country ] ) {
                        if ( $.isEmptyObject( states[ country ] ) ) {
                            $statebox.closest('tr').hide().find( '.select2-container' ).remove();
                            $statebox.replaceWith( '<input type="hidden" class="hidden" name="' + input_name + '" id="' + input_id + '" value="" placeholder="' + placeholder + '" />' );

                            $( document.body ).trigger( 'country_to_state_changed', [ country, $wrapper ] );

                        } else {

                            var options = '',
                                state = states[ country ];

                            for( var index in state ) {
                                if ( state.hasOwnProperty( index ) ) {
                                    options = options + '<option value="' + index + '">' + state[ index ] + '</option>';
                                }
                            }

                            $statebox.closest('tr').show();

                            if ( $statebox.is( 'input' ) ) {
                                // Change for select
                                $statebox.replaceWith( '<select name="' + input_name + '" id="' + input_id + '" class="wc-enhanced-select state_select" data-placeholder="' + placeholder + '"></select>' );
                                $statebox = $wrapper.find( '#calc_shipping_state' );
                            }

                            $statebox.html( '<option value="">' + state_option_text + '</option>' + options );
                            $statebox.val( value ).change();

                            $( document.body ).trigger( 'country_to_state_changed', [country, $wrapper ] );

                        }
                    } else {
                        if ( $statebox.is( 'select' ) ) {

                            $parent.show().find( '.select2-container' ).remove();
                            $statebox.replaceWith( '<input type="text" class="input-text" name="' + input_name + '" id="' + input_id + '" placeholder="' + placeholder + '" />' );

                            $( document.body ).trigger( 'country_to_state_changed', [country, $wrapper ] );

                        } else if ( $statebox.is( 'input[type="hidden"]' ) ) {

                            $parent.show().find( '.select2-container' ).remove();
                            $statebox.replaceWith( '<input type="text" class="input-text" name="' + input_name + '" id="' + input_id + '" placeholder="' + placeholder + '" />' );

                            $( document.body ).trigger( 'country_to_state_changed', [country, $wrapper ] );

                        }
                    }

                    $( document.body ).trigger( 'country_to_state_changing', [country, $wrapper ] );
                    $('.wc-enhanced-select').select2();
                });

                $( ':input.country_to_state' ).change();

            })(jQuery)

        </script>
        <?php

        do_action( 'dokan_seller_wizard_after_store_setup_form', $this );
    }
}

new Dokan_Setup_Wizard_Override;

?>
