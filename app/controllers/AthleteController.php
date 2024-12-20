<?php

require_once __DIR__ . '/../models/AthleteModel.php';

class AthleteController {
    private $model;

    public function __construct() {
        $this->model = new AthleteModel();
    }

    public function getAll() {
        $athletes = $this->model->getAllAthletes();
        header('Content-Type: application/json'); 
        echo json_encode($athletes);
    }

    public function getAthleteById($id) {
        $athlete = $this->model->getAthleteById($id);
        if ($athlete) {
            echo json_encode($athlete);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Atleta no encontrado"]);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($this->model->addAthlete($data)) {
            echo json_encode(["message" => "Atleta añadido correctamente"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Error al añadir atleta"]);
        }
    }

    // Actualizar un atleta por ID
    public function updateAthlete($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($this->model->updateAthlete($id, $data)) {
            echo json_encode(["message" => "Atleta actualizado correctamente"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Error al actualizar el atleta"]);
        }
    }

    // Eliminar un atleta por ID
    public function deleteAthlete($id) {
        if ($this->model->deleteAthlete($id)) {
            echo json_encode(["message" => "Atleta eliminado correctamente"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Error al eliminar el atleta"]);
        }
    }
}