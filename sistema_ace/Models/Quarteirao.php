<?php
/**
 * Model: Quarteirao (Registro Geográfico)
 * Gerencia operações com a tabela 'registro_geografico'
 */

class Quarteirao {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    /**
     * Busca todos os quarteirões de uma área
     */
    public function getByArea($cod_area) {
        $sql = "SELECT * FROM registro_geografico 
                WHERE cod_area = ? 
                ORDER BY numero_quarteirao ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $cod_area);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $quarteiroes = [];
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $quarteiroes[] = $row;
            }
        }
        
        $stmt->close();
        return $quarteiroes;
    }

    /**
     * Busca um quarteirão específico por ID
     */
    public function getById($id_quarteirao) {
        $sql = "SELECT * FROM registro_geografico 
                WHERE id_quarteirao = ? 
                LIMIT 1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_quarteirao);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $quarteirao = $result->fetch_assoc();
        $stmt->close();
        
        return $quarteirao;
    }

    /**
     * Busca o número do quarteirão
     */
    public function getNumero($id_quarteirao) {
        $sql = "SELECT numero_quarteirao FROM registro_geografico 
                WHERE id_quarteirao = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_quarteirao);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['numero_quarteirao'] ?? null;
    }
}
?>
