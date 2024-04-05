import { tostifyBox } from "./functions.js";

$(document).ready(function() {
    $.ajax({
        method: 'GET',
        url: `/practice/Project/routes/web.php/v1/profile`,
        success: function (result) {
            console.log(result);
            if (result.status == 200) {
                $("#fname").val(result.profile[0].first_name);
                $("#lname").val(result.profile[0].last_name);
                $("#email").val(result.profile[0].email_id);
                $("#phoneNumber").val(result.profile[0].phone_number);

                const usergender = result.profile[0].gender;
                const gender = document.querySelectorAll("input[type='radio']");
                gender.forEach((value) => {
                    const gender = value.getAttribute("value");
                    if (usergender == gender) {
                        value.setAttribute("checked", "");
                        return;
                    }
                });

            }
        }
    });

    const updateProfile = $("#updateUser");
    updateProfile.click((event) => {
        $("#profile").validate({
            rules: {
                fname: {
                    required: true,
                    minlength: 3
                },
                lname: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    minlength: 5
                },
                phoneNumber: {
                    required: true,
                    minlength: 10,
                    maxlength: 10
                },
                gender: {
                    required: true
                }
            },
            message: {
                fname: {
                    required: "Please enter first name",
                    minlength: "Minimum length of first name must be 3"
                },
                lname: {
                    required: "Please enter last name",
                    minlength: "Minimum length of last name must be 3"
                },
                email: {
                    required: "Please enter email address",
                    minlength: "Minimum length of email address must be 3"
                },
                phoneNumber: {
                    required: "Please enter phone number",
                    minlength: "Minimum length of phone number must be 10",
                    maxlength: "Maximum length of phone number must be 10"
                },
                gender: {
                    required: "Please select gender"
                }
            },
            submitHandler: function() {
                event.preventDefault();
                $.ajax({
                    method: "POST",
                    url: `/practice/Project/routes/web.php/v1/update`,
                    data: {
                        firstName: $("#fname").val(),
                        lastName: $("#lname").val(),
                        email: $("#email").val(),
                        phoneNumber: $("#phoneNumber").val(),
                        gender: $("input[type='radio']").val()
                    },
                    success: function(result) {
                        if (result.status == 200) {
                            tostifyBox("Profile updated successfully!", "linear-gradient(#7e49e5, #a0dfff)")
                        } else {
                            tostifyBox("Something went wrong!", "linear-gradient(to right, #f6d365 0%, #fda085 51%, #f6d365 100%)");
                        }
                    }
                })
            }
        })
    })
})