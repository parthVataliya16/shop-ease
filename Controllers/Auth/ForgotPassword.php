<?php

class ForgotPassword extends Connection
{
    private $status;
    private $message;
    private $sendMail;

    public function __construct()
    {
        parent::__construct();
        $this->sendMail = new SendMail();
    }

    public function forgotPassword()
    {
        try {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $token = bin2hex(random_bytes(16));
            $createdAt = date("Y-m-d H:i:s");
            $selectUser = $this->connection->query("SELECT id from users where email_id = '$email'");
            if ($selectUser->num_rows) {
                $result = $selectUser->fetch_assoc();
                $id = $result['id'];

                $insertTokenToResetPassword = $this->connection->prepare("INSERT into reset_passwords (token, user_id, created_at) values (?, ?, ?)");
                $insertTokenToResetPassword->bind_param("sis", $token, $id, $createdAt);
                $insertTokenToResetPassword->execute();

                $sendMailFrom = 'admin@gmail.com';
                $sendMailTo = $email;
                $subject = 'Reset password!';
                $body = "
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                    }
                    .container {
                        max-width: 600px;
                        margin: auto;
                        padding: 20px;
                    }
                    .btn {
                        display: inline-block;
                        padding: 10px 20px;
                        background-color: #007bff;
                        color: #fff;
                        text-decoration: none;
                        border-radius: 5px;
                    }
                    .btn:hover {
                        background-color: #0056b3;
                    }
                </style>
                <div class='container'>
                    <h2>Forgot Password</h2>
                    <p>Dear User,</p>
                    <p>We received a request to reset your password. Click the button below to reset your password:</p>
                    <p><a class='btn' href='http://localhost/project/views/auth/resetPassword.php?token=". $token ."'>Reset Password</a></p>
                    <p>If you did not request a password reset, you can safely ignore this email.</p>
                    <p>Best regards,<br>Shop ease Team</p>
                </div>";

                $this->sendMail->sendMail($sendMailFrom, $sendMailTo, $subject, $body);

                $this->status = 200;
                $this->message = "Mail send to user";
            } else {
                throw new Exception ("User not found!", 400);
            }

        } catch (Exception $error) {
            $this->status = 204;
            $this->message = $error->getMessage();
            error("ForgotPassword.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'message' => $this->message
            ];
            header("content-type: application/json");
            return json_encode($response);
        }
    }
}

?>