<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://google.com
 * @since      1.0.0
 *
 * @package    Ld_Crm_Lead
 * @subpackage Ld_Crm_Lead/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ld_Crm_Lead
 * @subpackage Ld_Crm_Lead/admin
 * @author     Lovedeep <Lovedeep5.abh@gmail.com>
 */
class Ld_Crm_Lead_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ld-crm-lead-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ld-crm-lead-admin.js', array( 'jquery' ), $this->version, false );

		wp_localize_script($this->plugin_name , 'ajaxObject', array(
			'ajax_url' => admin_url('admin-ajax.php')
		) );

	}

}

define('LEAD_TABLE' , 'ld_crm_leads');

add_action( 'admin_menu', 'register_my_custom_menu_page' );
function register_my_custom_menu_page() {
  // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
  add_menu_page( 'CRM Leads', 'CRM Leads', 'manage_options', 'custom_page', 'crm_lead_page', 'dashicons-welcome-widgets-menus', 90 );
  
}

function crm_lead_page(){
	
	global $wpdb;
	$leadQuery = "SELECT * FROM `ld_crm_leads`";
	$leadData = $wpdb->get_results($leadQuery);
	if($leadData == true){

	?>

<div class="ld-lead-list-wrapper">
	
	<div class="ld-lead-list">
		<div class="ld-lead-list-title">
			<h2>CRM Leads List</h2>
		</div>
		<table>
			<thead>
				<tr>
					<td>Lead Title</td>
					<td>Lead Owner</td>
					<td>Email</td>
					<td>Phone</td>
					<td>Status</td>
					<td>Last Activity Date</td>
					<td>Next Activity Date</td>
					<td>Notes</td>
					<td>Actions</td>
				</tr>
			</thead>
			<tbody>
				
			<?php foreach($leadData as $lead){ //Loop starts here ?>
				<tr>
					<td> <?php echo $lead->lead_title; ?> </td>
					<td><?php echo $lead->lead_owner ?></td>
					<td><?php echo $lead->lead_email ?></td>
					<td><?php echo $lead->lead_phone ?></td>
					<td><?php echo $lead->lead_status ?></td>
					<td><?php echo $lead->lead_last_activity ?></td>
					<td><?php echo $lead->lead_next_activity ?></td>
					<td><?php echo $lead->lead_notes ?></td>
					<td>
						<button class="ld-remove-lead" data-id="<?php echo $lead->id; ?>">Remove</button>
						<button class="ld-edit-lead" data-id="<?php echo $lead->id; ?>">Edit</button>
				</td>
			</tr>
					
			<?php } 
			}else {
				echo "<h2>No Leads Submitted Yet!!</h2>";} //Closting Loop here ?>
			</tbody>
		</table>
		<p><small>Note: This list will showup on 992 and larger screen size!!</small></p>
	</div>
</div>
<div class="update-lead-form">
	<span class="close-button">X</span>
	<div class="ld-form-wrapper">
        <div class="form">
            <div class="inner">
                <form id="update_lead" >
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
                        <label for="leadPhone">Phone</label>
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
                    <input type="hidden" value="" name="update_lead_id" class="ld_lead_id">   
					<button type="submit" class="submit-btn-primary"> Submit </button>
						
                    </div>
					<div class="ld-lead-result"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
}

// REMOVE FUNCTION
add_action('wp_ajax_remove_crm_lead' , 'lead_remove');
add_action('wp_ajax_nopriv_remove_crm_lead' , 'lead_remove');

function lead_remove(){

if(isset($_POST['lead_id']))	
	global $wpdb;
	$lead_id = $_POST['lead_id'];
	
	$removeLead = $wpdb->delete( LEAD_TABLE , array( 'id' => $lead_id ) );
	if($removeLead == true ){
		$response = array(
			"status" => 200,
			"message" => "Lead Removed"
		);
		echo json_encode($response);

	} else {
		$response = array(
			"status" => 404,
			"message" => "Not Removed, Try Again!!"
		);
		echo json_encode($response);

	};
	wp_die();

}

// Getting Lead value
add_action('wp_ajax_get_lead_value' , 'get_lead_value');
add_action('wp_ajax_nopriv_get_lead_value' , 'get_lead_value');

function get_lead_value(){

	if(isset($_POST['lead_id'])){
		$lead_id = $_POST['lead_id'];

		global $wpdb;
		$leadQuery = "SELECT * FROM `ld_crm_leads` WHERE `id` = '$lead_id'";
		$leadData = $wpdb->get_results($leadQuery);


		$result = array(
			'lead_title' => $leadData[0]->lead_title,
			'lead_owner' => $leadData[0]->lead_owner,
			'lead_email' => $leadData[0]->lead_email,
			'lead_phone' => $leadData[0]->lead_phone,
			'lead_status' => $leadData[0]->lead_status,
			'lead_last_activity' => $leadData[0]->lead_last_activity,
			'lead_next_activity' => $leadData[0]->lead_next_activity,
			'lead_notes' => $leadData[0]->lead_notes
		);

		$jsonleadData = json_encode($result);
		echo $jsonleadData;
		


	}
	
	wp_die();
}


add_action("wp_ajax_lead_value_update" , "update_lead_value");
add_action("wp_ajax_no_priv_lead_value_update" , "update_lead_value");

function update_lead_value(){
	if(isset($_POST['data'])){
		// $form_data = $_POST['data'];


	$lead_title = htmlentities(trim($_POST['data'][0]['value']));
	$lead_owner = htmlentities(trim($_POST['data'][1]['value']));
	$lead_email = htmlentities(trim($_POST['data'][2]['value']));
	$lead_phone = htmlentities(trim($_POST['data'][3]['value']));
	$lead_status = htmlentities(trim($_POST['data'][4]['value']));
	$lead_last_activity = htmlentities(trim($_POST['data'][5]['value']));
	$lead_next_activity = htmlentities(trim($_POST['data'][6]['value']));
	$lead_notes = htmlentities(trim($_POST['data'][7]['value']));
	$lead_id = htmlentities(trim($_POST['data'][8]['value']));
	
	$update_Query = "UPDATE `ld_crm_leads` SET `lead_title` = '$lead_title', `lead_owner` = '$lead_owner', `lead_email` = '$lead_email', `lead_phone` = '$lead_phone', `lead_status` = '$lead_status', `lead_last_activity` = '$lead_last_activity', `lead_next_activity` = '$lead_next_activity', `lead_notes` = '$lead_notes' WHERE `ld_crm_leads`.`id` = '$lead_id'";
	global $wpdb;

	$update_data = $wpdb->query($update_Query);

	if($update_data == true) {
		$r = array ('status' => 200, 'message' => 'Lead Updated!');
		echo json_encode($r);
	} else {
		$r = array ('status' => 400, 'message' => 'Lead Not Updated!');
		echo json_encode($r);
	}

	
	
	}
	wp_die();
}