<?php
class Members
{
    private $conn;
    public function __construct(mysqli $db)
    {
        $this->conn = $db;
    }


    public function getAll()
    {
        $sql = '
        SELECT 
        member.id AS mem_id,
        member.name AS mem_name,
        member.sname AS mem_sname,
        member.email AS mem_email,
        bus.bus_name AS bus_name
        FROM member 
        INNER JOIN bus 
        ON member.bus_id = bus.id
        ';

        $result = $this->conn->query($sql);

        $members = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($members, $row);
            }

            return $members;
        }

        $this->conn->close();
    }

    public function insertMember(string $name, string $sname, string $email, string $bus_id)
    {

        $stmt = $this->conn->prepare("INSERT INTO `member`(`name`, `sname`, `email`, `bus_id`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $sname, $email, $bus_id);
        $result = $stmt->execute();

        if ($result === true) {
            $stmt->close();
            $this->conn->close();
            return true;
        }
    }

    public function getById(string $user_id)
    {
        $member = array();
        $sql = "SELECT * FROM member WHERE id='$user_id' ";
        $result = $this->conn->query($sql);
        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                array_push($member, $row);
            }
        }

        return $member;
    }

    public function updateMember(string $user_id, string $name, string $sname, string $email, string $bus_id)
    {
        $sql = "UPDATE `member` SET `name`= '$name',`sname`='$sname',`email`='$email',`bus_id`='$bus_id' WHERE `id`=$user_id ";

        if (mysqli_query($this->conn, $sql)) {

            return true;
        } else {

            echo "Error updating record: " . mysqli_error($this->conn);
        }

        $this->conn->close();


    }

    public function deleteMember(string $user_id)
    {
        $sql = "DELETE FROM member WHERE id='$user_id'";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            echo "Error deleting record: " . $this->conn->error;
        }

        $this->conn->close();
    }
}
?>