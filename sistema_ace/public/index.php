<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Router para o Sistema ACE em MVC
 * Processa as requisições e roteia para os controllers apropriados
 */

session_start();

// Incluir a classe de banco de dados
require_once('../config/database.php');


// Criar conexão
$db = new Database();
$conn = $db->connect();

// Determinar a ação solicitada
$action = $_GET['action'] ?? 'dashboard';

// Rotear as requisições
switch ($action) {
    // Dashboard
    case 'dashboard':
        require_once('../Controllers/DashboardController.php');
        $controller = new DashboardController($conn);
        $controller->index();
        break;

    // Área
    case 'area-index':
        require_once('../Controllers/AreaController.php');
        $controller = new AreaController($conn);
        $controller->index();
        break;

    // Quarteirão
    case 'quarteirao-list':
        $cod_area = $_GET['cod_area'] ?? null;
        require_once('../Controllers/QuarteiraoController.php');
        $controller = new QuarteiraoController($conn);
        $controller->listByArea($cod_area);
        break;

    // Imóvel - Listar
    case 'imovel-list':
        $id_quarteirao = (int)($_GET['id_quarteirao'] ?? 0);
        require_once('../Controllers/ImovelController.php');
        $controller = new ImovelController($conn);
        $controller->listByQuarteirao($id_quarteirao);
        break;

    // Imóvel - Criar (formulário)
    case 'imovel-create':
        $id_quarteirao = (int)($_GET['id_quarteirao'] ?? 0);
        require_once('../Controllers/ImovelController.php');
        $controller = new ImovelController($conn);
        $controller->create($id_quarteirao);
        break;

    // Imóvel - Salvar
    case 'imovel-store':
        $id_quarteirao = (int)($_GET['id_quarteirao'] ?? 0);
        require_once('../Controllers/ImovelController.php');
        $controller = new ImovelController($conn);
        $controller->store($id_quarteirao);
        break;

    // Visita - Exibir
    case 'visita-show':
        $id_imovel = (int)($_GET['id_imovel'] ?? 0);
        require_once('../Controllers/VisitaController.php');
        $controller = new VisitaController($conn);
        $controller->show($id_imovel);
        break;

    // Visita - Adicionar depósito
    case 'visita-add-deposito':
        $id_visita = (int)($_POST['id_visita'] ?? 0);
        require_once('../Controllers/VisitaController.php');
        $controller = new VisitaController($conn);
        $controller->addDeposito($id_visita);
        break;

    // Visita - Remover depósito
    case 'visita-remove-deposito':
        $id_deposito = (int)($_GET['id_deposito'] ?? 0);
        require_once('../Controllers/VisitaController.php');
        $controller = new VisitaController($conn);
        $controller->removeDeposito($id_deposito);
        break;

    // Visita - Finalizar
    case 'visita-finish':
        $id_visita = (int)($_GET['id_visita'] ?? 0);
        require_once('../Controllers/VisitaController.php');
        $controller = new VisitaController($conn);
        $controller->finish($id_visita);
        break;

    default:
        // Se não reconhecer a ação, redireciona para dashboard
        header("Location: ?action=dashboard");
        exit;
}

// Fechar conexão
$db->closeConnection();
