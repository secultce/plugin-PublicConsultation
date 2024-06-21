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

        $public_consultations = $app->repo('PublicConsultation\Entities\PublicConsultation')->findAll();

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

        $app = App::i();

        $public_consultation_entity = new PublicConsultationEntity();
        $public_consultation_entity->create($this->data);

        $app->redirect($app->createUrl('consulta-publica', 'index'));
    }
}
