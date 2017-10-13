
// Add a button to each var to load the revisions
$('#low-varlist .low-vargroup tbody td:first-child').append('<button class="hlvr-load-rev" type="button">Load revisions</button>');

// Add click listener to all of our Load buttons
$('.hlvr-load-rev').on('click',function(e){
	const $tdVar = $(this).parent();
	const varName = $tdVar.find('code').html();
	// Fetch the revisions list
	$.ajax({
		method: "GET",
		url: hlvrLoadUrl+'&var_name='+varName
	})
	.done(function(data) {
		// console.log(data);

		// Create a dropdown
		let dropdownHtml = jQuery('<select/>', {
			class: 'hlvr-show-rev',
		});
		dropdownHtml.append('<option value="">View Revision History</option>'); //default option
		// Add all revisions into the dropdown
		jQuery.each(data, function(idx, value){
			dropdownHtml.append('<option value="'+value.revision_id+'">'+value.revision_desc+'</option>');
		});

		// Add chagne listener to the dropdown
		dropdownHtml.on('change', function(e){
			// Open popup window (just like EE does for templates)
			if ($(this).val() != '') {
				window.open(EE.template.url + e, "Revision", "height=350, location=0, menubar=0, resizable=0, scrollbars=0, status=0, titlebar=0, toolbar=0, screenX=60, left=60, screenY=60, top=60");
			}
		});

		// Remove the Load Revisions button
		$tdVar.find('.hlvr-load-rev').remove();
		// Add our dropdown
		$tdVar.append(dropdownHtml);
	});
});