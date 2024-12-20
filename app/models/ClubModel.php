<?php

class ClubModel {
    private $dataPath = __DIR__ . '/../../data/clubs.json';

    // Obtener todos los clubes
    public function getAllClubs() {
        if (!file_exists($this->dataPath)) {
            return [];
        }
        $data = file_get_contents($this->dataPath);
        return json_decode($data, true) ?? [];
    }

    // Obtener un club por ID
    public function getClubById($id) {
        $clubs = $this->getAllClubs();
        foreach ($clubs as $club) {
            if ($club['id'] == $id) {
                return $club;
            }
        }
        return null;
    }

    // Añadir un nuevo club
    public function addClub($club) {
        $clubs = $this->getAllClubs();
        $club['id'] = $this->generateNewId($clubs); // Generar ID único
        $clubs[] = $club;
        return file_put_contents($this->dataPath, json_encode($clubs, JSON_PRETTY_PRINT));
    }

    // Actualizar un club por ID
    public function updateClub($id, $newData) {
        $clubs = $this->getAllClubs();
        foreach ($clubs as &$club) {
            if ($club['id'] == $id) {
                $club = array_merge($club, $newData);
                return file_put_contents($this->dataPath, json_encode($clubs, JSON_PRETTY_PRINT));
            }
        }
        return false;
    }

    // Eliminar un club por ID
    public function deleteClub($id) {
        $clubs = $this->getAllClubs();
        $updatedClubs = array_filter($clubs, function ($club) use ($id) {
            return $club['id'] != $id;
        });
        return file_put_contents($this->dataPath, json_encode($updatedClubs, JSON_PRETTY_PRINT));
    }

    // Generar un nuevo ID único
    private function generateNewId($clubs) {
        $ids = array_column($clubs, 'id');
        return $ids ? max($ids) + 1 : 1;
    }
}
