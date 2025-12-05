<?php
/**
 * Controller: QuarteiraoController
 * Gerencia as ações relacionadas a quarteirões
 */

class QuarteiraoController {
    private $quarteiraoModel;

    public function __construct($connection) {
        require_once __DIR__ . '/../Models/Quarteirao.php';
        $this->quarteiraoModel = new Quarteirao($connection);
    }

    /**
     * Ação: Listar quarteirões por área
     */
    public function listByArea($cod_area) {
        $quarteiroes = $this->quarteiraoModel->getByArea($cod_area);
        
        require_once __DIR__ . '/../Views/quarteirao/index.php';
    }
}
?>
