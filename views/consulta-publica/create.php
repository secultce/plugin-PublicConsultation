<?php

$this->layout = 'panel';

?>

<div class="panel-list panel-main-content">
    <div class="alert creation-alert" id="create-public-consultation-alerts"></div>

    <header class="panel-header clearfix">
        <h2>
            <?php \MapasCulturais\i::_e("Criar Consulta Pública"); ?>
        </h2>
    </header>

    <div>
        <form action="<?php echo $app->createUrl('consulta-publica', 'store') ?>" method="post" id="create-public-consultation-form">
            <label for="title">
                Título: <span class="required-field">*</span>
            </label>
            <input type="text" name="title" placeholder="Insira o título" required class="form-field">

            <label for="subtitle">
                Subtítulo: <span class="required-field">*</span>
            </label>
            <textarea name="subtitle" placeholder="Insira o subtítulo" class="form-field" required></textarea>

            <label for="google_docs_link">
                Link do Google Docs: <span class="required-field">*</span>
            </label>
            <input type="text" name="google_docs_link" placeholder="Insira o link do Google Docs" required class="form-field">

            <button type="submit" class="btn btn-primary" id="create-public-consultation-btn">Publicar</button>
        </form>
    </div>
</div>
