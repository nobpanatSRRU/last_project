<?php
class AppDababase
{

    private $servername;
    private $username;
    private $password;
    private $db_name;

    private $conn;

    public function __construct($servername = "localhost", $username = "root", $password = "", $db_name = "DBMember")
    {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->db_name = $db_name;


    }

    public function connect()
    {
        // Create connection
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->db_name);

        // Check connection
        if ($this->conn->connect_error) {
            $this->conn->close();
            die("Connection failed: " . $this->conn->connect_error);

        }
        return $this->conn;

    }

}





?>