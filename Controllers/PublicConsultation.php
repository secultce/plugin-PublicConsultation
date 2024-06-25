<?php

namespace PublicConsultation\Controllers;

use MapasCulturais\App;
use PublicConsultation\Entities\PublicConsultation as PublicConsultationEntity;

class PublicConsultation extends \MapasCulturais\Controller
{
    public function GET_index()
    {
        $this->requireAuthentication();

        $app = App::i();

        $public_consultations = $app->repo('PublicConsultation\Entities\PublicConsultation')->findBy([], ['id' => 'desc']);

        $this->render('index', ['public_consultations' => $public_consultations]);
    }

    public function GET_create()
    {
        $this->requireAuthentication();
        $this->render('create');
    }

    public function POST_store()
    {
        $this->requireAuthentication();

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
        $public_consultation = $app->repo('PublicConsultation\Entities\PublicConsultation')->findBy(['id' => $id]);

        $this->render('edit', ['public_consultation' => current($public_consultation)]);
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
        $public_consultation = current($app->repo('PublicConsultation\Entities\PublicConsultation')->findBy(['id' => $id]));

        $public_consultation->update($data);

        $this->json(['message' => 'Consulta Pública atualizada com sucesso. Aguarde.']);
    }

    public function POST_trash()
    {
        $this->requireAuthentication();

        $app = App::i();

        $id = (int) $this->data["id"];
        $public_consultation = current($app->repo('PublicConsultation\Entities\PublicConsultation')->findBy(['id' => $id]));

        $public_consultation->trash();

        $this->json(['message' => 'Consulta Pública deletada com sucesso. Aguarde.']);
    }
}
