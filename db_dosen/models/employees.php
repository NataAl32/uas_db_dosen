<?php
class Employee
{
    // Connection
    private $conn;
    // Table
    private $db_table = "Employee";
    // Columns
    public $id;
    public $nama;
    public $email;
    public $usia;
    public $mata_kuliah;
    public $created;
    
    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }
    
    // GET ALL
    public function getEmployees()
    {
        $sqlQuery = "SELECT id, nama, email, usia, mata_kuliah, created FROM " . $this->db_table;
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    
    // CREATE
    public function createEmployee()
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . "
            SET
                nama = :nama,
                email = :email,
                usia = :usia,
                mata_kuliah = :mata_kuliah,
                created = :created";
        $stmt = $this->conn->prepare($sqlQuery);
        
        // sanitize
        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->usia = htmlspecialchars(strip_tags($this->usia));
        $this->mata_kuliah = htmlspecialchars(strip_tags($this->mata_kuliah));
        $this->created = htmlspecialchars(strip_tags($this->created));
        
        // bind data
        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":usia", $this->usia);
        $stmt->bindParam(":mata_kuliah", $this->mata_kuliah);
        $stmt->bindParam(":created", $this->created);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // READ single
    public function getSingleEmployee()
    {
        $sqlQuery = "SELECT
                id,
                nama,
                email,
                usia,
                mata_kuliah,
                created
            FROM
                " . $this->db_table . "
            WHERE
                id = ?
            LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->nama = $dataRow['nama'];
        $this->email = $dataRow['email'];
        $this->usia = $dataRow['usia'];
        $this->mata_kuliah = $dataRow['mata_kuliah'];
        $this->created = $dataRow['created'];
    }
    
    // UPDATE
    public function updateEmployee()
    {
        $sqlQuery = "UPDATE
                " . $this->db_table . "
            SET
                nama = :nama,
                email = :email,
                usia = :usia,
                mata_kuliah = :mata_kuliah,
                created = :created
            WHERE
                id = :id";
        $stmt = $this->conn->prepare($sqlQuery);
        
        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->usia = htmlspecialchars(strip_tags($this->usia));
        $this->mata_kuliah = htmlspecialchars(strip_tags($this->mata_kuliah));
        $this->created = htmlspecialchars(strip_tags($this->created));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // bind data
        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":usia", $this->usia);
        $stmt->bindParam(":mata_kuliah", $this->mata_kuliah);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":id", $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // DELETE
    function deleteEmployee()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
