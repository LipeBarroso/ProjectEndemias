<?php
/**
 * Controller: AreaController
 * Gerencia as ações relacionadas a áreas
 */

class AreaController {
    private $areaModel;

    public function __construct($connection) {
        require_once __DIR__ . '/../Models/Area.php';
        $this->areaModel = new Area($connection);
    }

    /**
     * Ação: Listar todas as áreas
     */
    public function index() {
        $areas = $this->areaModel->getAll();
        $totalAreas = $this->areaModel->getTotalCount();
        
        require_once __DIR__ . '/../Views/area/index.php';
    }

    /**
     * Ação: Detalhes de uma área
     */
    public function show($cod_area) {
        $area = $this->areaModel->getById($cod_area);
        
        if (!$area) {
            die("Área não encontrada!");
        }
        
        require_once __DIR__ . '/../Views/area/show.php';
    }
}
?>
