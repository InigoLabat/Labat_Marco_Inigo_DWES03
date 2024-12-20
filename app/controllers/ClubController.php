<?php
require_once __DIR__ . '/../models/ClubModel.php';

class ClubController {
    private $model;

    public function __construct() {
        $this->model = new ClubModel();
    }

    // Obtener todos los clubes
    public function getAll() {
        $clubs = $this->model->getAllClubs();
        header('Content-Type: application/json'); 
        echo json_encode($clubs);
    }

    // Obtener un club por ID
    public function getClubById($id) {
        $club = $this->model->getClubById($id);
        if ($club) {
            echo json_encode($club);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Club no encontrado"]);
        }
    }

    // Crear un nuevo club
    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($this->model->addClub($data)) {
            http_response_code(201);
            echo json_encode(["message" => "Club creado exitosamente"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Error al crear el club"]);
        }
    }

    // Actualizar un club por ID
    public function updateClub($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($this->model->updateClub($id, $data)) {
            echo json_encode(["message" => "Club actualizado correctamente"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Error al actualizar el club"]);
        }
    }

    // Eliminar un club por ID
    public function deleteClub($id) {
        if ($this->model->deleteClub($id)) {
            echo json_encode(["message" => "Club eliminado correctamente"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Error al eliminar el club"]);
        }
    }
}
