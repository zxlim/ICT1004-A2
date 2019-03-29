/**
* message.js
*
* Client-side calls to FastTrade Message API.
*/

class FastTradeMessage {
	constructor(convo_id, sender_id) {
		this.api_route = "messageAPI.php";
		this.convo_id = Number(convo_id);
		this.sender_id = Number(sender_id);
		this.count = 0;
	}

	update_count(value) {
		this.count = Number(value);
	}

	fetch() {
		let FTMsg = this;
		var ctr = this.count;
		var form_data = "action=get&id=" + this.convo_id;

		$.post(this.api_route, form_data, function(response, status) {
			// Success.
			for (ctr; ctr < response.data.length; ctr++) {
				let m = response.data[ctr];
				let m_sender_id = Number(m.sender_id);
				let m_msg = String(m.data);
				let m_dt = String(m.datatime);

				if (ctr === 0) {
					$(".message-content").text("");
				}

				if (m_sender_id === FTMsg.sender_id) {
					// Message belongs to current user.
					$(".message-content").append(
						"<div class='row top-margin'>" +
						"<div class='col-md-7 col-2'></div>" +
						"<div class='col-md-5 col-10'>" +
						"<div class='ftmsg ftmsg-sender p-3 shadow'>" +
						m_msg +
						"</div></div></div>"
					);
				} else {
					// Message belongs to other user.
					$(".message-content").append(
						"<div class='row top-margin'>" +
						"<div class='col-md-5 col-10'>" +
						"<div class='ftmsg ftmsg-receiver p-3 shadow'>" +
						m_msg +
						"</div></div>" +
						"<div class='col-md-7 col-2'></div></div>"
					);
				}
			}

			FTMsg.update_count(response.data.length);
		}).fail(function(response) {
			// Something went wrong.
			console.log("[!] Unable to retrieve messages.");
			console.log("[DEBUG] HTTP Status Code: " + response.status + "\n[DEBUG] Message: " + response.responseJSON.message);
		});
	}

	send(form_data) {		
		let FTMsg = this;

		$.post(this.api_route, form_data, function(response, status) {
			// Success.
			FTMsg.fetch();
			return true;
		}).fail(function(response) {
			// Something went wrong.
			console.log("[!] Unable to send message.");
			console.log("[DEBUG] HTTP Status Code: " + response.status + "\n[DEBUG] Message: " + response.responseJSON.message);
			return false;
		});
	}
}

$(document).ready(function() {
	if ($("#item_id").val() !== null && $("#sender_id").val() !== null) {
		const msg = new FastTradeMessage($("#convo_id").val(), $("#sender_id").val());
		msg.fetch();

		setInterval(function() {
			console.log("[DEBUG] Auto-reloading messages...");
			msg.fetch();
		}, (1000 * 5));

		// Event listener.
		$("#form-message").on("submit", function(event) {
			event.preventDefault();
			msg.send($(this).serialize())
			$("#msg_data").val("");
			return false;
		});
	} else {
		console.log("[!] Unable to retrieve required parameters.");
	}
});
