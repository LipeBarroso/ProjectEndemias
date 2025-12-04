<?php
/**
 * Model: Deposito
 * Gerencia operações com a tabela 'deposito'
 */

class Deposito {
    private $conn;
    private $usuario = "root";    // SEU USUÁRIO
    private $senha = "";           // SUA SENHA

    public function __construct($connection) {
        $this->conn = $connection;
    }

    /**
     * Busca todos os depósitos de uma visita
     */
    public function getByVisita($id_visita) {
        $sql = "SELECT * FROM deposito 
                WHERE id_visita = ? 
                ORDER BY id_deposito ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_visita);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $depositos = [];
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $depositos[] = $row;
            }
        }
        
        $stmt->close();
        return $depositos;
    }

    /**
     * Busca um depósito específico por ID
     */
    public function getById($id_deposito) {
        $sql = "SELECT * FROM deposito WHERE id_deposito = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_deposito);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $deposito = $result->fetch_assoc();
        $stmt->close();
        
        return $deposito;
    }

    /**
     * Cria um novo depósito
     */
    public function create($id_visita, $tipo, $foco = null, $tratado = null, 
                          $qtd_larvicida = null, $amostra = null) {
        $sql = "INSERT INTO deposito (id_visita, tipo, foco, tratado, qtd_larvicida, amostra) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "isiiis",
            $id_visita,
            $tipo,
            $foco,
            $tratado,
            $qtd_larvicida,
            $amostra
        );
        
        if ($stmt->execute()) {
            $id = $stmt->insert_id;
            $stmt->close();
            return $id;
        } else {
            $error = $stmt->error;
            $stmt->close();
            throw new Exception("Erro ao criar depósito: " . $error);
        }
    }

    /**
     * Deleta um depósito
     */
    public function delete($id_deposito) {
        $sql = "DELETE FROM deposito WHERE id_deposito = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_deposito);
        
        return $stmt->execute();
    }
}
?>
