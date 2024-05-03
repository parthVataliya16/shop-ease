$(document).ready(function() {
    $(".loader").hide();
    $("#sendMail").on("click", function(event) {
        event.preventDefault();
        $(".loader").show();
        $.ajax({
            method: 'POST',
            url: '/project/routes/web.php/v1/forgotPassword',
            data: {
                email: document.getElementById("email").value
            },
            success: function(result) {
                $(".loader").hide();
                $(".mailSend").css("display", "block");
                $("#text").text("If the email is associated with a personal user account, a password reset link has been sent to your email address.");
                $("#loading").css("display", "none");
                $("#form").css("display", "flex");
            }
        });
    });
});
