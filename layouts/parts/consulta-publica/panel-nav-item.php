<?php $this->applyTemplateHook('nav.panel.public-consultation', 'before'); ?>
<li>
    <a <?php if (str_contains($this->template, 'consulta-publica')) echo 'class="active"'; ?> href="<?php echo $app->createUrl('consulta-publica', 'index') ?>">
        <span class="icon icon-public-consultation"></span>
        <?php \MapasCulturais\i::_e("Consulta Pública"); ?>
    </a>
</li>
<?php $this->applyTemplateHook('nav.panel.public-consultation', 'after'); ?>
