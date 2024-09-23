<?php

namespace PublicConsultation\Utils;

use MapasCulturais\App;

class Util
{
    /**
     * Verifica se o agente pode executar as ações da consulta pública
     * O agente terá permissão se ele estiver vinculado a um determinado selo
     * 
     * @return boolean
     */
    public static function hasPermission()
    {
        $query = "SELECT * FROM seal_relation WHERE seal_id = :seal_id AND object_type = :object_type AND object_id = :object_id";
        $params = [
            "seal_id" => (int)env('SECULT_SEAL_ID'),
            "object_type" => "MapasCulturais\Entities\Agent",
            "object_id" => App::i()->getUser()->profile->id,
        ];
        $conn = App::i()->em->getConnection();
        $result = $conn->fetchAllAssociative($query, $params);

        if ($result) return true;

        return false;
    }
}
