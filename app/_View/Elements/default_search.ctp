<div class='row'>
    <div class='col-xs-12'>
        <?php echo $this->Form->create($type); ?>
        <div class="input-group input-group-lg">
            <?php echo $this->Form->input('buscar', array('label' => false, 'div' => false, 'class' => 'form-control lg', 'placeHolder' => 'Buscar...')); ?>
            <span class="input-group-btn">
                <?php if(!empty($buttons)): ?>
                    <?php foreach($buttons as $button): ?>
                        <?php echo $this->Html->link($button['text'], array('controller' => $button['controller'], 'action' => $button['action']), array('class' => 'btn btn-info', 'div' => false)); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php
                $rndId = Utils::randomStr();
                echo $this->Form->submit('Buscar', ['class' => 'btn btn-primary search-submit', 'div' => false, 'id' => $rndId]);
//                echo $this->Js->submit('Buscar', array(
//                    'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
//                    'success' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false)) . $this->Js->sc,
//                    'update' => '#content',
//                    'class' => 'btn btn-primary',
//                    'div' => false
//                ));
                ?>
            </span>
        </div>
        <?php echo $this->Form->end(); ?>
        <br>
    </div>
</div>
<?php
//echo $this->Paginator->options(array(
//    'update' => '#content',
//    'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
//    'complete' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false))
//));
?>
<script>
    $(document).ready(function(){
        function makeOptions() {
            return {
                beforeSend: function() {
                    $('#loader').fadeIn();
                },
                complete: function() {
                    $('#loader').fadeOut();
                },
                success: function(data) {
                    var content = $(data).find('#content');
                    if(content.length == 0) {
                        content = $(data).filter('#content');
                    }
                    $('#content').replaceWith(content);
                }
            };
        }
        var $form = $('#<?php echo $rndId; ?>').closest('form');
        $form.submit(function(event){
            event.preventDefault();
            var options = makeOptions();
            options.url = $form.attr('action');
            options.method = 'POST';
            options.data = $form.serialize();
            $.ajax(options);
        });
        $(document).on('click', 'table.table.table-hover.table-striped tr#titulos th a, ul.pagination li a', function(event){
            event.preventDefault();
            var $a = $(this);
            var options = makeOptions();
            options.url = $a.attr('href');
            options.method = 'GET';
            $.ajax(options);
        });
    });
</script>
