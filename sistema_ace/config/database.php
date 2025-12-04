<?php
/**
 * Configuração de Banco de Dados
 * Sistema ACE - MVC
 */

class Database {
    private $host = "localhost";
    private $usuario = "root";
    private $senha = "";
    private $db = "sistema_ace";
    private $port = 3306;
    private $conn;

    public function connect() {
        $this->conn = new mysqli(
            $this->host,
            $this->usuario,
            $this->senha,
            $this->db,
            $this->port
        );

        if ($this->conn->connect_error) {
            error_log("MySQL connection failed: " . $this->conn->connect_error);
            die("Erro na conexão com o banco de dados");
        }

        return $this->conn;
    }

    public function getConnection() {
        if ($this->conn === null) {
            $this->connect();
        }
        return $this->conn;
    }

    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
