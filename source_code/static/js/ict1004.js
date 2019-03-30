/**
* ict1004.js
*
* Contains useful functions for use in FastTrade.
*/

function HtmlSpecialChars(str) {
	/**
	* Encodes certain characters into HTML entities.
	* A layer to reduce success rates of XSS attacks.
	*/
	const entities = {
		"&": "&amp;",
		"<": "&lt;",
		">": "&gt;",
		'"': "&quot;",
		"'": "&#39;",
		"/": "&#x2F;",
		"`": "&#x60;",
		"=": "&#x3D;"
	};

	return String(str).replace(/[&<>"'`=\/]/g, function(c) {
		return entities[c];
	});
}

$(document).ready(function() {
	$(".no-click, .no-click-pointer, .no-click-event").on("click touchend", function(e) {
		e.preventDefault();
		return false;
	})
})