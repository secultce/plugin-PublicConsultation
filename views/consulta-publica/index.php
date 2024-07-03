<?php

use MapasCulturais\i;
use PublicConsultation\Entities\PublicConsultation;

$this->layout = 'panel';

$actives = array_filter($public_consultations, function ($value, $key) {
    return $value->status === PublicConsultation::STATUS_ENABLED;
}, ARRAY_FILTER_USE_BOTH);

$inactives = array_filter($public_consultations, function ($value, $key) {
    return $value->status === PublicConsultation::STATUS_DISABLED;
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
        <?php if ($actives) : $this->part('consulta-publica/search-input', ['status' => PublicConsultation::STATUS_ENABLED]); ?>
            <div id="published-wrapper">
                <?php
                foreach ($actives as $active) {
                    $this->part('consulta-publica/index-item', ['public_consultation' => $active]);
                }
                ?>
            </div>
        <?php else : ?>
            <div class="alert info"><?php \MapasCulturais\i::_e("Nenhuma consulta pública ativa."); ?></div>
        <?php endif; ?>
    </div>

    <div id="unpublished">
        <?php if ($inactives) : $this->part('consulta-publica/search-input', ['status' => PublicConsultation::STATUS_DISABLED]); ?>
            <div id="unpublished-wrapper">
                <?php
                foreach ($inactives as $inactive) {
                    $this->part('consulta-publica/index-item', ['public_consultation' => $inactive]);
                }
                ?>
            </div>
        <?php else : ?>
            <div class="alert info"><?php \MapasCulturais\i::_e("Nenhuma consulta pública inativa."); ?></div>
        <?php endif; ?>
    </div>
</div>
