<?php
/**
 * TEST_LOADER loader Class File.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;

}

if ( ! class_exists( 'PRODUCT_DISABLER_LOADER' ) ) {

	/**
	 * TEST_LOADER class.
	 */
	class PRODUCT_DISABLER_LOADER {

		public const BACKEND_PRODUCT_GRID_FIELD_SORTORDER
		= [
			'cb',
			'thumb',
			'name',
			'sku',
			'is_in_stock',
			'price',
			'product_cat',
			'product_tag',
			'featured',
			'product_type',
			'date',
			'stats',
			'likes',
			'pd_action'
		];
		public $metaKey;
		public $metaStatus;
		/**
		 * Function Constructor.
		 */
		public function __construct() {

			$this->metaKey = "pd_action_key";
			$this->metaStatus = "pd_action_status";
				
			$this->init();
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'front_assets' ) );
			
			
		}

		public function init() {

			add_filter( 'manage_edit-product_columns', array($this,'add_column_to_product_grid'), 10, 1 );
			add_action( 'manage_product_posts_custom_column', array($this,'add_column_value_to_product_grid'), 10, 2 );
			
		}

		public function add_column_to_product_grid( $aColumns ) {
			$aColumns['pd_action'] = __( 'Action', 'abc' );
			$aReturn = [];
			foreach ( self::BACKEND_PRODUCT_GRID_FIELD_SORTORDER as $sKey ) {
				if ( isset( $aColumns[ $sKey ] ) ) {
					$aReturn[ $sKey ] = $aColumns[ $sKey ];
				}
			}

			/**
			 * search additional unknown fields and attache them to the end
			 */
			foreach ( $aColumns as $sKey => $sField ) {
				if ( ! isset( $aReturn[ $sKey ] ) ) {
					$aReturn[ $sKey ] = $sField;
				}
			}

			return $aReturn;
		}

		public function check_meta_exists($key, $id, $val){
			
			if(! metadata_exists('post', $id, $key)){
				
				add_post_meta($id, $key, $val);
			}
		}

		public function add_column_value_to_product_grid(
			$attributeCode,
			$postId
		) {
			if ( $attributeCode == 'pd_action' ) {
				
				
				$this->check_meta_exists( $this->metaStatus, $postId, '1');
				$product  = new WC_Product( $postId );
				$status = $product->get_meta( $this->metaStatus );
				if(1 == $status){
					$button = '<button class="btn btn-danger col-sm-2" onclick="changeProdStatus(0,'.$postId.')" type="button">Disable Product</button>';
				}else{
					$button = '<button class="btn btn-success col-sm-2" onclick="changeProdStatus(1,'.$postId.')" type="button">Active Product</button>';
				}
				$this->check_meta_exists($this->metaKey, $postId, $button);
				$meta_btn = $product->get_meta( $this->metaKey );
				echo htmlspecialchars_decode($meta_btn);
			}
		}

		
		public function admin_assets() {
			wp_enqueue_style( 'pd-admin-style', PRODUCT_DISABLER_ASSETS_DIR_URL . '/css/admin/admin.css' );
			wp_enqueue_script( 'pd-admin-script', PRODUCT_DISABLER_ASSETS_DIR_URL . '/js/admin/admin.js', array( 'jquery' ), rand() );
			wp_enqueue_script('pd-bootstrap-script', 
				'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', 
				array ('jquery'), 
				false, false);

			wp_enqueue_style( 'pd-bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' );
			wp_localize_script(
				'pd-admin-script',
				'pd_ajax_object',
				array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'nonce' => wp_create_nonce('ajax-nonce')
				)
			);
		}
		public function front_assets() {
			wp_enqueue_style( 'pd-front-style', PRODUCT_DISABLER_ASSETS_DIR_URL . '/css/style.css' );
			wp_enqueue_script( 'pd-front-script', PRODUCT_DISABLER_ASSETS_DIR_URL . '/js/script.js', array( 'jquery' ), rand() );

			// bootstrap
			wp_register_script('pd-bootstrap-script', 
				'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', 
				array ('jquery'), 
				false, false);

			wp_register_style( 'pd-bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' );

			
		}
	}

	new PRODUCT_DISABLER_LOADER();
}
