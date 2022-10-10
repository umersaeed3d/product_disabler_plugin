<?php
/**
 * TEST_LOADER loader Class File.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;

}

if ( ! class_exists( 'PRODUCT_DISABLER_FRONT_LOADER' ) ) {

	/**
	 * TEST_LOADER class.
	 */
	class PRODUCT_DISABLER_FRONT_LOADER {

		
		/**
		 * Function Constructor.
		 */
		public function __construct() {
		
			add_filter('woocommerce_loop_add_to_cart_link',array($this,'pd_replace_add_to_cart'), 99, 2);
			add_action('woocommerce_simple_add_to_cart',  array($this, 'pd_remove_add_to_cart') );
            add_filter( 'woocommerce_add_to_cart_validation', array($this,'pd_validate_add_cart_item'), 10, 2 );
			
		}
		
		
		function pd_replace_add_to_cart( $add_to_cart_link, $product ) {
            
			$status = get_post_meta($product->id, 'pd_action_status',TRUE);
            
			if(0 == $status ){
            
                $add_to_cart_link = do_shortcode('<button  class="btn btn-primary disabled">Sorry, this product is disabled</button>');
			
            }

			return $add_to_cart_link;
		}

        function pd_validate_add_cart_item( $passed, $product_id ) {

            
            $status = get_post_meta($product_id, 'pd_action_status',TRUE);
            
			if(0 == $status ){
            
                $passed = false;
                wc_add_notice( __( 'The product is disabled, you cannot add into cart', 'textdomain' ), 'error' );
			
            }
                
            return $passed;
        
        }
        
        

        function pd_remove_add_to_cart(){
            
            global $product;
            $productID = $product->get_id();
            $status =  get_post_meta($productID,'pd_action_status',true);

            if(0 == $status){
            
                remove_action('woocommerce_'.$product->get_type().'_add_to_cart', 'woocommerce_'.$product->get_type().'_add_to_cart',30);
                echo '<button  class="btn btn-primary disabled">Sorry, this product is disabled</button>';
                
            }
            
        }

	
	}

	new PRODUCT_DISABLER_FRONT_LOADER();
}
