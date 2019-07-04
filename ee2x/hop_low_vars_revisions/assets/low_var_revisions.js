
// Add a button to each var to load the revisions
$('#low-varlist .low-vargroup > tbody >tr > td:first-child').append('<button class="hlvr-load-rev" type="button">Load revisions</button>');

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
			class: 'hlvr-list-rev'
		});
		dropdownHtml.append('<option value="">View Revision History</option>'); //default option
		// Add all revisions into the dropdown
		jQuery.each(data, function(idx, value){
			dropdownHtml.append('<option value="'+value.revision_id+'">'+value.revision_desc+'</option>');
		});

		// Create a button
		let buttonHTML = jQuery('<button/>', {
			class: 'hlvr-show-rev',
			type: 'button'
		});
		buttonHTML.append('Show');

		// Add click listener to our button
		buttonHTML.on('click', function(e){
			// Open popup window (just like EE does for templates)
			if ($(this).prev().val() != '') {
				window.open(hlvrShowUrl + '&rev_id=' + $(this).prev().val(), "Revision")
			}
		});

		// Remove the Load Revisions button
		$tdVar.find('.hlvr-load-rev').remove();
		// Add our dropdown
		$tdVar.append(dropdownHtml);
		// Add our button
		$tdVar.append(buttonHTML);
	});
});