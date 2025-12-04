<?php
/**
 * Controller: VisitaController
 * Gerencia as ações relacionadas a visitas
 */

class VisitaController {
    private $visitaModel;
    private $imovelModel;
    private $quarteiraoModel;
    private $depositoModel;

    public function __construct($connection) {
        require_once __DIR__ . '/../Models/Visita.php';
        require_once __DIR__ . '/../Models/Imovel.php';
        require_once __DIR__ . '/../Models/Quarteirao.php';
        require_once __DIR__ . '/../Models/Deposito.php';
        
        $this->visitaModel = new Visita($connection);
        $this->imovelModel = new Imovel($connection);
        $this->quarteiraoModel = new Quarteirao($connection);
        $this->depositoModel = new Deposito($connection);
        $this->connection = $connection;
    }

    /**
     * Ação: Exibir formulário de visita
     */
    public function show($id_imovel) {
        if ($id_imovel <= 0) {
            die("Erro: ID do imóvel inválido ou não recebido.");
        }

        $dados_imovel = $this->imovelModel->getById($id_imovel);
        
        if (!$dados_imovel) {
            die("Erro: Imóvel não encontrado.");
        }

        $id_quarteirao = $dados_imovel['id_quarteirao'];
        $dados_quarteirao = $this->quarteiraoModel->getById($id_quarteirao);

        // Verificar visita em andamento na sessão
        if (!isset($_SESSION['visita_id'])) {
            $id_visita_aberta = $this->visitaModel->getAbertaByImovel($id_imovel);

            if ($id_visita_aberta) {
                $_SESSION['visita_id'] = $id_visita_aberta;
            } else {
                $id_visita = $this->visitaModel->create($id_imovel, 'Normal', 1);
                $_SESSION['visita_id'] = $id_visita;
            }
        }

        $id_visita = $_SESSION['visita_id'];
        $depositos = $this->depositoModel->getByVisita($id_visita);

        require_once __DIR__ . '/../Views/visita/show.php';
    }

    /**
     * Ação: Adicionar depósito
     */
    public function addDeposito($id_visita) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /sistema_ace/");
            exit;
        }

        try {
            $tipo = $_POST['tipo_deposito'] ?? null;
            $foco = isset($_POST['foco']) ? (int)$_POST['foco'] : null;
            $tratado = isset($_POST['tratado']) ? (int)$_POST['tratado'] : null;
            $qtd_larvicida = isset($_POST['qtd_larvicida']) ? (float)$_POST['qtd_larvicida'] : null;
            $amostra = $_POST['amostra'] ?? null;

            $this->depositoModel->create(
                $id_visita,
                $tipo,
                $foco,
                $tratado,
                $qtd_larvicida,
                $amostra
            );

            header("Location: /sistema_ace/?action=visita-show&id_imovel=" . $_POST['id_imovel'] . "&ok=1");
            exit;
        } catch (Exception $e) {
            header("Location: /sistema_ace/?action=visita-show&id_imovel=" . $_POST['id_imovel'] . "&erro=" . urlencode($e->getMessage()));
            exit;
        }
    }

    /**
     * Ação: Remover depósito
     */
    public function removeDeposito($id_deposito) {
        try {
            $this->depositoModel->delete($id_deposito);
            
            $id_imovel = $_GET['id_imovel'] ?? 0;
            header("Location: /sistema_ace/?action=visita-show&id_imovel=$id_imovel&removed=1");
            exit;
        } catch (Exception $e) {
            header("Location: /sistema_ace/?action=visita-show&id_imovel=" . $_GET['id_imovel'] . "&erro=" . urlencode($e->getMessage()));
            exit;
        }
    }

    /**
     * Ação: Finalizar visita
     */
    public function finish($id_visita) {
        try {
            $this->visitaModel->updateEstado($id_visita, 0);
            unset($_SESSION['visita_id']);
            
            header("Location: /sistema_ace/?ok=1");
            exit;
        } catch (Exception $e) {
            header("Location: /sistema_ace/?erro=" . urlencode($e->getMessage()));
            exit;
        }
    }
}
?>
