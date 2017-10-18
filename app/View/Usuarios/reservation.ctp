<?php echo $this->Html->script('rating.js', array('inline' => false)); ?>
<script>
    $(document).ready(function() {
    });
</script>
<header class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1>
                    <?php
                    echo __(( isset($admin) ? 'Admin - ' : '') . $usuario['Usuario']['apellido'] . ', ' . $usuario['Usuario']['nombre']);
                    ?>
                </h1>
                <h4><i> <?php echo __('Reserva') ?> </i> </h4>
            </div>
            <div class="col-sm-6 hidden-xs">
                <ul id="navTrail">
                    <li><a href="/../usuarios/logout"> <?php echo __('Salir'); ?> </a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
<div class="container pt15">
    <div class="row">
        <?php echo $this->element('menus' . DS . 'usuario', array('active' => 'usuarios:reservation')); ?>
        <section id = "content" class="col-md-9">
            <div class = "row">
                <?php echo $this->Form->create('Empresa'); ?>
                <div class="input-group input-group-lg">
                    <span class="input-group-btn select-tipo">
                        <?php echo $this->Form->input('Tipoempresa.tipo', array('label' => false, 'div' => false, 'class' => 'btn btn-defaultg', 'options' => $tipos)) ?>
                    </span>
                    <?php echo $this->Form->input('nombre', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control lg', 'placeholder' => 'Buscar empresa...')) ?>
                    <span class="input-group-btn">
                        <?php
                        echo $this->Js->submit('Buscar', array(
                            'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
                            'success' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false)),
                            'update' => '#content',
                            'class' => 'btn btn-sm icon-search',
                            'div' => false,
                            'escape' => false
                        ));
                        ?>
                    </span>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
            <div class = "row">
                <?php
                echo $this->Paginator->options(
                        array(
                            'update' => '#content',
                            'before' => $this->Js->get('#loader')->effect(
                                    'fadeIn', array(
                                'buffer' => false
                                    )
                            ),
                            'complete' => $this->Js->get('#loader')->effect(
                                    'fadeOut', array(
                                'buffer' => false
                                    )
                            )
                        )
                );
                ?>
                <div class ="row text-center pt5">
                    <?php
                    echo $this->Html->image(
                            'loader.gif', array(
                        'id' => 'loader',
                        'hidden' => 'hidden'
                            )
                    );
                    ?>
                </div>
                <table class = "table table-condensed">
                    <?php
                    $tableHeaders = $this->Html->tableHeaders(array(
                        $this->Paginator->sort('nombre', __('Nombre')),
                        __('Tipo'),
                        __('Ranking'),
                        __('Votos')
                    ));
                    echo $tableHeaders;
                    $rows = array();
                    foreach ($empresas as $empresa) {
                        $rows[] = array(
                            $this->Html->link(__($empresa['Empresa']['nombre']), array('controller' => 'viajes', 'action' => 'add', $empresa['Empresa']['id'])),
                            $empresa['Tipoempresa']['tipo'],
                            $this->element('rating', array('value' => $empresa['Empresa']['rating'], 'editable' => false)),
                            /* ."<div class='rating-container rating-gly-star'>
                              <input type='number' class='rating' value = '" . $empresa['Empresa']['rating'] . "' data-show-clear = 'false' data-show-caption = 'false' min='0' max='5' step='0.5' data-size='xs' readOnly = 'readOnly'>
                              </div>", */
                            $empresa['Empresa']['votos'],
                        );
                    }
                    $rows[] = array($this->html->link(__('Cualquier empresa'), array('controller' => 'viajes', 'action' => 'add', null)),'','','');
                    echo $this->Html->tableCells($rows);
                    ?>
                </table>
                <div class = "row text-center">
                    <ul class = 'pagination'>
                        <li>
                            <?php
                            echo $this->Paginator->prev('<<', array(
                                'tag' => 'a'
                            ));
                            ?>
                        </li>
                        <?php
                        echo $this->Paginator->numbers(array(
                            'tag' => 'li',
                            'currentTag' => 'a',
                            'currentClass' => 'active',
                            'separator' => ''
                        ));
                        ?>
                        <li>
                            <?php
                            echo $this->Paginator->next('>>');
                            ?>
                        </li>
                    </ul>
                </div>	
            </div>
            <?php
            echo $this->Js->writeBuffer();
            ?>
        </section>
    </div>
</div>