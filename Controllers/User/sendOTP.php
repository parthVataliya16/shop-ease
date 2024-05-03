<?php
class SendOTP extends Connection
{
    private $status, $sendMail;

    public function __construct()
    {
        parent::__construct();
        $this->sendMail = new SendMail();
    }

    public function sendOTP()
    {
        try {
            $otp = rand(100000,999999);
            $selectAdminEmailQuery = $this->connection->query("SELECT email_id from users where id = 1");
            $adminEmail = $selectAdminEmailQuery->fetch_assoc();
            $adminEmail = $adminEmail['email_id'];

            $user = $_SESSION['user'];
            $userEmailQuery = $this->connection->query("SELECT id, email_id, first_name from users where email_id = '$user' || user_name = '$user'");
            $user = $userEmailQuery->fetch_assoc();
            $userEmail = $user['email_id'];
            $name = $user['first_name'];
            $userID = $user['id'];
            $createAT = date("Y-m-d H:i:s");

            $selectUserDataInOTPQuery = $this->connection->query("SELECT id from confirm_order_otps where user_id = $userID");
            if ($selectUserDataInOTPQuery->num_rows) {
                $this->connection->query("DELETE from confirm_order_otps where user_id = $userID");
            }

            $this->connection->query("INSERT into confirm_order_otps (user_id, otp, created_at) values ($userID, $otp, '$createAT')");

            $sendMailFrom = $adminEmail;
            $sendMailTo = $userEmail;
            $subject = 'OTP Verification For Order Place';
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
                .otp-container {
                    background-color: #f4f4f4;
                    padding: 10px;
                    border-radius: 5px;
                    text-align: center;
                }
                .otp {
                    font-size: 24px;
                    font-weight: bold;
                }
            </style>
            <div class='container'>
                <p>Hello $name,</p>
                <p>Your OTP for verification is:</p>
                <div class='otp-container'>
                    <span class='otp'>$otp</span>
                </div>
                <p>Please use this OTP to verify your identity.</p>
                <p>If you didn't request this OTP, please ignore this email.</p>
                <p>Best regards,<br>Shop ease Team</p>
            </div>";

            $this->sendMail->sendMail($sendMailFrom, $sendMailTo, $subject, $body);

            $this->status = 200;
        } catch (Exception $error) {
            error("SendOTP.php", $error->getLine(), $error->getMessage(), $error->getLine());
        } finally {
            return $this->status;
        }
    }
}

?>