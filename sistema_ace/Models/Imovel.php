<?php
/**
 * Model: Imovel
 * Gerencia operações com a tabela 'imovel'
 */

class Imovel {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    /**
     * Busca todos os imóveis de um quarteirão
     */
    public function getByQuarteirao($id_quarteirao) {
        $sql = "SELECT * FROM imovel 
                WHERE id_quarteirao = ? 
                ORDER BY nome_rua ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_quarteirao);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $imoveis = [];
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $imoveis[] = $row;
            }
        }
        
        $stmt->close();
        return $imoveis;
    }

    /**
     * Busca um imóvel específico por ID
     */
    public function getById($id_imovel) {
        $sql = "SELECT * FROM imovel WHERE id_imovel = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_imovel);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $imovel = $result->fetch_assoc();
        $stmt->close();
        
        return $imovel;
    }

    /**
     * Cria um novo imóvel
     */
    public function create($id_quarteirao, $nome_rua, $numero_imovel, $tipo_imovel, 
                          $qtd_habitantes = 0, $qtd_caes = 0, $qtd_gatos = 0) {
        $sql = "INSERT INTO imovel 
                (id_quarteirao, nome_rua, numero_imovel, tipo_imovel, qtd_habitantes, qtd_caes, qtd_gatos)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "isssiii",
            $id_quarteirao,
            $nome_rua,
            $numero_imovel,
            $tipo_imovel,
            $qtd_habitantes,
            $qtd_caes,
            $qtd_gatos
        );
        
        if ($stmt->execute()) {
            $id = $stmt->insert_id;
            $stmt->close();
            return $id;
        } else {
            $error = $stmt->error;
            $stmt->close();
            throw new Exception("Erro ao cadastrar imóvel: " . $error);
        }
    }

    /**
     * Busca total de imóveis
     */
    public function getTotalCount() {
        $sql = "SELECT COUNT(*) as total FROM imovel";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        
        return $row['total'] ?? 0;
    }
}
?>
