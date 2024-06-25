<?php

use PublicConsultation\Entities\PublicConsultation;

$this->layout = 'panel';

?>

<div class="panel-list panel-main-content">
    <div class="alert public-consultation-alerts"></div>

    <header class="panel-header clearfix">
        <h2>
            <?php \MapasCulturais\i::_e("Editar Consulta Pública"); ?>
        </h2>
    </header>

    <div>
        <form action="<?php echo $app->createUrl('consulta-publica', 'update'); ?>" data-public-consultation-id="<?php echo $public_consultation->id; ?>" data-action="update" method="post" id="edit-public-consultation-form">
            <div>
                <label for="title">
                    Título: <span class="required-field">*</span>
                </label>
                <input type="text" name="title" placeholder="Insira o título" required class="form-field" value="<?php echo $public_consultation->title; ?>">
            </div>

            <div>
                <label for="subtitle">
                    Subtítulo: <span class="required-field">*</span>
                </label>
                <textarea name="subtitle" placeholder="Insira o subtítulo" required class="form-field"><?php echo $public_consultation->subtitle; ?></textarea>
            </div>

            <div>
                <label for="google_docs_link">
                    Link do Google Docs: <span class="required-field">*</span>
                </label>
                <input type="text" name="google_docs_link" placeholder="Insira o link do Google Docs" required class="form-field" value="<?php echo $public_consultation->googleDocsLink; ?>">
            </div>

            <div>
                <label for="status">
                    Status: <span class="required-field">*</span>
                </label><br>
                <select name="status" required>
                    <option value="" disabled>Selecione um status</option>
                    <option value="1" <?php if ($public_consultation->status === PublicConsultation::PUBLISHED_STATUS) : echo 'selected'; endif; ?>>
                        Publicada
                    </option>
                    <option value="0" <?php if ($public_consultation->status === PublicConsultation::UNPUBLISHED_STATUS) : echo 'selected'; endif; ?>>
                        Não Publicada
                    </option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" id="edit-public-consultation-btn">Salvar</button>
        </form>
    </div>
</div>
