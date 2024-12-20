<?php

require_once __DIR__ . '/../models/FederationModel.php';

class FederationController {
    private $model;

    public function __construct() {
        $this->model = new FederationModel();
    }

    public function getAll() {
        $federations = $this->model->getAllFederations();
        header('Content-Type: application/json'); 
        echo json_encode($federations);
    }

    public function getFederationById($id) {
        $federation = $this->model->getFederationById($id);
        if ($federation) {
            echo json_encode($federation);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Federación no encontrada"]);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($this->model->addFederation($data)) {
            echo json_encode(["message" => "Federación añadida correctamente"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Error al añadir federación"]);
        }
    }

    // Actualizar una federacion por ID
    public function updateFederation($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($this->model->updateFederation($id, $data)) {
            echo json_encode(["message" => "Federación actualizada correctamente"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Error al actualizar la federación"]);
        }
    }

    // Eliminar una federacion por ID
    public function deleteFederation($id) {
        if ($this->model->deleteFederation($id)) {
            echo json_encode(["message" => "Federación eliminada correctamente"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Error al eliminar la federración"]);
        }
    }
}