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
            $userEmailQuery = $this->connection->query("SELECT id, email_id from users where email_id = '$user' || user_name = '$user'");
            $user = $userEmailQuery->fetch_assoc();
            $userEmail = $user['email_id'];
            $userID = $user['id'];
            $createAT = date("Y-m-d H:i:s");

            $selectUserDataInOTPQuery = $this->connection->query("SELECT id from confirm_order_otps where user_id = $userID");
            if ($selectUserDataInOTPQuery->num_rows) {
                $this->connection->query("DELETE from confirm_order_otps where user_id = $userID");
            }

            $this->connection->query("INSERT into confirm_order_otps (user_id, otp, created_at) values ($userID, $otp, '$createAT')");

            $sendMailFrom = $adminEmail;
            $sendMailTo = $userEmail;
            $subject = 'OTP Confirmation For Order Place';
            $body = "<h5>Your OTP is:</h5>";
            $body .= "<p>$otp</p>";
            $body .= "<p>OTP is valid for 10 minutes.</p>";

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