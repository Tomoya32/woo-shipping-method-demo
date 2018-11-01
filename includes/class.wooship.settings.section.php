<?php
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
{
	add_filter( 'woocommerce_get_sections_advanced', 'wc_wooship_add_shipping_section' );

	function wc_wooship_add_shipping_section( $sections ) {
		
		$sections['wooship'] = __( 'Wooship Demo Section', 'wooship' );
		return $sections;
	}

	add_filter( 'woocommerce_get_settings_advanced', 'wooship_all_settings', 10, 2 );

	function wooship_all_settings( $settings, $current_section ) {
		/**
		 * Check the current section is what we want
		 **/

		if ( $current_section == 'wooship' ) {
			$wc_wooship_api_settings = array();
			// Add Title to the Settings
			$wc_wooship_api_settings[] = array( 'name' => __( 'Demo Section', 'wooship' ), 'type' => 'title', 'desc' => __( 'A demo section where you can have all global settings saved', 'wooship' ), 'id' => 'wooship' );			
			// Add second text field option
			$wc_wooship_api_settings[] = array(
				'name'     => __( 'API Key', 'wooship' ),
				'desc_tip' => __( 'wooship API key', 'wooship' ),
				'id'       => 'wc_wooship_api_key',
				'type'     => 'text',
				'desc'     => __( 'Get the API key from your dashboard', 'wooship' ),
			);

			$wc_wooship_api_settings[] = array(
				'name'     => __( 'API Secret', 'wooship' ),
				'desc_tip' => __( 'API Secret', 'wooship' ),
				'id'       => 'wc_wooship_api_secret',
				'type'     => 'text',
				'desc'     => __( 'Get the API secret from wooship Settings', 'wooship' ),
			);


			$wc_wooship_api_settings[] = array(
				'title' 		=> __('Channels', 'wooship'),
				'id'    		=> 'wc_wooship_channel_id',
				'type'  		=> 'select',
				'default' 		=> get_option('wc_wooship_channel_id'),
				'desc' 			=> __('Select a sales channel to post order to', 'wooship'),
				'desc_tip' 		=> __('Select a sales channel to post order to', 'wooship'),
				'options' 		=> array(
					'option1' => "Option 1",
					'option2' => "Option 2",
					'option3' => "Option 3",
				),
			);
			
			$wc_wooship_api_settings[] = array( 'type' => 'sectionend', 'id' => 'wooship' );
			return $wc_wooship_api_settings;
		
		/**
		 * If not, return the standard settings
		 **/
		} else {
			return $settings;
		}
	}
}