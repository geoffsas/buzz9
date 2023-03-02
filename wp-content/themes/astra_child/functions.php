<?php

/**

 * astra_child Theme functions and definitions

 *

 * @link https://developer.wordpress.org/themes/basics/theme-functions/

 *

 * @package astra_child

 * @since 1.0.0

 */



/**

 * Define Constants

 */

define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );



/**

 * Enqueue styles

 */

function child_enqueue_styles() {



	wp_enqueue_style( 'astra_child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );



}



add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );



add_action( 'wp_enqueue_scripts', 'menu_scripts' );

function menu_scripts() {
    wp_enqueue_script('signature','https://cdn.jsdelivr.net/npm/signature_pad@4.1.5/dist/signature_pad.umd.min.js',array('jquery'));
	wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/assets/custom-script.js', array( 'jquery' ));
	wp_localize_script('custom-script', 'ajax_object', [
		'ajax_url' => admin_url('admin-ajax.php')
	]);
}

function search_companies() {

	$search = $_POST['search'];
	$curl = curl_init();
	curl_setopt_array($curl, [
		CURLOPT_URL => 'https://api.company-information.service.gov.uk/search/companies?q='.$search.'&items_per_page=20',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_HTTPHEADER => [
			'Accept: application/json',
			'Authorization: Basic OTRhMjZkZmEtZGY1NC00ZDZkLTg3M2UtOGMyMTE2MmVkNjMz'
		],
	]);

	$response = curl_exec($curl);
	curl_close($curl);
	$json_obj = json_decode($response);
	$company_names = [];
	foreach($json_obj->items as $obj) {
		$company_names[] = $obj->title;
	}
	if(empty($company_names)) {
		$finalResult = ['type' => 'error', 'response' => '', 'msg' => 'Nothing found'];
	} else {
		$finalResult = ['type' => 'success', 'response' => $company_names, 'msg' => 'found'];
	}
	echo json_encode($finalResult);
	exit();
}
add_action( 'wp_ajax_search_companies', 'search_companies' );
add_action("wp_ajax_nopriv_search_companies", "search_companies");


// function that runs when shortcode is called
function EB_Zipcode_shortcode() { 
	$output = '';
	ob_start(); ?>
	<div class="home_zipcode">
		<div class="alert-box failure">Business Zipcode is required</div>
		<form id="sub_zipcode" action="" method="post">
			<div class="form-group">
				<input type="text" name="zip_code" id="zip_code" placeholder="ENETR BUSINESS ZIPCODE">
			</div>
			<div class="spacer">
				<button type="button" id="btzip">CHECK FOR FREE <span class="elementor-button-content-wrapper">
							<span class="elementor-button-icon elementor-align-icon-right">
				<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M4 20C4 11.18 11.18 4 20 4C28.82 4 36 11.18 36 20C36 28.82 28.82 36 20 36C11.18 36 4 28.82 4 20ZM-8.74228e-07 20C-1.3568e-06 31.04 8.96 40 20 40C31.04 40 40 31.04 40 20C40 8.96 31.04 -3.91654e-07 20 -8.74228e-07C8.96 -1.3568e-06 -3.91654e-07 8.96 -8.74228e-07 20ZM20 18L12 18L12 22L20 22L20 28L28 20L20 12L20 18Z" fill="white"></path></svg>			</span>
		</span></button>
			</div>
		</form>
	</div>
	<?php $output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode('EB_Zipcode', 'EB_Zipcode_shortcode');


//Capture the wpform submit, and call the "processForm" function
add_action( 'wpforms_process_complete', 'processForm', 5, 4 );
function processForm( $form_fields, $entry, $form_data, $entry_id ) {

    global $wpdb;
    $form_id = $form_data['id'];
	$field_val = [];
	foreach($form_fields as $field){
		$field_val[] = $field['value'];
	}
	$business_name = $field_val[0];
	$name = $field_val[1];
	$email = $field_val[2];
	$phone = $field_val[3];
	$com_trading = $field_val[4];
	$spend_en_month = $field_val[5];
	$en_broker = $field_val[6];
	$terms_cond = $field_val[7];
	
	
	$email_message = '';
    $email_subject = 'Business Energy Refund Claim';
	
	$email_message .='<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- So that mobile will display zoomed in -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- enable media queries for windows phone 8 -->
  <meta name="format-detection" content="telephone=no"> <!-- disable auto telephone linking in iOS -->
  <title>Business Energy Refund Claim</title>

  <style type="text/css">
body {
  margin: 0;
  padding: 0;
  -ms-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%;
}

table {
  border-spacing: 0;
}

table td {
  border-collapse: collapse;
}

.ExternalClass {
  width: 100%;
}

.ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
  line-height: 100%;
}

.ReadMsgBody {
  width: 100%;
  background-color: #ebebeb;
}

table {
  mso-table-lspace: 0pt;
  mso-table-rspace: 0pt;
}

img {
  -ms-interpolation-mode: bicubic;
}

.yshortcuts a {
  border-bottom: none !important;
}

@media only screen and (max-width: 600px) {
  *[class="gmail-fix"] {
    display: none !important;
  }
}
@media screen and (max-width: 599px) {
  table[class="force-row"],
  table[class="container"] {
    width: 100% !important;
    max-width: 100% !important;
  }
  
  table[class="force-row two"] {
    width: 50% !important;
    max-width: 50% !important;
  }
}
@media screen and (max-width: 400px) {
  td[class*="container-padding"] {
    padding-left: 12px !important;
    padding-right: 12px !important;
  }
}
.ios-footer a {
  color: #aaaaaa !important;
  text-decoration: underline;
}

@media screen and (max-width: 599px) {
  td[class="col"] {
    width: 50% !important;
    text-align: center;
  }

  td[class="cols-wrapper"] {
    padding-top: 18px;
  }
  
  img[class="image"] {
    padding-bottom: 10px;
  }

  /*
img[class="image"] {
    float: right;
    max-width: 40% !important;
    height: auto !important;
    margin-left: 12px;
  }
*/

  div[class="subtitle"] {
    margin-top: 0 !important;
  }
}
@media screen and (max-width: 400px) {
  td[class="cols-wrapper"] {
    padding-left: 0 !important;
    padding-right: 0 !important;
  }

  td[class="content-wrapper"] {
    padding-left: 12px !important;
    padding-right: 12px !important;
  }
}
</style>

</head>
<body style="margin:0; padding:0;" bgcolor="#e1e1e1" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<!-- 100% background wrapper (grey background) -->
<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#e1e1e1">
  <tr>
    <td align="center" valign="top" bgcolor="#e1e1e1" style="background-color: #e1e1e1;">

      <br>

      <!-- 600px container (white background) -->
      <table border="0" width="600" cellpadding="0" cellspacing="0" class="container" style="width:600px;max-width:600px">
        <tr class="gmail-fix">
          <td>
            <table cellpadding="0" cellspacing="0" border="0" align="center" width="600">
              <tr>
                <td cellpadding="0" cellspacing="0" border="0" height="1"; style="line-height: 1px; min-width: 600px;">
                  <img src="http://coloredge.com/newsletters/2015/06/images/spacer.gif" width="600" height="1" style="display: block; max-height: 1px; min-height: 1px; min-width: 600px; width: 600px;"/>
                  </td>
                </tr>
            </table>
          </td>
        </tr>
        
        <tr>
          <td class="content" align="left" style="background-color:#ffffff">

<table width="600" border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 600px;">
  <tr>
    <td>
      <a href="http://coloredge.com" title="Coloredge">
        <img style="width:100%;" src="http://coloredge.com/newsletters/2015/06/images/header.jpg">
      </a>
    </td>
  </tr>
  <tr>
    <td class="content-wrapper" style="padding-left:24px;padding-right:24px;text-align: center;">
      <p style="text-transform:uppercase;font-family:sans-serif;font-size: 24px !important;margin-top: 15px; margin-bottom: 15px;">Thank you, '.$name.'!</p> 
      <p style="font-family:sans-serif;font-size: 14px !important;margin-top: 15px; margin-bottom: 15px;line-height: 1.4 !important;">You’ve successfully submitted your mis-sold business energy query to us.</p> 
      <p style="font-family:sans-serif;font-size: 14px !important;margin-top: 15px; line-height: 1.4;">A member of our expert team will now review your submission and will be in touch with you soon to discuss your possible claim.</p><br>
      <p style="font-family:sans-serif;font-size: 14px !important;margin-top: 15px; line-height: 1.4;">Kind regards,</p>
      <p style="font-family:sans-serif;font-size: 14px !important;margin-top: 15px; line-height: 1.4;">The Refund My Business Energy Team</p>
      <hr style="border-bottom: solid 1px #000; border-top: 0;">
    </td>
  </tr>
  
  <tr>
    <td class="cols-wrapper" style="padding-left:12px;padding-right:12px">
        <table border="0" cellpadding="0" cellspacing="0" align="center" class="force-row two" style="width: 100%;">
          <tr>
            <td class="col" valign="top" style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px">
              <div class="subtitle" style="background: #101A5A;font-family:Helvetica, Arial, sans-serif;font-size:12px !important;color:#000; margin-top:8px; text-transform: uppercase; text-align: center;"><p style=" color: #fff; text-align: center; max-width:100%; width: 70%; margin: 0 auto; padding: 12px 30px;">© Refund My Business Energy is a trading style of Ethical Utilities Ltd. Company No: 13490837. Registered office address: Cbx Cobalt Business Exchange Ethical Utilities Ltd, 212 - 213 Cobalt Park Way, Newcastle Upon Tyne, England, NE28 9NZ.</p></div>
            </td>
          </tr>
        </table>
      
    </td>
  </tr>
  <tr>
    <td style="background:#fff;text-align:center;width:100%;height:15px;"></td>  
  </tr>
  
  <tr>
    <td style="background:#fff;text-align:center;width:100%;height:25px;"></td>  
  </tr>
  
  <tr>
    <td style="background:#e1e1e1;text-align:center;width:100%;height:15px;"></td>  
  </tr>
  <tr>
    <td style="background:#e1e1e1;text-align:center;width:100%;height:5px;"></td> 
  </tr>
  <tr>
    <td style="background:#e1e1e1;text-align:center;width:100%;height:30px;"></td>  
  </tr>
</table>
          </td>
        </tr>
      </table><br><br><br><br>
	</td>
  </tr>
</table>
</body>
</html>';
	
	$headers = "From: no-reply@refundmybusinessenergy.co.uk>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	$mail_alert = mail($email, $email_subject, stripslashes($email_message), $headers);
	if($mail_alert){
		$message = esc_html__('Thank you your form submitted.');
		echo json_encode(array('type' => 'success', 'message' =>  $message ));
		die();
	}
}