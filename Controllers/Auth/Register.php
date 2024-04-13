<?php
class Register extends Connection
{
    protected $status;
    protected $message;

    public function __construct()
    {
        parent::__construct();
    }

    public function register()
    {
        try {
            $fisrtName = $_POST['fname'];
            $lastName = $_POST['lname'];
            $email = $_POST['email'];
            $phoneNumber = $_POST['phoneNumber'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $gender = $_POST['gender'];
            $role = 'user';
            $createdAt = date("Y-m-d H:i:s");
            $lengthOfEmail = strlen($email);

            for ($i = 0; $i < $lengthOfEmail; $i++) {
                if ($email[$i] == '@') {
                    $userName = substr($email, 0, $i);
                    break;
                }
            }
            $addUser = $this->connection->prepare("
            INSERT INTO users(first_name, last_name, email_id, user_name, password, phone_number, role, gender, created_at) 
            values (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $addUser->bind_param("sssssisss", $fisrtName, $lastName, $email, $userName, $password, $phoneNumber, $role, $gender, $createdAt);
            $addUser->execute();
            $_SESSION['user'] = $userName;
            $this->status = 201;
            $this->message = "User register successfully!";
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("Register.php", $error->getCode(), $error->getMessage(), $error->getLine());
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
