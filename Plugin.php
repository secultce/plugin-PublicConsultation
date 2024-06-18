<?php

namespace PublicConsultation;

use MapasCulturais\App;

class Plugin extends \MapasCulturais\Plugin
{
    public function _init()
    {
        $app = App::i();

        // Adiciona link de navegação no painel de controle
        $app->hook('template(<<*>>.nav.panel.accountability):after', function () {
            $this->part('panel-nav-item');
        });
    }

    public function register()
    {
        // 
    }
}
