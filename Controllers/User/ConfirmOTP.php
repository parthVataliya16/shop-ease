<?php
class ConfirmOTP extends Connection
{
    private $status, $message;

    public function __construct()
    {
        parent::__construct();
    }

    public function confirmOTP()
    {
        try {
            $user = $_SESSION['user'];
            $enterOTP = $_POST['enterOTP'];

            $selectUserQuery = $this->connection->query("SELECT id from users where email_id = '$user' || user_name = '$user'");
            if ($selectUserQuery->num_rows) {
                $userID = $selectUserQuery->fetch_assoc();
                $userID = $userID['id'];
                
                $selectOTPDataQuery = $this->connection->query("SELECT otp, created_at from confirm_order_otps where user_id = $userID");
                if ($selectOTPDataQuery->num_rows) {
                    $row = $selectOTPDataQuery->fetch_assoc();
                    $otp = $row['otp'];
                    $createdAt = new DateTime($row['created_at']);
                    $currentTime = new DateTime();

                    $interval = $createdAt->diff($currentTime);
                    $minutes = $interval->days * 24 * 60; 
                    $minutes += $interval->h * 60; 
                    $minutes += $interval->i;

                    if ($minutes < 10) {
                        if ($otp == $enterOTP) {
                            $this->connection->query("DELETE from confirm_order_otps where user_id = $userID");
                            $this->status = 200;
                            $this->message = "OTP successfully verified";
                        } else {
                            $this->status = 400;
                            $this->message = "OTP invalid!";
                        }
                    } else {
                        $this->status = 400;
                        $this->message = "OTP expired!";
                    }
                } else {
                    $this->status = 400;
                    $this->message = "OTP invalid!";
                }
            } else {
                $this->status = 400;
                $this->message = "No user found!";
            }
        } catch (Exception $error) {
            error("ConfirmOTP.php", $error->getCode(), $error->getMessage(), $error->getLine());
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