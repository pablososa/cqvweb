<div class = "container pt30 pb30">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel">
				<div class="panel-heading"><h3 class="panel-title"><strong> Login </strong></h3></div>
				<div class="panel-body">
					<form action = "/usuarios/login" role="form" method = "post">
						<div class = "form-group">
					    	<div class = "col-md-12">
						      <input tabindex="1" name="data[Usuario][email]" class="form-control sm" placeholder="Email" type="text" id="UsuarioEmail">
						      
						     
						    </div>
					    </div>
					    <div class = "form-group">
					    	<div class = "col-md-12">
					    		<input tabindex="2" name="data[Usuario][pass]" class="form-control sm" placeholder="Contraseña" type="password" id="UsuarioPass">
						     
						    </div>
					    </div>
					    <div class = "form-group text-center">
					    	
							<button type="submit" class="btn btn-sm color2"> Ingresar </button>
							  <div class="tiny-login" style="height:27px; margin-top: 5px;"  >
                                    <a href="/usuarios/add" style="color: #fff;"><?php echo __('Registrarse'); ?></a>&nbsp;|
                                   <a href="/usuarios/recover" style="color: #fff;"> <?php echo __('Recuperar contraseña'); ?> </a>
                                </div>
							 
						</div>
					</form>
					
					<!--
					   <li class="primary btn-group-login">
                                                <input tabindex="1" name="data[Usuario][email]" class="input-group2" placeholder="Email" type="text" id="UsuarioEmail">
                                               
                                            </li>
                                            <li class="sep"></li>
                                            <li class="primary btn-group-login">
                                                <input tabindex="2" name="data[Usuario][pass]" class="input-group2" placeholder="Contraseña" type="password" id="UsuarioPass">
                                                <div class="tiny-login" style="height:27px; margin-top: 5px;"  >
                                                    <a href="/usuarios/add" style="color: #fff;"><?php echo __('Registrarse'); ?></a>&nbsp;|
                                                    <a id = "ingresar" href ="#" style="color: #fff;"><?php echo __('Ingresar'); ?></a>
                                                </div>
                                                <input type="submit" style="display: none;"></input>
                                            </li>
					-->
					
				</div>
			</div> 
		</div>
	</div>
</div>
