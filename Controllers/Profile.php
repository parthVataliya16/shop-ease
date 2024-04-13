<?php
class Profile extends Connection
{
    private $status;

    public function __construct()
    {
        parent::__construct();
    }

    public function profile()
    {
        try {
            $profile = [];
            $userName = $_SESSION['user'];
            $profileQuery = $this->connection->query("SELECT first_name, last_name, email_id, phone_number, gender from users where email_id = '$userName' || user_name = '$userName'");
            if ($profileQuery->num_rows) {
                $row = $profileQuery->fetch_assoc();
                array_push($profile, $row);
                $this->status = 200;
            } else {
                $this->status = 400;
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            error("Profile.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'profile' => $profile
            ];
            header ("content-type: application/json");
            return json_encode($response);
        }
    }
}

?>