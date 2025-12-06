<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Controller: ImovelController
 * Gerencia as ações relacionadas a imóveis
 */

class ImovelController
{
    private $imovelModel;
    private $quarteiraoModel;

    public function __construct($connection)
    {
        require_once __DIR__ . '/../Models/Imovel.php';
        require_once __DIR__ . '/../Models/Quarteirao.php';
        $this->imovelModel = new Imovel($connection);
        $this->quarteiraoModel = new Quarteirao($connection);
        $this->connection = $connection;
    }

    /**
     * Ação: Listar imóveis por quarteirão
     */
    public function listByQuarteirao($id_quarteirao)
    {
        $imoveis = $this->imovelModel->getByQuarteirao($id_quarteirao);
        $numero_quarteirao = $this->quarteiraoModel->getNumero($id_quarteirao);

        require_once __DIR__ . '/../Views/imovel/index.php';
    }

    /**
     * Ação: Formulário de cadastro
     */
    public function create($id_quarteirao)
    {
        $quarteirao = $this->quarteiraoModel->getById($id_quarteirao);

        if (!$quarteirao) {
            die("Quarteirão não encontrado!");
        }

        require_once __DIR__ . '/../Views/imovel/create.php';
    }

    /**
     * Ação: Salvar novo imóvel
     */
    public function store($id_quarteirao)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /sistema_ace/?action=imovel-create&id_quarteirao=$id_quarteirao");
            exit;
        }

        try {
            $nome_rua = $_POST['nome_rua'] ?? null;
            $numero_imovel = $_POST['numero_imovel'] ?? null;
            $tipo_imovel = $_POST['tipo_imovel'] ?? null;
            $qtd_habitantes = (int)($_POST['qtd_habitantes'] ?? 0);
            $qtd_caes = (int)($_POST['qtd_caes'] ?? 0);
            $qtd_gatos = (int)($_POST['qtd_gatos'] ?? 0);

            if (!$nome_rua) {
                throw new Exception("Nome da rua é obrigatório!");
            }

            $this->imovelModel->create(
                $id_quarteirao,
                $nome_rua,
                $numero_imovel,
                $tipo_imovel,
                $qtd_habitantes,
                $qtd_caes,
                $qtd_gatos
            );

            header("Location: /sistema_ace/?action=imovel-list&id_quarteirao=$id_quarteirao&ok=1");
            exit;
        } catch (Exception $e) {
            $erro = $e->getMessage();
            require_once __DIR__ . '/../Views/imovel/create.php';
        }
    }
}
