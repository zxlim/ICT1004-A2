/**
* ftmessage_api.js
*
* Client-side calls for FastTrade Messenger API.
*/

function log_debug(msg) {
	/**
	* For development use only.
	* Logs message to console with `[DEBUG]` tag.
	*/
	const enable_debug = false;
	if (enable_debug === true && msg !== null && msg.trim().length !== 0) {
		console.log("[DEBUG] " + String(msg));
	}
}


class FastTradeMessenger {
	constructor(convo_id, sender_id) {
		this.api_url = "messageAPI.php";
		this.convo_id = Number(convo_id);
		this.sender_id = Number(sender_id);
		this.count = 0;
	}

	set_sent_status(value) {
		this.sent = Boolean(value);
	}

	increment_count(value) {
		this.count += Number(value);
	}

	reset_count() {
		this.count = 0;
	}

	fetch(scroll, once) {
		/**
		* @param	scroll	Boolean		Whether to scroll after fetching new messages.
		* @param	once	Boolean		True if function call is not a routine.
		*/
		scroll = Boolean(scroll) || false;
		once = Boolean(once) || false;

		var response_len = 0;
		const FTMsg = this;
		const ctr = this.count;
		const form_data = "id=" + this.convo_id + "&ctr=" + ctr;

		$.ajax({
			async: true,
			data: form_data,
			dataType: "json",
			method: "GET",
			url: this.api_url,
			success: function(response) {
				// Success event.
				response_len = Number(response.data.length);

				if (ctr === 0 && response_len !== 0) {
					$(".message-content").text("");
				}

				for (var i = 0; i < response_len; i++) {
					let m = response.data[i];
					let m_sender_id = Number(m.sender_id);
					let m_msg = String(m.data);
					let m_dt = String(m.datetime);
					let m_r = Boolean(m.read);

					var m_notice = m_notice = "<div class='ftmsg ftmsg-sender p-3 shadow'>";
					var m_read = "";

					if (m_sender_id === FTMsg.sender_id) {
						// Message belongs to current user.
						if (m_r === true) {
							// Read receipts.
							m_notice = "<div class='ftmsg ftmsg-sender p-3 shadow' title='Message seen by recipient.'>";
							m_read = "<span class='msg-read' title='Message seen by recipient.'><i class='fas fa-check'></i></span>";
						}

						$(".message-content").append(
							"<div class='row top-margin'>" +
							"<div class='col-md-7 col-2'></div>" +
							"<div class='col-md-5 col-10'>" +
							m_notice +
							"<div class='row'><div class='col-12'>" +
							m_msg +
							"</div></div>"+
							"<div class='row'><div class='col-12 msg-datetime'>" +
							m_dt + m_read +
							"</div></div>"+
							"</div></div></div>"
						);
					} else {
						// Message belongs to other user.
						$(".message-content").append(
							"<div class='row top-margin'>" +
							"<div class='col-md-5 col-10'>" +
							"<div class='ftmsg ftmsg-receiver p-3 shadow'>" +
							"<div class='row'><div class='col-12'>" +
							m_msg +
							"</div></div>"+
							"<div class='row'><div class='col-12 msg-datetime'>" +
							m_dt +
							"</div></div>"+
							"</div></div><div class='col-md-7 col-2'></div></div>"
						);
					}
				}

				if (response_len !== 0) {
					if (scroll === true) {
						FTMsg.scroll();
					} else if ($(".message-scroller").is(":hidden")) {
						log_debug("Showing scroller");
						/* Hacky way for "pulse" effect with pure jQuery. */
						$(".message-scroller").fadeIn(500, function() {
							$(".message-scroller").fadeOut(250, function() {
								$(".message-scroller").fadeIn(1000);
							})
						});
					}
				}

				log_debug("Fetched " + response_len + " messages.");
				FTMsg.increment_count(response_len);
			},
			error: function(response) {
				// Error event.
				log_debug("HTTP Status Code: " + response.status);
				log_debug("Message: " + response.responseJSON.message);
			},
			complete: function(response) {
				if (once === false) {
					setTimeout(function() {
						log_debug("Auto-reloading messages...");
						FTMsg.fetch();
					}, 1000 * 2);
				} else {
					log_debug("Not a routine call.");
				}
			}
		});
	}

	refetch_all() {
		/**
		* Clears the message listing UI and attempts to
		* retrieve all messages for the current conversation.
		*/
		log_debug("Refetch initiated.");
		$(".message-content").html("<h3 class='text-center vertical-align-middle'>No messages yet, start chatting.</h3>");
		this.reset_count();
		this.fetch();
	}

	scroll() {
		/**
		* Scroll to the latest message.
		*/
		$(".message-list").animate({
			scrollTop: $(".message-list").prop("scrollHeight")
		}, 1000);
	}

	send(form_data) {
		const FTMsg = this;

		$.ajax({
			method: "POST",
			url: this.api_url,
			data: form_data,
			dataType: "json",
			success: function(response) {
				// Success event.
				FTMsg.fetch(true, true);
				log_debug("Message sent successfully.");
			},
			error: function(response) {
				// Error event.
				log_debug("HTTP Status Code: " + response.status);
				log_debug("Message: " + response.responseJSON.message);
				if (response.status === 428) {
					notify(response.responseJSON.message, "warning");
				}
			}
		});
	}
}

$(document).ready(function() {
	if ($("#item_id").val() !== null && $("#sender_id").val() !== null) {
		const FTMsg = new FastTradeMessenger($("#convo_id").val(), $("#sender_id").val());
		FTMsg.fetch(true);

		// Event listeners.
		$("#form-message").on("submit", function(event) {
			event.preventDefault();

			if (validate_form_notempty($(this).serializeArray()) === false) {
				notify("Your message cannot be empty.", "warning");
			} else {
				FTMsg.send($(this).serialize());
			}

			$("#msg_data").val("");
			return false;
		});

		$(".message-scroller").on("click", function(event) {
			FTMsg.scroll();
			$(".message-scroller").fadeOut(500);
		})
	} else {
		log_debug("Unable to retrieve required parameters.");
	}
});
