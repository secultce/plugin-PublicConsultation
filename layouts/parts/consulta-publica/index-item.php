<article class="objeto clearfix" id="public-consultation-wrapper">
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
        <a class="btn btn-small btn-primary" href="<?php echo $app->createUrl('consulta-publica', 'edit', ['id' => $public_consultation->id]); ?>">
            editar
        </a>
        <button class="btn btn-small btn-danger" id="del-public-consultation-btn" data-public-consultation-id="<?php echo $public_consultation->id; ?>">
            excluir
        </button>
    </div>
</article>
