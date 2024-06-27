<?php

$this->layout = 'panel';

?>

<div class="panel-list panel-main-content">
    <div class="alert public-consultation-alerts"></div>

    <header class="panel-header clearfix">
        <h2>
            <?php \MapasCulturais\i::_e("Criar Consulta Pública"); ?>
        </h2>
    </header>

    <div>
        <form action="<?php echo $app->createUrl('consulta-publica', 'store') ?>" data-action="store" method="post" id="create-public-consultation-form">
            <div>
                <label for="title">
                    Título: <span class="required-field">*</span>
                </label>
                <input type="text" name="title" placeholder="Insira o título" required class="form-field">
            </div>

            <div>
                <label for="subtitle">
                    Subtítulo: <span class="required-field">*</span>
                </label>
                <textarea name="subtitle" placeholder="Insira o subtítulo" class="form-field" required></textarea>
            </div>

            <div>
                <label for="google_docs_link">
                    Link do Google Docs: <span class="required-field">*</span>
                </label>
                <input type="text" name="google_docs_link" required placeholder="Insira o link do Google Docs" class="form-field">
            </div>

            <button type="submit" class="btn btn-primary" id="create-public-consultation-btn">Publicar</button>
        </form>
    </div>
</div>
