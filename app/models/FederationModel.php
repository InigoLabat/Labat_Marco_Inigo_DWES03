<?php

class FederationModel {
    private $dataPath = __DIR__ . '/../../data/federations.json';

    public function getAllFederations() {
        if (!file_exists($this->dataPath)) {
            return [];
        }
        $data = file_get_contents($this->dataPath);
        return json_decode($data, true) ?? [];
    }

    // Obtener una federacion por ID
    public function getFederationById($id) {
        $federations = $this->getAllFederations();
        foreach ($federations as $federation) {
            if ($federation['id'] == $id) {
                return $federation;
            }
        }
        return null;
    }

    public function addFederation($federation) {
        $federations = $this->getAllFederations();
        $federation['id'] = $this->generateNewId($federations); // Generar ID único
        $federations[] = $federation;
        return file_put_contents($this->dataPath, json_encode($federations, JSON_PRETTY_PRINT));
    }

    // Actualizar una federacion por ID
    public function updateFederation($id, $newData) {
        $federations = $this->getAllFederations();
        foreach ($federations as &$federation) {
            if ($federation['id'] == $id) {
                $federation = array_merge($federation, $newData);
                return file_put_contents($this->dataPath, json_encode($federations, JSON_PRETTY_PRINT));
            }
        }
        return false;
    }

    // Eliminar una federacion por ID
    public function deleteFederation($id) {
        $federations = $this->getAllFederations();
        $updatedFederations = array_filter($federations, function ($federation) use ($id) {
            return $federation['id'] != $id;
        });
        return file_put_contents($this->dataPath, json_encode($updatedFederations, JSON_PRETTY_PRINT));
    }

    // Generar un nuevo ID único
    private function generateNewId($federations) {
        $ids = array_column($federations, 'id');
        return $ids ? max($ids) + 1 : 1;
    }
}

