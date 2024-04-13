<?php
class Address extends Connection
{
    private $status, $message;

    public function __construct()
    {
        parent::__construct();
    }

    public function address($id = 0) {
        try {
            $addressesArr = [];
            $user = $_SESSION['user'];
            if ($id) {
                $selectUserAddressQuery = $this->connection->query("SELECT addresses.id, street, town, city, state, pincode from addresses inner join users where (users.user_name = '$user' || users.email_id = '$user') && addresses.id = $id");
            } else {
                $selectUserAddressQuery = $this->connection->query("SELECT addresses.id, street, town, city, state, pincode from addresses inner join users where users.user_name = '$user' || users.email_id = '$user'");
            }
            if ($selectUserAddressQuery->num_rows) {
                while ($row = $selectUserAddressQuery->fetch_assoc()) {
                    array_push($addressesArr, $row);
                }
                $this->status = 200;
                $this->message = "Get all addresses of user";
            } else {
                $this->status = 400;
                $this->message = "No address found!";
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("Addresses.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'message' => $this->message,
                'address' => $addressesArr
            ];
            header('content-type: application/json');
            return json_encode($response);
        }
    }
}

?>