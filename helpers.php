<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;

}
add_action('wp_ajax_my_pd_status_ajax', 'my_ajax_pd_for_status');

function my_ajax_pd_for_status() {
	
	try {
		$status = $_POST['status'];
		$postId = $_POST['postId'];

		update_post_meta($postId, 'pd_action_status' , $status);

		if(1 == $status){
			$button = '<button class="btn btn-danger" onclick="changeProdStatus(0,'.$postId.')" type="button">Disable Product</button>';
		}else{
			$button = '<button class="btn btn-success" onclick="changeProdStatus(1,'.$postId.')" type="button">Active Product</button>';
		}
		update_post_meta($postId, 'pd_action_key' , $button);
		
		wp_send_json(1);
		
	} catch (\Throwable $th) {
		wp_send_json($th);
	}
	
		

}

    

