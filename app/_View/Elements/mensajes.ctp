<div class="mensajes-container">
    <div class="title"><?php echo __('Mensajes'); ?>
    </div>
    <span class="tab-shadow">
    </span>
    <?php echo $this->Html->link('', array('controller'=>'mensajes', 'action'=>'ajaxGetMensajes'), array('class' => 'js-ajax-url')); ?>
    <?php echo $this->Html->link('', array('controller'=>'mensajes', 'action'=>'ajaxAceptarMensajes'), array('class' => 'js-ajax-url-accept')); ?>
    <ul>
    </ul>
    <span class="tab metallic">
    </span>
</div>