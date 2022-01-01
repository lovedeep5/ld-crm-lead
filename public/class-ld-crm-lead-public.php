<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://google.com
 * @since      1.0.0
 *
 * @package    Ld_Crm_Lead
 * @subpackage Ld_Crm_Lead/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ld_Crm_Lead
 * @subpackage Ld_Crm_Lead/public
 * @author     Lovedeep <Lovedeep5.abh@gmail.com>
 */
class Ld_Crm_Lead_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ld_Crm_Lead_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ld_Crm_Lead_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ld-crm-lead-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ld_Crm_Lead_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ld_Crm_Lead_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ld-crm-lead-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script($this->plugin_name , 'jsObject' , array(
		'ajax_url' => admin_url('admin-ajax.php'),

	));

	}

}

add_action('wp_ajax_lead_form_submission' , 'lead_form_submission');
add_action('wp_ajax_nopriv_lead_form_submission' , 'lead_form_submission');


function lead_form_submission(){

if(isset($_POST['data'])){
	
	// ****** IF TABLE NOT EXISTS (USUALLY FOR THE FIRST LEAD), IT WILL CREATE IT AUTOMATICALLY
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$sql = "CREATE TABLE IF NOT EXISTS `ld_crm_leads` ( `id` INT NOT NULL AUTO_INCREMENT , `lead_title` TEXT NOT NULL DEFAULT 'No Title' , `lead_owner` TEXT NOT NULL DEFAULT 'admin' , `lead_email` TEXT NOT NULL , `lead_phone` TEXT NOT NULL , `lead_status` TEXT NOT NULL , `lead_last_activity` TEXT NOT NULL , `lead_next_activity` TEXT NOT NULL , `lead_notes` LONGTEXT NOT NULL , `lead_time_stamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) $charset_collate";
	$wpdb->query($sql);

	$lead_title = htmlentities(trim($_POST['data'][0]['value']));
	$lead_owner = htmlentities(trim($_POST['data'][1]['value']));
	$lead_email = htmlentities(trim($_POST['data'][2]['value']));
	$lead_phone = htmlentities(trim($_POST['data'][3]['value']));
	$lead_status = htmlentities(trim($_POST['data'][4]['value']));
	$lead_last_activity = htmlentities(trim($_POST['data'][5]['value']));
	$lead_next_activity = htmlentities(trim($_POST['data'][6]['value']));
	$lead_notes = htmlentities(trim($_POST['data'][7]['value']));
	// var_dump($_POST['data']);

	// ****** Inserting New Data
	$new_lead_sql = "INSERT INTO `ld_crm_leads` (`id`, `lead_title`, `lead_owner`, `lead_email`, `lead_phone`, `lead_status`, `lead_last_activity`, `lead_next_activity`, `lead_notes`, `lead_time_stamp`) 
	VALUES (NULL, '$lead_title', '$lead_owner', '$lead_email', '$lead_phone', '$lead_status', '$lead_last_activity', '$lead_next_activity', '$lead_notes', current_timestamp())";

	$new_insert = $wpdb->query($new_lead_sql);
	if($new_insert == true){
		$response = array(
		'status' => '200',
		'message' => 'New Lead Added.'
	);
	$json_response = json_encode($response);
	echo $json_response;
	
	// Sending email
	$data_for_email = array( 'phone' => $lead_phone, 'email' => $lead_email, 'notes' => $lead_notes);
	$json_data_for_email = json_encode($data_for_email);

	sendEmailToAdmin($json_data_for_email);
	sendEmailToUser($lead_email);

	} else {
		$response = array(
		'status' => '401',
		'message' => 'Not able to insert lead, Try Again'
	);
	$json_response = json_encode($response);
	echo $json_response;
	}

} else {
	$response = array(
		'status' => '404',
		'message' => 'Data not captured'
	);
	$json_response = json_encode($response);
	echo $json_response;
}
wp_die();

}


function crm_lead_form_def(){
	$lead_form = '<div class="ld-form-wrapper">
        <div class="form">
            <div class="inner">
                <form id="ldCrmLeadForm" >
                    <div class="input-container">
                        <label for="leadTitle">Lead Title<em>*</em></label>
                        <input type="text" name="leadTitle" id="leadTitle" required>
                    </div>
                    <div class="input-container">
                        <label for="leadOwner">Lead Owner<em>*</em></label>
                        <input type="text" name="leadOwner" id="leadOwner" required>
                    </div>
                    <div class="input-container">
                        <label for="leadEmail">Email<em>*</em></label>
                        <input type="email" id="leadEmail" name="leadEmail" required>
                    </div>
                    <div class="input-container">
                        <label for="leadPhone">Phone<em>*</em></label>
                        <input type="tel" name="leadPhone" required>
                    </div>
                    <div class="input-container">
                        <label for="leadStatus">Lead Status</label>
                        <select name="leadStatus" id="leadStatus">
                            <option value="newLead"> New Lead</option>
                            <option value="existingLead"> Existing Lead</option>
                            <option value="otherLead"> Other </option>
                        </select>
                    </div>
                    <div class="input-container">
                        <label for="leadLastActivityDate">Date of Last Activity</label>
                        <input type="date" name="leadLastActivityDate" id="leadLastActivityDate">
                    </div>
                    <div class="input-container">
                        <label for="leadNextActivityDate">Date of Last Activity</label>
                        <input type="date" name="leadNextActivityDate" id="leadNextActivityDate">
                    </div>
                    <div class="input-container">
                        <label for="leadNotes">Notes</label>
                        <textarea name="leadNotes" id="leadNotes" cols="30" rows="2"></textarea>
                    </div>
                    <div class="submit-container">
					
                        <button type="submit" class="submit-btn-primary"> Submit </button>
						<img class="loading-icon" src="'.get_site_url().'/wp-content/plugins/ld-crm-lead/images/loading.gif" alt="loading-image">
						<input type="hidden" value="" class="ld_lead_id">
						<input type="hidden" value="" class="ld_lead_action">
                    </div>
					<div class="ld-lead-result"></div>
                </form>
            </div>
        </div>
    </div>';
    return $lead_form;
};
add_shortcode('crm_lead_form' , 'crm_lead_form_def');

// SENDING EMAILS

function sendEmailToAdmin($email_data){
	$decoded_message = json_decode($email_data);
	$subject = "New Lead Submmitted!!";
	$to = get_option('admin_email');
	$messageBody = "<p>Hello</p>";
	$messageBody .= "<p>A New Lead Submitted, With Following Details:</p>";
	$messageBody .= "<br />Email: ".$decoded_message->email;
	$messageBody .= "<br />Phone: ".$decoded_message->phone;
	$messageBody .= "<br />Notes: ".$decoded_message->notes;
	$headers = array('Content-Type: text/html; charset=UTF-8');
	wp_mail($to , $subject, $messageBody, $headers);
	return true;
};
function sendEmailToUser($to){
	$subject = "Thank you for submitting contact!!";
	$headers = array('Content-Type: text/html; charset=UTF-8');

	$message = "<p>Hello</p>";
	$message .= "<p>Dear user, thank you for showing intrest</p>";
	$message .= "<p>We will get back to you asap, or you can call Lovedeep at 9646077117.</p>";
	$message .= "<br />This plugin, created for machine test!! 😍";


	wp_mail($to , $subject, $message, $headers);
	return true;
}