<?php echo $this->Html->script('rating.js', array('inline' => false)); ?>
<script>
    $(document).ready(function() {
    });

    function guardar_cliente(){
        var cli = $('#selcliente').val();
        var user = '<?php echo $id ?>';
        var url = "/usuarios/relacionar/"+user+"/"+cli;
        //alert(url)
        location.href=url;

    }
</script>
<header class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1>
                    <?php
                    echo __(( isset($admin) ? 'Relacionar cliente - ' : '') . $usuario['Usuario']['apellido'] . ', ' . $usuario['Usuario']['nombre']);
                    ?>
                </h1>
                <h4><i> <?php echo __('Cuenta corriente') ?> </i> </h4>
            </div>
        </div>
    </div>
</header>
<div class="container pt15">
    <div class="row">
        <?php echo $this->element('menus' . DS . 'admin', array('active' => 'usuarios:view')); ?>
        <section id = "content" class="col-md-9">
        <div class="input select">
            <select id="selcliente" class="form-control sm">
            <?php
            foreach ($ivrClientes as $cliente) {
                echo '<option value="'.$cliente["apptaxi_ivr_clientes"]["id"].'">'.$cliente["apptaxi_ivr_clientes"]["telefono"].' '.$cliente["apptaxi_ivr_clientes"]["apellido"].' '.$cliente["apptaxi_ivr_clientes"]["nombre"].'</option>';
            }
            ?>
            </select>
        </div>

        <div class="input select">
        <button style="margin-top:20px" type="button" class="btn btn-primary" onclick="guardar_cliente()">Guardar</button>
        </div>
        </section>
    </div>
</div>