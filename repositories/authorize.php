<?php
class Authorize
{

    private $conn;


    public function __construct(mysqli $db)
    {
        $this->conn = $db;


    }

    public function login(string $username, string $password)
    {
        $hashPassword = md5($password);
        $stmt = $this->conn->prepare("SELECT id, username FROM user WHERE username=? AND password=? LIMIT 1");
        $stmt->bind_param('ss', $username, $hashPassword);
        $stmt->execute();
        $stmt->bind_result($id, $username);
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            if ($stmt->fetch()) //fetching the contents of the row
            {
                session_start();
                $_SESSION['logged'] = TRUE;
                $_SESSION["user_id"] = $id;
                $_SESSION["username"] = $username;
                return true;
            } else {
                return false;
            }

        }

        $stmt->close();
        $this->conn->close();
    }

}
?>