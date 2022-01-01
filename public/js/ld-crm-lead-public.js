(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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
		$('#ldCrmLeadForm').submit(async function (e) {
			e.preventDefault();
			$(".loading-icon").show();
			let formData = await $(this).serializeArray();
			$.post(jsObject.ajax_url, { 'action': 'lead_form_submission', 'data': formData }, function (r) {
				let response_data = JSON.parse(r);
				console.log(response_data);
				if (response_data.status == 200) {
					$(".ld-lead-result").append(`<p>${response_data.message}</p>`);
					$(".ld-lead-result").addClass('result')
					$("#ldCrmLeadForm")[0].reset();
					$(".loading-icon").hide();
					setInterval(function () {
						$(".ld-lead-result").removeClass('result');
						$(".ld-lead-result p").remove();
						
					}, 5000);
				}
			})
			
		})
	})//



})( jQuery );
