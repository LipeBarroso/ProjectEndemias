<?php
/**
 * Model: Visita
 * Gerencia operações com a tabela 'visita'
 */

class Visita {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    /**
     * Busca uma visita aberta para um imóvel
     */
    public function getAbertaByImovel($id_imovel) {
        $sql = "SELECT id_visita FROM visita 
                WHERE id_imovel = ? AND estado = 1 
                LIMIT 1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_imovel);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['id_visita'] ?? null;
    }

    /**
     * Busca uma visita por ID
     */
    public function getById($id_visita) {
        $sql = "SELECT * FROM visita WHERE id_visita = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_visita);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $visita = $result->fetch_assoc();
        $stmt->close();
        
        return $visita;
    }

    /**
     * Cria uma nova visita
     */
    public function create($id_imovel, $tipo = 'Normal', $estado = 1) {
        $sql = "INSERT INTO visita (id_imovel, tipo, estado) VALUES (?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isi", $id_imovel, $tipo, $estado);
        
        if ($stmt->execute()) {
            $id = $stmt->insert_id;
            $stmt->close();
            return $id;
        } else {
            $error = $stmt->error;
            $stmt->close();
            throw new Exception("Erro ao criar visita: " . $error);
        }
    }

    /**
     * Atualiza o estado de uma visita
     */
    public function updateEstado($id_visita, $estado) {
        $sql = "UPDATE visita SET estado = ? WHERE id_visita = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $estado, $id_visita);
        
        return $stmt->execute();
    }

    /**
     * Busca total de visitas
     */
    public function getTotalCount() {
        $sql = "SELECT COUNT(*) as total FROM visita";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        
        return $row['total'] ?? 0;
    }
}
?>
