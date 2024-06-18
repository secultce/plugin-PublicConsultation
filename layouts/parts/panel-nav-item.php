<?php $this->applyTemplateHook('nav.panel.public-consultation', 'before'); ?>
<li>
    <a <?php if ($this->template == '') echo 'class="active"'; ?> href="<?php echo $app->createUrl('', '') ?>">
        <span class="icon icon-opportunity"></span>
        <?php \MapasCulturais\i::_e("Consulta Pública"); ?>
    </a>
</li>
<?php $this->applyTemplateHook('nav.panel.public-consultation', 'after'); ?>
