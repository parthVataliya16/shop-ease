<?php

class LinkExpire extends Connection
{
    private $status, $message;

    public function __construct()
    {
        parent::__construct();
    }

    public function linkExpire($token)
    {
        try {
            $selectUser = $this->connection->query("SELECT created_at from reset_passwords where token = '$token'");
            if ($selectUser->num_rows) {
                $result = $selectUser->fetch_assoc();
                $createdTime = strtotime($result['created_at']);
                $currentTime = strtotime("now");
                $timeDiffernce = $currentTime - $createdTime;
    
                if (($timeDiffernce / 3600) > (24)) {
                    throw new Exception("Invalid link!", 204);
                } else {
                    $this->status = 200;
                    $this->message = "Link valid";
                }
    
            } else {
                throw new Exception("Invalid link!", 204);
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("LinkExpired.php", $error->getCode(), $error->getMessage(), $error->getLine());
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