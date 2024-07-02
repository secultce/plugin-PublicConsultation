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
        $app = App::i();
        $env = self::getEnvironmentVariables();

        $query = "SELECT * FROM seal_relation WHERE seal_id = :seal_id AND object_type = :object_type AND object_id = :object_id";
        $params = [
            "seal_id" => (int) $env["SEAL_ID"],
            "object_type" => "MapasCulturais\Entities\Agent",
            "object_id" => $app->getUser()->profile->id,
        ];
        $conn = $app->em->getConnection();
        $result = $conn->fetchAllAssociative($query, $params);

        if ($result) return true;

        return false;
    }

    public static function getEnvironmentVariables()
    {
        $path = PLUGINS_PATH . 'PublicConsultation/.env';
        $env = parse_ini_file($path);

        return $env;
    }
}
