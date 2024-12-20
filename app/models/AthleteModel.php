<?php

class AthleteModel {
    private $dataPath = __DIR__ . '/../../data/athletes.json';

    public function getAllAthletes() {
        if (!file_exists($this->dataPath)) {
            return [];
        }
        $data = file_get_contents($this->dataPath);
        return json_decode($data, true) ?? [];
    }

    // Obtener un atleta por ID
    public function getAthleteById($id) {
        $athletes = $this->getAllAthletes();
        foreach ($athletes as $athlete) {
            if ($athlete['id'] == $id) {
                return $athlete;
            }
        }
        return null;
    }

    public function addAthlete($athlete) {
        $athletes = $this->getAllAthletes();
        $athlete['id'] = $this->generateNewId($athletes); // Generar ID único
        $athletes[] = $athlete;
        return file_put_contents($this->dataPath, json_encode($athletes, JSON_PRETTY_PRINT));
    }

    // Actualizar un atleta por ID
    public function updateAthlete($id, $newData) {
        $athletes = $this->getAllAthletes();
        foreach ($athletes as &$athlete) {
            if ($athlete['id'] == $id) {
                $athlete = array_merge($athlete, $newData);
                return file_put_contents($this->dataPath, json_encode($athletes, JSON_PRETTY_PRINT));
            }
        }
        return false;
    }

    // Eliminar un atleta por ID
    public function deleteAthlete($id) {
        $athletes = $this->getAllAthletes();
        $updatedAthletes = array_filter($athletes, function ($athlete) use ($id) {
            return $athlete['id'] != $id;
        });
        return file_put_contents($this->dataPath, json_encode($updatedAthletes, JSON_PRETTY_PRINT));
    }

    // Generar un nuevo ID único
    private function generateNewId($athletes) {
        $ids = array_column($athletes, 'id');
        return $ids ? max($ids) + 1 : 1;
    }
}

