$(document).ready(function() {
    $("#sendMail").on("click", function() {
        $("#forgotPasswordForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email: {
                    required: "Email is required!",
                    email: "Enter a valid email address!"
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    method: 'POST',
                    url: '/practice/project/routes/web.php/v1/forgotPassword',
                    data: {
                        email: document.getElementById("email").value
                    },
                    success: function(result) {
                        console.log(result);
                        $(".mailSend").css("display", "block");
                        $("#text").text("If the email is associated with a personal user account, a password reset link has been sent to your email address.");
                        $("#loading").css("display", "none");
                        $("#form").css("display", "flex");
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr, status, error);
                        // Handle errors here, e.g., show a message to the user
                    }
                });
            }
        });
    });
});
