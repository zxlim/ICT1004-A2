$(document).ready(function() {
	$(".no-click, .no-click-pointer, .no-click-event").on("click touchend", function(e) {
		e.preventDefault();
		return false;
	})
})