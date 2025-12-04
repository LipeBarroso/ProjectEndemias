<?php
/**
 * Model: Area
 * Gerencia operações com a tabela 'area'
 */

class Area {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    /**
     * Busca todas as áreas ordenadas por nome
     */
    public function getAll() {
        $sql = "SELECT * FROM area ORDER BY nome_area ASC";
        $result = $this->conn->query($sql);
        
        $areas = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $areas[] = $row;
            }
        }
        
        return $areas;
    }

    /**
     * Busca uma área específica por código
     */
    public function getById($cod_area) {
        $sql = "SELECT * FROM area WHERE cod_area = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $cod_area);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $area = $result->fetch_assoc();
        $stmt->close();
        
        return $area;
    }

    /**
     * Busca total de áreas
     */
    public function getTotalCount() {
        $sql = "SELECT COUNT(*) as total FROM area";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        
        return $row['total'] ?? 0;
    }
}
?>
