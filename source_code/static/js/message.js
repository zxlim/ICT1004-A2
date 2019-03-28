/**
* message.js
*
* Client-side calls to FastTrade Message API.
*/

$(document).ready(function() {
	const API_URL = "messageAPI.php";
	var form_data = "id=" + $("#item_id").val();
	
	$.post(API_URL, form_data, function(response, status) {
		for (var i = 0; i < response.length; i++) {
			// TODO
		}
	}, "json").fail(function(response) {
		// Something went wrong.
		console.log("An error has occured: " + response.status);
	});
});