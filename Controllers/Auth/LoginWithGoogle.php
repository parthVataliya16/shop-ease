<?php
use Dotenv\Dotenv;

require("./../../vendor/autoload.php");
$dotenv = Dotenv::createImmutable('./../../');
$dotenv->load();

$googleCredentials = include('./../../config/google.php');
$database = include('./../../config/database.php');

require_once './../../services/googleService.php';
require_once './../Connection.php';

class LoginWithgoogle extends Connection
{
    private $status, $message, $loginWithGoogle, $mail;

    public function __construct()
    {
        parent::__construct();
        $this->loginWithGoogle = new LoginWithGoogleService();
        // $this->mail = new SendMail();
    }

    public function loginWithgoogle()
    {
        try {
            session_start();
            // if (isset($_SESSION['user'])) {
            //     require_once __DIR__ . './../../middleware/checkRole.php';
            // }
            $code = $_GET['code'];
            if (isset($code)) {
                $userData = $this->loginWithGoogle->getAccessTokenFromAuthCode($code);    
                $email = $userData['email'];
                $selectUser = $this->connection->query("SELECT id from users where email_id = '$email'");

                $familyName = $userData['familyName'];
                $givenName = $userData['givenName'];
                $gender = $userData['gender'];
                // $profilePicture = $userData['picture'];
                // $imageName = time();
                $userName = explode('@', $email)[0];

                // $image = file_get_contents($profilePicture);
                // $uploadImage = './../../public/uploads/';
                // file_put_contents($uploadImage . $imageName, $image);

                if ($selectUser->num_rows) {
                    $updatedAt = date('Y-m-d');
                    $this->connection->query("UPDATE users set first_name = '$givenName', last_name = '$familyName', gender = '$gender', updated_at = '$updatedAt', user_name = '$userName' where email_id = '$email'");

                    $_SESSION['user'] = $userName;
                    header('location: ./../../views/users/index.php');
                    exit;

                    // $result = $selectUser->fetch_assoc();
                    // // $profilePicture = $result['profile_picture'];
                    // // unlink($uploadImage . $profilePicture);

                    // if ($result['is_approved']) {
                    //     if ($result['status'] == 'active') {
                    //         $_SESSION['status'] = 'active';
                    //         $_SESSION['user'] = $email;
                    //         header('location: ./../../views/students/dashboard.php');
                    //         exit;
                    //     } else {
                    //         $_SESSION['status'] = 'de-active';
                    //         header('location: ./../../views/auth/login.php');
                    //         exit;
                    //     }
                    // } else {
                    //     $_SESSION['approve'] = 0;
                    //     header('location: ./../../views/auth/login.php');
                    //     exit;
                    // }
                } else {
                    $createdAt = date("Y-m-d H:i:s");
                    $insertUser = $this->connection->prepare("INSERT into users (first_name, last_name, email_id, gender, created_at, user_name) values (?, ?, ?, ?, ?, ?)");
                    $insertUser->bind_param("ssssss", $givenName, $familyName, $email, $gender, $createdAt, $userName);
                    if ($insertUser->execute()) {
                        $_SESSION['user'] = $userName;
                        header('location: ./../../views/users/index.php');
                        exit;
                    }
                }
            } else {
                header('location: ./../views/auth/signin.php');
                exit;
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
           error("loginWithGoogle.php", $error->getCode(), $error->getMessage(), $error->getLine());
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

$loginWithgoogle = new LoginWithgoogle();
$loginWithgoogle->loginWithgoogle();

?>