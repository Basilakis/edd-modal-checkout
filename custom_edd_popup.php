<?php 
/*
Plugin Name: EDD Button Shortcode Modal for ReMarketing
Plugin URI: https://creativeg.gr
Description: EDD Button Shortcode that can be used to open a Modal Window before the Checkout page, to ask for user to fill his email. Use for Remarketing Campaigns
Author: Basilis Kanonidis
Author URI: https://creativeg.gr
Version: 1.0
License: GPLv2 or later
*/

add_action('wp_enqueue_scripts', 'custom_edd_enqueue_scripts');
add_action('wp_footer', 'custom_edd_checkout_page');
add_shortcode('custom-edd-popup', 'custom_edd_popup');

function custom_edd_enqueue_scripts() {
      wp_enqueue_script('jquery');
      wp_enqueue_style('custom-edd-css', plugins_url('assets/style.css', __FILE__), array());
      if(!wp_script_is('bootstrapjs','enqueued')) {
        wp_enqueue_script(
            'bootstrapjs',
            'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
            array()
        );  
      } 
}

function custom_edd_popup( $atts ) {
     $a = shortcode_atts( array(
        'txt'         => 'Buy Now',
        'class'       => 'button',
        'downloadid'  => '1',
        'priceid'     => '1',
        'productname' => 'support'

    ), $atts );
	

	$content='
<button type="button" class="'.esc_attr($a['class']).'" data-toggle="modal" data-target="#myModal">'.esc_attr($a['txt']).'</button>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-idex:999 !important;">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Start now</h5><span class="button" data-dismiss="modal" aria-label="Close">X</span>
            </div>
            <div class="modal-body">
             <form action="'.get_option( 'siteurl' ).'" method="get">
	  			<div class="form-group">
	  				<input type="text" name="email" id="email" class="form-control">
	  				 <input type="hidden" name="edd_action" value="add_to_cart">
	  				 <input type="hidden" name="download_id" value="'.esc_attr($a['downloadid']).'">
	  				 <input type="hidden" name="edd_options[price_id]" value="'.esc_attr($a['priceid']).'">
	  				<input type="hidden" name="plan-product" value="'.esc_attr($a['productname']).'">
                   <input type="submit" name="" id="edd_modal_submit" value="submit">
	  			</div>
	  		</form>

            </div>
          </div>
        </div>
      </div> 
';
	return $content;
	
}


function custom_edd_checkout_page()
{
   
	if(is_page('checkout')){
	     
		$email = $_GET['email'];
		$plan = $_GET['plan-product'];
			if($email):
?>
				<script type="text/javascript">
					jQuery(document).ready(function($){
						setTimeout(function(){ jQuery('#edd-email').val('<?php echo $email; ?>');	; }, 1000);
					})
					
				</script>
		<?php	
			endif;
	}
}
