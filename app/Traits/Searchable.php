<?php

namespace App\Traits;

trait Searchable
{
    public function scopeSearch($query, $searchCriteria)
    {
        return $query->where(function($query) use ($searchCriteria) {
            // Search by description if provided
            if (!empty($searchCriteria['descricao']) && !is_null($searchCriteria['descricao'])) {
                $searchTerm = $searchCriteria['descricao'];
                foreach ($this->searchable as $field) {
                    $query->orWhere($field, 'LIKE', "%$searchTerm%");
                }
            }

            // Search by numero if provided
            if (!empty($searchCriteria['numero']) && !is_null($searchCriteria['numero'])) {
                $searchTerm = $searchCriteria['numero'];
                foreach ($this->searchable as $field) {
                    $query->orWhere($field, 'LIKE', "%$searchTerm%");
                }
            }

            // Search by cod_provincia_id if provided
            if (isset($searchCriteria['cod_provincia_id'])) {
                if ($searchCriteria['cod_provincia_id'] == 'geral') {
                    $query->whereNull('cod_provincia_id');
                } else {
                    $query->where('cod_provincia_id', $searchCriteria['cod_provincia_id']);
                }
            }

            if (isset($searchCriteria['cod_cidade_id'])) {
                $query->where('cod_cidade_id', $searchCriteria['cod_cidade_id']);
            }

            // Filter by situation if provided
            if (!empty($searchCriteria['situacao']) && !is_null($searchCriteria['situacao'])) {
                $query->where('situacao', $searchCriteria['situacao']);
            }

            // Filter by date range if provided
            if (!empty($searchCriteria['data_inicio']) && !is_null($searchCriteria['data_inicio']) &&
                !empty($searchCriteria['data_fim']) && !is_null($searchCriteria['data_fim'])) {
                $query->whereBetween('data', [$searchCriteria['data_inicio'], $searchCriteria['data_fim']]);
            }
        });
    }
}
