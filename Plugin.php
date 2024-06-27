<?php

namespace PublicConsultation;

use MapasCulturais\App;
use PublicConsultation\Utils\Util;

class Plugin extends \MapasCulturais\Plugin
{
    public function _init()
    {
        $app = App::i();

        // Adiciona link de navegação no painel de controle
        $app->hook('template(<<*>>.nav.panel.accountability):after', function () {
            if (Util::hasPermission()) $this->part('consulta-publica/panel-nav-item');
        });

        $app->hook('GET(consulta-publica.<<*>>):before', function () use ($app) {
            $app->view->enqueueScript('app', 'public_consultation', 'js/public-consultation.js');
            $app->view->enqueueStyle('app', 'public_consultation', 'css/public-consultation.css');
        });
    }

    public function register()
    {
        $app = App::i();

        $app->registerController('consulta-publica', Controllers\PublicConsultation::class);
    }
}
