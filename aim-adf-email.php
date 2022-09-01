<?php
   /*
   Plugin Name: AIM Experts ADF Email
   Plugin URI: https://aimexperts.com
   description: This allows CF7 Form entries to be recored in the AIM lead records.
   Version: 1.0.0
   Author: Liam Kennedy
   Author URI: https://aimexperts.com
   License: GPL2
   */

add_action( 'wpcf7_before_send_mail', 'wpcf7_add_text_to_mail_body' );
function wpcf7_add_text_to_mail_body($contact_form){
	$to = 'rainbow_ford@parse.aimexperts.com';
    //$to = 'liam@aimexperts.com';
	$adf_subject = 'ADF email';
	$message = '';

	$post_id = $_POST['_wpcf7_container_post'];
	$form_id = $_POST['_wpcf7'];
	
	
	$actual_link = get_permalink( $post_id );
		
	$data = apply_filters( 'stm_single_car_data', stm_get_single_car_listings() );

	foreach($data as $data_value) {
		$post_m = get_post_meta($post_id, $data_value['slug'], true);
		
		if($data_value['slug'] == 'stock-number')
		{
			$stocknumber = $post_m;
		}
	}

	$title = get_the_title($post_id);
	
	$arr = explode(" ", $title);
	
	$year = $arr[0];
	$make = $arr[1];
	$model = $arr[2];
	
	if($form_id == 717) {
		if ($_POST['first-name'] != '') {
			$firstname = $_POST['first-name'];
		}
        if ($_POST['last-name'] != '') {
			$lastname = $_POST['last-name'];
		}
		if ($_POST['phone'] != '') {
			$phone = $_POST['phone'];
		}
		if ($_POST['email'] != '') {
			$email = $_POST['email'];
		}
		if ($_POST['message'] != '') {
			$texts = $_POST['message'];
		}
		
		$message = '<?xml version="1.0" encoding="UTF-8"?>
		<?adf version="1.0"?>
		<adf>
		<prospect> 
		<requestdate>'.date("m-d-y").'</requestdate>
		<vehicle>
		<year>Not Provided</year> 
		<make>Not Provided</make>
		<model>Not Provided</model>
        <vin>Not Provided</vin>
        <trim>Not Provided</trim>
		<price type="quote" currency="CAD">Not Provided</price>
		</vehicle>
		<customer>
 		<contact>
  		<name part="full">'.$firstname.' '.$lastname.'</name>
        <name part="first">'.$firstname.'</name>
        <name part="last">'.$lastname.'</name>
         <phone>'.$phone.'</phone>
   		<email>'.$email.'</email>
    	</contact>
     	<comments> message: '.$texts.' from the page '.$actual_link.'</comments> 
     	</customer>
		<vendor>
		<contact>
		<name part="full">Rainbow Ford</name> 
		</contact>
		</vendor>
		<provider> 
		<name part="full">'.$title.'</name>
		<url>'.$actual_link.'</url>
        <service>'.$title.'</service></provider> 
		</prospect>
		</adf>';

		$headers = array('Content-Type: text/plain; charset=UTF-8');
		wp_mail($to, $adf_subject, $message, $headers);
	}	
    
    if($form_id == 2093) {
		if ($_POST['first-name'] != '') {
			$firstname = $_POST['first-name'];
		}
        if ($_POST['lastname-name'] != '') {
			$lastname = $_POST['lastname-name'];
		}
		if ($_POST['tel-number'] != '') {
			$phone = $_POST['tel-number'];
		}
		if ($_POST['your-email'] != '') {
			$email = $_POST['your-email'];
		}
		if ($_POST['Broncochoice'] != '') {
			$texts = $_POST['Broncochoice'];
		}
        if ($_POST['preferedcontact'] != '') {
			$preferedcontact = $_POST['preferedcontact'];
		}
		
		$message = '<?xml version="1.0" encoding="UTF-8"?>
		<?adf version="1.0"?>
		<adf>
		<prospect> 
		<requestdate>'.date("m-d-y").'</requestdate>
		<vehicle>
		<year>NA</year> 
		<make>Ford</make>
		<model>Bronco</model>
        <vin>NA</vin>
        <trim>NA</trim>
		<price type="quote" currency="CAD">Not Provided</price>
		</vehicle>
		<customer>
 		<contact>
  		<name part="full">'.$firstname.' '.$lastname.'</name>
        <name part="first">'.$firstname.'</name>
        <name part="last">'.$lastname.'</name>
         <phone>'.$phone.'</phone>
   		<email>'.$email.'</email>
    	</contact>
     	<comments> Choice of Bronco: '.$texts.' | from the page '.$actual_link.' I would like to be contacted by '.$preferedcontact.'</comments> 
     	</customer>
		<vendor>
		<contact>
		<name part="full">Rainbow Ford</name> 
		</contact>
		</vendor>
		<provider> 
		<name part="full">'.$title.'</name>
		<url>'.$actual_link.'</url>
        <service>'.$title.'</service></provider> 
		</prospect>
		</adf>';

		$headers = array('Content-Type: text/plain; charset=UTF-8');
		wp_mail($to, $adf_subject, $message, $headers);
	}		



}