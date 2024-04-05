<?php
class AddAddress extends Connection
{
    private $status, $message;

    public function __construct()
    {
        parent::__construct();
    }

    public function addAddress()
    {
        try {
            $user = $_SESSION['user'];
            $street = $_POST['street'];
            $town = $_POST['town'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $pincode = $_POST['pincode'];
            $selectUserQuery = $this->connection->query("SELECT id from users where user_name = '$user' || email_id = '$user'");

            if ($selectUserQuery->num_rows) {
                $row = $selectUserQuery->fetch_assoc();
                $id = $row['id'];
                $address = $this->connection->prepare("INSERT into addresses (street, town, city, state, pincode, user_id) values (?, ?, ?, ?, ?, ?)");
                $address->bind_param("ssssii", $street, $town, $city, $state, $pincode, $id);
                if ($address->execute()) {
                    $this->status = 200;
                    $this->message = "New Address added successfully!";
                } else {
                    $this->status = 400;
                    $this->message = "Address not added";
                }
            } else {
                $this->status = 400;
                $this->message = "No user found!";
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("AddAddress.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'message' => $this->message
            ];
            return json_encode($response);
        }
    }
}

?>