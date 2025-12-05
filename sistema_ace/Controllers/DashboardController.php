<?php
/**
 * Controller: DashboardController
 * Gerencia a página inicial/dashboard
 */

class DashboardController {
    private $areaModel;
    private $imovelModel;
    private $visitaModel;

    public function __construct($connection) {
        require_once __DIR__ . '/../Models/Area.php';
        require_once __DIR__ . '/../Models/Imovel.php';
        require_once __DIR__ . '/../Models/Visita.php';
        
        $this->areaModel = new Area($connection);
        $this->imovelModel = new Imovel($connection);
        $this->visitaModel = new Visita($connection);
    }

    /**
     * Ação: Exibir dashboard
     */
    public function index() {
        $total_areas = $this->areaModel->getTotalCount();
        $total_imoveis = $this->imovelModel->getTotalCount();
        $total_visitas = $this->visitaModel->getTotalCount();
        
        require_once __DIR__ . '/../Views/dashboard/index.php';
    }
}
?>
