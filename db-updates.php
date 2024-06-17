<?php

use function MapasCulturais\__exec;

$app = MapasCulturais\App::i();
$em = $app->em;
$conn = $em->getConnection();

return [
    'create table public_consultation_link' => function () {
        __exec("CREATE SEQUENCE public_consultation_link_id_seq INCREMENT BY 1 MINVALUE 1 START 1;");
        __exec(
            "CREATE TABLE public_consultation_link (
            id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            subtitle TEXT NOT NULL,
            google_docs_link VARCHAR(255) NOT NULL,
            agent_id INT NOT NULL,
            create_timestamp TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            PRIMARY KEY(id));"
        );
    },
];
