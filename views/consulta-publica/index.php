<?php

use MapasCulturais\i;
use PublicConsultation\Entities\PublicConsultation;

$this->layout = 'panel';

$actives = array_filter($public_consultations, function ($value, $key) {
    return $value->status === PublicConsultation::PUBLISHED_STATUS;
}, ARRAY_FILTER_USE_BOTH);

$inactives = array_filter($public_consultations, function ($value, $key) {
    return $value->status === PublicConsultation::UNPUBLISHED_STATUS;
}, ARRAY_FILTER_USE_BOTH);

?>

<div class="panel-list panel-main-content">
    <div class="alert public-consultation-alerts"></div>

    <header class="panel-header clearfix">
        <h2>
            <?php \MapasCulturais\i::_e("Consultas Públicas"); ?>
        </h2>
        <a class="btn btn-default add" href="<?php echo $app->createUrl('consulta-publica', 'create'); ?>">
            <?php \MapasCulturais\i::_e("Criar Consulta Pública"); ?>
        </a>
    </header>

    <ul class="abas clearfix clear">
        <?php $this->part('tab', ['id' => 'published', 'label' => i::__("Ativas") . " (" . count($actives) . ")", 'active' => true]) ?>
        <?php $this->part('tab', ['id' => 'unpublished', 'label' => i::__("Inativas") . " (" . count($inactives) . ")"]) ?>
    </ul>

    <div id="published">
        <?php
        if ($actives) {
            foreach ($actives as $active) {
                $this->part('consulta-publica/index-item', ['public_consultation' => $active]);
            }
        } else { ?>
            <div class="alert info"><?php \MapasCulturais\i::_e("Nenhuma consulta pública ativa."); ?></div>
        <?php } ?>
    </div>

    <div id="unpublished">
        <?php
        if ($inactives) {
            foreach ($inactives as $inactive) {
                $this->part('consulta-publica/index-item', ['public_consultation' => $inactive]);
            }
        } else { ?>
            <div class="alert info"><?php \MapasCulturais\i::_e("Nenhuma consulta pública inativa."); ?></div>
        <?php } ?>
    </div>
</div>
