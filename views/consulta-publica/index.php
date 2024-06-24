<?php

$this->layout = 'panel';

?>

<div class="panel-list panel-main-content">
    <header class="panel-header clearfix">
        <h2>
            <?php \MapasCulturais\i::_e("Consultas Públicas"); ?>
        </h2>
        <a class="btn btn-default add" href="<?php echo $app->createUrl('consulta-publica', 'create'); ?>">
            <?php \MapasCulturais\i::_e("Criar Consulta Pública"); ?>
        </a>
    </header>

    <?php if ($public_consultations) : ?>
        <?php foreach ($public_consultations as $public_consultation) : ?>
            <article class="objeto clearfix">
                <h1>
                    <a href="">
                        <?php echo $public_consultation->title; ?>
                    </a>
                </h1>
                <div class="objeto-meta">
                    <span class="label">
                        <?php echo $public_consultation->subtitle; ?>
                    </span>
                </div>
                <div class="objeto-meta">
                    <span class="label" style="word-wrap: break-word;">
                        <a href="<?php echo $public_consultation->googleDocsLink; ?>" target="_blank">
                            <?php echo $public_consultation->googleDocsLink; ?>
                        </a>
                    </span>
                </div>
                <div class="entity-actions">
                    <a class="btn btn-small btn-primary" href="<?php echo $app->createUrl('consulta-publica', 'edit', ['id' => $public_consultation->id]); ?>">editar</a>
                    <a class="btn btn-small btn-danger" href="">excluir</a>
                </div>
            </article>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="alert info"><?php \MapasCulturais\i::_e("Nenhuma consulta pública cadastrada."); ?></div>
    <?php endif; ?>
</div>
