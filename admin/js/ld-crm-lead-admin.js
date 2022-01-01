(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(document).ready(function () {
			// REMOVE ENTIRES
		$(".ld-remove-lead").click(function () {
			let lead_id = $(this).attr('data-id');
			$.post(ajaxObject.ajax_url, { 'action': 'remove_crm_lead', 'lead_id': lead_id }, function (r) {
				let response = JSON.parse(r);
				alert(response.message);
				location.reload();
			})
		});
		// CLOSE BUTTON FOR UPDATE FORM
		$(".update-lead-form span.close-button").click(function () {
			$(".update-lead-form").hide();
		})

		// EDIT Lead 

		$(".ld-edit-lead").click(function () {
			let lead_id = $(this).attr('data-id');
			$(".ld_lead_id").val(lead_id);
			$.post(ajaxObject.ajax_url, { 'action': 'get_lead_value', 'lead_id': lead_id }, function (r) {
				let lead_data = JSON.parse(r);
				
				console.log(lead_data);
				$(".update-lead-form").show();
				$(".update-lead-form [name='leadTitle']").val(lead_data.lead_title);
				$(".update-lead-form [name='leadOwner']").val(lead_data.lead_owner);
				$(".update-lead-form [name='leadEmail']").val(lead_data.lead_email);
				$(".update-lead-form [name='leadPhone']").val(lead_data.lead_phone);
				$(".update-lead-form [name='leadStatus']").val(lead_data.lead_status);
				$(".update-lead-form [name='leadLastActivityDate']").val(lead_data.lead_last_activity);
				$(".update-lead-form [name='leadNextActivityDate']").val(lead_data.lead_next_activity);
				$(".update-lead-form [name='leadNotes']").val(lead_data.lead_notes);



			})
		})

		// UPDATING NEW VALUES
		$(".update-lead-form form").submit(function (e) {
			e.preventDefault();
			let form_data = $(this).serializeArray();
			$.post(ajaxObject.ajax_url, { 'action': 'lead_value_update', 'data': form_data }, function (r) {
				let response = JSON.parse(r);
				if (response.status == 200) {
					alert(response.message);
					location.reload();

				}

				if (response.status == 400) {
					alert(response.message);
				}
			})
		});		
		
		
		})

})( jQuery );
