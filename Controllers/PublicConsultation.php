<?php

namespace PublicConsultation\Controllers;

use MapasCulturais\App;
use MapasCulturais\Exceptions\PermissionDenied;
use PublicConsultation\Entities\PublicConsultation as PublicConsultationEntity;
use PublicConsultation\Utils\Util;

class PublicConsultation extends \MapasCulturais\Controller
{
    public function GET_index()
    {
        $this->requireAuthentication();

        $app = App::i();

        if (!Util::hasPermission()) $app->redirect($app->createUrl('panel'));

        $public_consultations = $app->repo(PublicConsultationEntity::class)->findBy([], ['id' => 'desc']);

        $this->render('index', ['public_consultations' => $public_consultations]);
    }

    public function GET_create()
    {
        $this->requireAuthentication();

        $app = App::i();

        if (!Util::hasPermission()) $app->redirect($app->createUrl('panel'));

        $this->render('create');
    }

    public function POST_store()
    {
        $this->requireAuthentication();

        $app = App::i();

        if (!Util::hasPermission()) $app->redirect($app->createUrl('panel'));

        $data = $this->data;

        if (!$data["title"] || !$data["subtitle"] || !$data["google_docs_link"]) {
            $this->json(['message' => 'Preencha todos os campos'], 400);
        }

        $public_consultation_entity = new PublicConsultationEntity();
        $public_consultation_entity->create($data);

        $this->json(['message' => 'Consulta Pública cadastrada com sucesso. Aguarde.']);
    }

    public function GET_edit()
    {
        $this->requireAuthentication();

        $app = App::i();

        $id = (int) $this->data["id"];
        $public_consultation = current($app->repo(PublicConsultationEntity::class)->findBy(['id' => $id]));

        if (!Util::hasPermission()) throw new PermissionDenied($app->user, $public_consultation, 'edit');

        $this->render('edit', ['public_consultation' => $public_consultation]);
    }

    public function POST_update()
    {
        $this->requireAuthentication();

        $app = App::i();

        $data = $this->data;

        if (!$data["title"] || !$data["subtitle"] || !$data["google_docs_link"]) {
            $this->json(['message' => 'Preencha todos os campos'], 400);
        }

        $id = (int) $data["id"];
        $public_consultation = current($app->repo(PublicConsultationEntity::class)->findBy(['id' => $id]));

        if (!Util::hasPermission()) throw new PermissionDenied($app->user, $public_consultation, 'update');

        $public_consultation->update($data);

        $this->json(['message' => 'Consulta Pública atualizada com sucesso. Aguarde.']);
    }

    public function POST_trash()
    {
        $this->requireAuthentication();

        $app = App::i();

        $id = (int) $this->data["id"];
        $public_consultation = current($app->repo(PublicConsultationEntity::class)->findBy(['id' => $id]));

        if (!Util::hasPermission()) throw new PermissionDenied($app->user, $public_consultation, 'trash');

        $public_consultation->trash();

        $this->json(['message' => 'Consulta Pública deletada com sucesso. Aguarde.']);
    }

    public function GET_ativas()
    {
        $app = App::i();
        $env = Util::getEnvironmentVariables();

        $public_consultations = $app->repo(PublicConsultationEntity::class)->findBy(['status' => PublicConsultationEntity::STATUS_ENABLED], ['id' => 'desc']);

        header("Access-Control-Allow-Origin: {$env["FRONT_SITE_URL"]}");

        $this->json($public_consultations);
    }

    public function GET_search()
    {
        $app = App::i();

        $status = (int) $this->data["status"];
        $text = $this->data["text"];

        $query = "SELECT * FROM public_consultation WHERE status = :status AND title ILIKE :text ORDER BY id DESC";
        $params = [
            "status" => $status,
            "text" => "%$text%",
        ];
        $conn = $app->em->getConnection();
        $search_result = $conn->fetchAllAssociative($query, $params);

        $this->json($search_result);
    }

    public function GET_allByStatus()
    {
        $app = App::i();

        $status = (int) $this->data["status"];

        $query = "SELECT * FROM public_consultation WHERE status = :status ORDER BY id DESC";
        $params = [
            "status" => $status,
        ];
        $conn = $app->em->getConnection();
        $search_result = $conn->fetchAllAssociative($query, $params);

        $this->json($search_result);
    }
}
