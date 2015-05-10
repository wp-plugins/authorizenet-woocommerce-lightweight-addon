<?php
/**
 * Plugin Name: Authorize.Net WooCommerce Lightweight Addon
 * Plugin URI: Plugin URI: https://wordpress.org/plugins/authorizenet-woocommerce-lightweight-addon/
 * Description: This plugin adds a payment option in WooCommerce for customers to pay with their Credit Cards Via Authorize.Net.
 * Version: 1.0.0
 * Author: Syed Nazrul Hassan
 * Author URI: https://nazrulhassan.wordpress.com/
 * License: GPLv2
 */

function authorizenet_lightweight_init()
{
	
	function add_authorizenet_lightweight_gateway_class( $methods ) 
	{
		$methods[] = 'WC_Authorizenet_Lightweight_Gateway'; 
		return $methods;
	}
	add_filter( 'woocommerce_payment_gateways', 'add_authorizenet_lightweight_gateway_class' );

	if(class_exists('WC_Payment_Gateway'))
	{
		class WC_Authorizenet_Lightweight_Gateway extends WC_Payment_Gateway 
		{
			
		
		public function __construct()
		{

		$this->id               = 'authorizenetlightweight';
		$this->icon             = apply_filters( 'woocommerce_authorizenet_lightweight_icon', plugins_url( 'images/authorizenet_lightweight.png' , __FILE__ ) );
		$this->has_fields       = true;
		$this->method_title     = 'Authorize.Net Cards Settings';		
		$this->init_form_fields();
		$this->init_settings();
		$this->title			           = $this->get_option( 'authorizenet_lightweight_title' );
		$this->authorizenet_lightweight_apilogin        = $this->get_option( 'authorizenet_lightweight_apilogin' );
		$this->authorizenet_lightweight_transactionkey  = $this->get_option( 'authorizenet_lightweight_transactionkey' );
		$this->authorizenet_lightweight_sandbox         = $this->get_option( 'authorizenet_lightweight_sandbox' ); 
		$this->authorizenet_lightweight_liveurl         = 'https://secure.authorize.net/gateway/transact.dll';
          $this->authorizenet_lightweight_testurl         = 'https://test.authorize.net/gateway/transact.dll';
         
         
         
		define("AUTHORIZE_NET_SANDBOX", ($this->authorizenet_lightweight_sandbox =='yes'? true : false));

		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

		}
		
		
		
		public function admin_options()
		{
		?>
		<h3><?php _e( 'Authorize.Net addon for WooCommerce', 'woocommerce' ); ?></h3>
		<p><?php  _e( 'Authorize.Net is a payment gateway service provider allowing merchants to accept credit card.', 'woocommerce' ); ?></p>
		<table class="form-table">
		  <?php $this->generate_settings_html(); ?>
		</table>
		<?php
		}
		
		
		
		public function init_form_fields()
		{
		$this->form_fields = array
		(
			'enabled' => array(
			  'title' => __( 'Enable/Disable', 'woocommerce' ),
			  'type' => 'checkbox',
			  'label' => __( 'Enable Authorize.Net', 'woocommerce' ),
			  'default' => 'yes'
			  ),
			'authorizenet_lightweight_title' => array(
			  'title' => __( 'Title', 'woocommerce' ),
			  'type' => 'text',
			  'description' => __( 'This controls the title which the buyer sees during checkout.', 'woocommerce' ),
			  'default' => __( 'Authorize.Net', 'woocommerce' ),
			  'desc_tip'      => true,
			  ),
			'authorizenet_lightweight_apilogin' => array(
			  'title' => __( 'API Login ID', 'woocommerce' ),
			  'type' => 'text',
			  'description' => __( 'This is the API Login ID Authorize.net.', 'woocommerce' ),
			  'default' => '',
			  'desc_tip'      => true,
			  'placeholder' => 'Authorize.Net API Login ID'
			  ),
		
			'authorizenet_lightweight_transactionkey' => array(
			  'title' => __( 'Transaction Key', 'woocommerce' ),
			  'type' => 'text',
			  'description' => __( 'This is the Transaction Key of Authorize.Net.', 'woocommerce' ),
			  'default' => '',
			  'desc_tip'      => true,
			  'placeholder' => 'Authorize.Net Transaction Key'
			  ),

		
			'authorizenet_lightweight_sandbox' => array(
			  'title'       => __( 'Authorize.Net sandbox', 'woocommerce' ),
			  'type'        => 'checkbox',
			  'label'       => __( 'Enable Authorize.Net sandbox', 'woocommerce' ),
			  'default'     => 'no',
			  'description' => __( 'If checked its in sanbox mode and if unchecked its in live mode', 'woocommerce' )
			)
	  	);
  		}
		
		public function payment_fields()
		{			
		?>
		<table>
		    <tr>
		    	<td><label for="authorizenet_ltwt_cardno"><?php echo __( 'Card No.', 'woocommerce') ?></label></td>
			<td><input type="text" name="authorizenet_ltwt_cardno" class="input-text" placeholder="Credit Card No"  /></td>
		    </tr>
		    <tr>
		    	<td><label for="authorizenet_ltwt_expiration_date"><?php echo __( 'Expiration Date', 'woocommerce') ?>.</label></td>
			<td>
			   <select name="authorizenet_ltwt_expmonth" style="height: 33px;">
			      <option value=""><?php _e( 'Month', 'woocommerce' ) ?></option>
			      <option value='01'>01</option>
			      <option value='02'>02</option>
			      <option value='03'>03</option>
			      <option value='04'>04</option>
			      <option value='05'>05</option>
			      <option value='06'>06</option>
			      <option value='07'>07</option>
			      <option value='08'>08</option>
			      <option value='09'>09</option>
			      <option value='10'>10</option>
			      <option value='11'>11</option>
			      <option value='12'>12</option>  
			    </select>
			    <select name="authorizenet_ltwt_expyear" style="height: 33px;">
			      <option value=""><?php _e( 'Year', 'woocommerce' ) ?></option>
			      <?php
			      $years = array();
			      for ( $i = date( 'y' ); $i <= date( 'y' ) + 15; $i ++ ) 
			      {
					printf( '<option value="20%u">20%u</option>', $i, $i );
			      } 
			      ?>
			    </select>
			</td>
		    </tr>
		    <tr>
		    	<td><label for="authorizenet_ltwt_cardcvv"><?php echo __( 'Card CVC', 'woocommerce') ?></label></td>
			<td><input type="text" name="authorizenet_ltwt_cardcvv" class="input-text" placeholder="CVC" /></td>
		    </tr>
		</table>
	        <?php  
		} // end of public function payment_fields()
		
		
		public function authorizenet_lightweight_params($wc_order)
      	{      
      	
			    $authorizenet_lightweight_args = array(
				  'x_login'                  => $this->authorizenet_lightweight_apilogin,
				  'x_tran_key'               => $this->authorizenet_lightweight_transactionkey,
				  'x_version'                => '3.1',
				  'x_delim_data'             => 'TRUE',
				  'x_delim_char'             => '|',
				  'x_relay_response'         => 'FALSE',
				  'x_type'                   => 'AUTH_CAPTURE',
				  'x_method'                 => 'CC',
				  'x_card_num'               => sanitize_text_field($_POST['authorizenet_ltwt_cardno']),
				  'x_exp_date'               => sanitize_text_field($_POST['authorizenet_ltwt_expmonth' ]).sanitize_text_field($_POST['authorizenet_ltwt_expyear' ]),
				  'x_card_code'              => sanitize_text_field($_POST['authorizenet_ltwt_cardcvv']), 
				  'x_description'            => 'Order #'.$wc_order->id,
				  'x_amount'                 => $wc_order->order_total,
				  'x_first_name'             => $wc_order->billing_first_name ,
				  'x_last_name'              => $wc_order->billing_last_name ,
				  'x_company'                => $wc_order->billing_company ,
				  'x_address'                => $wc_order->billing_address_1 .' '. $wc_order->billing_address_2,
				  'x_country'                => $wc_order->billing_country,
				  'x_phone'                  => $wc_order->billing_phone,
				  'x_state'                  => $wc_order->billing_state,
				  'x_city'                   => $wc_order->billing_city,
				  'x_zip'                    => $wc_order->billing_postcode,
				  'x_email'                  => $wc_order->billing_email,
				  'x_ship_to_first_name'     => $wc_order->shipping_first_name,
				  'x_ship_to_last_name'      => $wc_order->shipping_last_name,
				  'x_ship_to_address'        => $wc_order->shipping_address_1.' '. $wc_order->shipping_address_2  ,
				  'x_ship_to_city'           => $wc_order->shipping_city,
				  'x_ship_to_state'          => $wc_order->shipping_state,
				  'x_ship_to_zip'            => $wc_order->shipping_postcode,
				  'x_ship_to_country'        => $wc_order->shipping_country,
				  'x_customer_ip'		    => $_SERVER['REMOTE_ADDR']
				  
				   );
        			 return $authorizenet_lightweight_args;
     	 } // End of authorizenet_lightweight_params
		
		
		public function process_payment($order_id)
		{
		
			global $woocommerce;
         		$wc_order = new WC_Order($order_id);
         		
         
			if(AUTHORIZE_NET_SANDBOX == 'yes')
			{
				$gatewayurl = $this->authorizenet_lightweight_testurl; 
			}
			else
			{
				$gatewayurl = $this->authorizenet_lightweight_liveurl;
			}
			
			$params = $this->authorizenet_lightweight_params($wc_order);
         
			$post_string = "";
			foreach( $params as $key => $value )
			{ 
			  $post_string .= "$key=".urlencode($value )."&"; 
			}
			$post_string = rtrim($post_string,"&");


			$curlrequest = curl_init($gatewayurl); 
			curl_setopt($curlrequest, CURLOPT_HEADER, 0); 				// set to 0 to eliminate header info from response
			curl_setopt($curlrequest, CURLOPT_RETURNTRANSFER, 1); 		// Returns response data instead of TRUE(1)
			curl_setopt($curlrequest, CURLOPT_POSTFIELDS, $post_string); 	// use HTTP POST to send form data
			curl_setopt($curlrequest, CURLOPT_SSL_VERIFYPEER, FALSE); 		// uncomment this line if you get no gateway response.
			$post_response = curl_exec($curlrequest);					// execute curl post and store results in $post_response
			curl_close ($curlrequest);

			 
			$response_array = explode('|',$post_response);
		
			
		if ( count($response_array) > 1 )
		{
			if($response_array[0] == '1' )
			{
			$wc_order->add_order_note( __( $response_array[3]. 'on '.date("d-m-Y h:i:s e").' with Transaction ID = '.$response_array[6].' using '.$response_array[11].', authorization code ='.$response_array[4].', card code verification='.$response_array[38].', cardholder authentication verification response code='.$response_array[39].', Card Type='.$response_array[51].', Last 4='.$response_array[50], 'woocommerce' ) );
			$wc_order->payment_complete($response_array[6]);
					return array (
								'result'   => 'success',
								'redirect' => $this->get_return_url( $wc_order ),
							   );
			
			}
			else 
			{
				$wc_order->add_order_note( __( 'Authorize.Net payment failed.'.$response_array[3].'--'.'--', 'woocommerce' ) );
				wc_add_notice('Error Processing Authorize.Net Payments', $notice_type = 'error' );
			}
		
		}
		else 
		{
			$wc_order->add_order_note( __( 'Authorize.Net payment failed.'.$response_array[3].'--'.'--', 'woocommerce' ) );
			wc_add_notice('Error Processing Authorize.Net Payments', $notice_type = 'error' );
		}
        
        
		
		}// End of process_payment
		
		
		}// End of class WC_Authorizenet_Lightweight_Gateway
	} // End if WC_Payment_Gateway
}// End of function authorizenet_lightweight_init

add_action( 'plugins_loaded', 'authorizenet_lightweight_init' );
