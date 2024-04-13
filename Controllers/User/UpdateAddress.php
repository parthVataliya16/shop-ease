<?php
class UpdateAddress extends Connection
{
    private $status, $message;

    public function __construct()
    {
        parent::__construct();
    }

    public function updateAddress($id) {
        try {
            $street = $_POST['street'];
            $town = $_POST['town'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $pincode = $_POST['pincode'];

            $updateAddress = $this->connection->query("UPDATE addresses set street = '$street', town = '$town', city = '$city', state = '$state', pincode = '$pincode' where id = $id");
            if ($updateAddress) {
                $this->status = 200;
                $this->message = "Address updated successfully!";
            } else {
                $this->status = 400;
                $this->message = "Something went wrong!";
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("UpdateAddress.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'message' => $this->message
            ];
            header('content-type: application/json');
            return json_encode($response);
        }
    }
}

?>