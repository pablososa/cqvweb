<section id="page"> 
    <header class="page-header mb30">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1> <?php echo __('Formulario de contacto'); ?> </h1>
                </div>
                <div class="col-sm-6 hidden-xs">
                    <ul id="navTrail">
                        <li id="navTrailLast"> <?php __('Contacto'); ?> </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <?php
    if (isset($_POST['submit'])) {
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail();
        $Email->config('smtp');
        $Email->template('contacto');
        $Email->viewVars(compact('$_POST'));
        $Email->subject($_POST['motivo']);
        $Email->emailFormat('html');
        $Email->to('psosa@quboo.com.ar');
        if ($Email->send()) {
            echo
            '<div class="alert alert-success">
								<p>Su mensaje a sido enviado correctamente. Gracias por contactarse con nosostros.</p>
							</div>';
        } else {
            echo
            '<div class="alert alert-error">
								<p>Error al enviar el formulario. Por favor, inténtelo de nuevo mas tarde.</p>
							</div>';
        }
    }
    ?>
    <div class = "container pt30 pb30">
        <div class="row">
            <form method="post" novalidate="novalidate">
                <div class="col-sm-6"> 
                    <div class="form-group">
                        <input name="nombre" type="text" class="form-control" placeholder="Nombre y Apellido">
                    </div>
                    <div class="form-group">
                        <input name="telefono" type="tel" class="form-control required digits" placeholder="Número de teléfono móvil o fijo">
                    </div>
                    <div class="form-group">
                        <input name="email" type="email" class="form-control" size="30" value="" placeholder="E-mail">
                    </div>
                    <div class="form-group">
                        <input name="motivo" type="text" class="form-control" size="30" value="" placeholder="Motivo de contacto">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <textarea name="comentario" class="form-control" cols="3" rows="5" placeHolder="Comentario (hasta 1000 caracteres)"></textarea>
                    </div>
                    <div class = "form-group text-center">
                        <button name="submit" type="submit" class="btn btn-small" value = "send"> Enviar </button>
                    </div>
                </div>                        
            </form>
        </div>
    </div>
</section>