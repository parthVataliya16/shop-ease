<?php
class UpdateProfile extends Connection
{
    private $status;

    public function __construct()
    {
        parent::__construct();
    }

    public function updateProfile()
    {
        try {
            $userName = $_SESSION['user'];
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $phoneNumber = $_POST['phoneNumber'];
            $gender = $_POST['gender'];

            $updateProfileQuery = $this->connection->query("UPDATE users set first_name = '$firstName', last_name = '$lastName', email_id = '$email', phone_number = $phoneNumber, gender = '$gender' where email_id = '$userName' || user_name = '$userName' ");
            if ($updateProfileQuery) {
                $this->status = 200;
            } else {
                $this->status = 400;
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            error("UpdateProfile.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
            ];

            header("content-type: application/json");
            return json_encode($response);
        }
    }
}

?>