<?php
session_start();

class Login extends Connection
{
    protected $status, $message;

    function __construct()
    {
        parent::__construct();
    }

    function login()
    {
        try {
            $userArr = [];
            $userName = $_POST['userName'];
            $password = $_POST['password'];
            $user = $this->connection->query("SELECT password, role from users where email_id = '$userName' || user_name = '$userName'");

            if ($user->num_rows) {
                $row = $user->fetch_assoc();
                $userPassword = $row['password'];
                if (password_verify($password, $userPassword)) {
                    array_push($userArr, $row);
                    $_SESSION['user'] = $userName;
                    $this->status = 200;
                    $this->message = "Login successfully!";
                }
            } else {
                $this->status = 400;
                $this->message = "User not found!";
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("Login.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $responseArr = [
                'status' => $this->status,
                'message' => $this->message
            ];

            $response = [
                'response' => $responseArr,
                'user' => $userArr
            ];
            header("content-type: application/json");
            return json_encode($response);
        }
    }
}

?>