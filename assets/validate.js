// ------------------contact us----------------------
  $(document).ready(function() {
    $('#contact_us').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
		     
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
        },
        fields: {
            name: {
                validators: {
                        stringLength: {
                        min: 3,
                    },
                        notEmpty: {
                        message: 'Please enter your full name'
                    }
                }
            },
            phone: {
                validators: {
                    notEmpty: {
                        message: 'Please enter your phone number'
                    },
                    phone: {
                        country: 'INDIA',
                        message: 'Please enter a vaild phone number'
                    }
                }
            },
			email: {
				validators: {
					notEmpty: {
						message: 'Please enter your email address'
					},
					emailAddress: {
						message: 'Please enter a valid email address'
					}
				}
            },
			subject: {
                validators: {
                     stringLength: {
                        min: 3,
                    },
                    notEmpty: {
                        message: 'Please enter your subject'
                    }
                }
            },
			 description: {
                validators: {
                        stringLength: {
                        min: 15,
                    },
                        notEmpty: {
                        message: 'Please enter your message here minimum 15 words'
                    }
                }
            },
			}
        })
 // when the form is submitted
    $('#contact_us').on('submit', function (e) {
		// if the validator does not prevent form submit
		if (!e.isDefaultPrevented()) {
            var url = "contact.php";
			// POST values in the background the the script URL
			$.ajax({
                type: "POST",
                url: url,
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
                success: function (data)
                {
				     // data = JSON object that contact.php returns
					// we recieve the type of the message: success x danger and apply it to the 
                    var messageAlert = 'alert-' + data.type;
                    var messageText = data.message;
					// let's compose Bootstrap alert box HTML
					var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';
                    // If we have messageAlert and messageText
                    if (messageAlert && messageText) {
                        // inject the alert to .messages div in our form
                        $('#contact_us').find('.messages').html(alertBox);
                      $('#contact_us').bootstrapValidator('resetForm', true);
					  setTimeout(function() {
						 top.location = "contact_us.html";
					}, 
						3000);
					}
                }
            });
            return false;
        }
    })
});