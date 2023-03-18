<?php
class BusRepo
{
    private $conn;
    public function __construct(mysqli $db)
    {
        $this->conn = $db;

    }

    public function getAll()
    {
        $sql = 'SELECT * FROM bus';

        $result = $this->conn->query($sql);

        $buses = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($buses, $row);
            }

            return $buses;
        }

        $this->conn->close();
    }

    public function insert(string $name)
    {
        $stmt = $this->conn->prepare("INSERT INTO `bus`(`bus_name`) VALUES (?)");
        $stmt->bind_param("s", $name);
        $result = $stmt->execute();

        if ($result === true) {
            $stmt->close();
            $this->conn->close();
            return true;
        }
    }
}
?>