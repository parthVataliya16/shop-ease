<?php
class Connection
{
    private $serverName;
    private $userName;
    private $password;
    private $dbname;
    public $connection;

    public function __construct()
    {
        global $database;
        $this->serverName = $database['serverName'];
        $this->userName = $database['userName'];
        $this->password = $database['password'];
        $this->dbname = $database['dbName'];
        try {
            $this->connection = new mysqli($this->serverName, $this->userName, $this->password, $this->dbname);
        } catch (Exception $error) {
            error("Connection.php", $error->getCode(), $error->getMessage(), $error->getLine());
            die("Connection failed: " . $error->getMessage());
        }
    }
}

?>