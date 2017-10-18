
$(document).ready( function(){
	
	$('#botonUsuario').click(function(e){
		
		//valido el nombre
		var ban_nom = true;
		if( $("#UsuarioNombre").val() != '' ){
			var arreglo = $("#UsuarioNombre").val().split(' ');
			for( var i = 0 ; i < arreglo.length ; i++ ){
				if( !arreglo[i].match( new RegExp('^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$') ) ){
					ban_nom = false;
				}
			}
			if( ban_nom ){
				if( $('#UsuarioNombre').parent().hasClass('has-error') ){
					$('#UsuarioNombre').parent().removeClass('has-error');
				}
				if( !$('#UsuarioNombre').parent().hasClass('has-success') ){
					$('#UsuarioNombre').parent().addClass('has-success');
				}
				if( $("#UsuarioNombre").parent().find('#ayudaNombre').length ){
					$('#ayudaNombre').remove();	
				}
			}else{
				if( $('#UsuarioNombre').parent().hasClass('has-success') ){
					$('#UsuarioNombre').parent().removeClass('has-success');
				}
				if( !$('#UsuarioNombre').parent().hasClass('has-error') ){
					$('#UsuarioNombre').parent().addClass('has-error');
				}
				if( !$("#UsuarioNombre").parent().find('#ayudaNombre').length ){
					$("#UsuarioNombre").parent().append('<p id = "ayudaNombre" class="help-block">Su nombre debe iniciar con una letra mayúscula y contener solo letras.</p>');	
				}
			}
			if( $("#UsuarioNombre").parent().find('p').length == 2 ){
				$('#nomObligatorio').remove();
			}
		}else{
			ban_nom = false;
			if( !$("#UsuarioNombre").parent().find('p').length ){
				$("#UsuarioNombre").parent().append('<p id = "nomObligatorio" class="help-block">Debe ingresar su nombre.</p>');	
			}
			if( $('#UsuarioNombre').parent().hasClass('has-success') ){
				$('#UsuarioNombre').parent().removeClass('has-success');
			}
		}
		
		//valido el apellido
		var ban_ape = true;
		if( $("#UsuarioApellido").val() != '' ){
			arreglo = $("#UsuarioApellido").val().split(' ');
			for( var i = 0 ; i < arreglo.length ; i++ ){
				if( !arreglo[i].match( new RegExp('^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$') ) ){
					ban_ape = false;
				}
			}
			if( ban_ape ){
				if( $('#UsuarioApellido').parent().hasClass('has-error') ){
					$('#UsuarioApellido').parent().removeClass('has-error');
				}
				if( !$('#UsuarioApellido').parent().hasClass('has-success') ){
					$('#UsuarioApellido').parent().addClass('has-success');
				}
				if( $("#UsuarioApellido").parent().find('#ayudaApellido').length ){
					$('#ayudaApellido').remove();	
				}
			}else{
				if( $('#UsuarioApellido').parent().hasClass('has-success') ){
					$('#UsuarioApellido').parent().removeClass('has-success');
				}
				if( !$('#UsuarioApellido').parent().hasClass('has-error') ){
					$('#UsuarioApellido').parent().addClass('has-error');
				}
				if( !$("#UsuarioApellido").parent().find('#ayudaApellido').length ){
					$("#UsuarioApellido").parent().append('<p id = "ayudaApellido" class="help-block">Su(s) apellido(s) deben iniciar con una letra mayúscula y contener solo letras.</p>');	
				}
			}
			if( $("#UsuarioApellido").parent().find('#apeObligatorio').length ){
				$('#apeObligatorio').remove();
			}
		}else{
			ban_ape = false;
			if( !$("#UsuarioApellido").parent().find('#apeObligatorio').length ){
				$("#UsuarioApellido").parent().append('<p id = "apeObligatorio" class="help-block">Debe ingresar su apellido.</p>');	
			}
			if( $('#UsuarioApellido').parent().hasClass('has-success') ){
					$('#UsuarioApellido').parent().removeClass('has-success');
			}
		}
		
		//valido el UsuarioEmail
		var ban_eme = true;
		if( $('#UsuarioEmail').val() != '' ){
			if( $('#UsuarioEmail').val().match( new RegExp('^([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}$') ) ){
				if( $('#UsuarioEmail').parent().parent().hasClass('has-error') ){
					$('#UsuarioEmail').parent().parent().removeClass('has-error');
				}
				if( !$('#UsuarioEmail').parent().parent().hasClass('has-success') ){
					$('#UsuarioEmail').parent().parent().addClass('has-success');
				}
				if( $("#UsuarioEmail").parent().find('#ayudaEmail').length ){
					$('#ayudaEmail').remove();	
				}
				ban_eme = true;
			}else{
				if( $('#UsuarioEmail').parent().parent().hasClass('has-success') ){
					$('#UsuarioEmail').parent().parent().removeClass('has-success');
				}
				if( !$('#UsuarioEmail').parent().parent().hasClass('has-error') ){
					$('#UsuarioEmail').parent().parent().addClass('has-error');
				}
				if( !$("#UsuarioEmail").parent().find('#ayudaEmail').length ){
					$("#UsuarioEmail").parent().append('<p id = "ayudaEmail" class="help-block"> Su correo debe seguir la siguiente estructura: pepe@dominio.com </p>');	
				}
				ban_eme = false;
			}
			if( $("#UsuarioEmail").parent().find('p').length == 2 ){
				$('#emeObligatorio').remove();
			}
		}else{
			ban_eme = false;
			if( !$("#UsuarioEmail").parent().find('p').length ){
				$("#UsuarioEmail").parent().append('<p id = "emeObligatorio" class="help-block">Debe ingresar su email.</p>');	
			}
			if( $('#UsuarioEmail').parent().parent().hasClass('has-success') ){
				$('#UsuarioEmail').parent().parent().removeClass('has-success');
			}
		}
		
		//valido el UsuarioPass
		var ban_pas = true;
		if( $('#UsuarioPass').val() != '' ){
			if( $('#UsuarioPass').val().match( new RegExp('^[a-zA-Z0-9]{6,20}$') ) ){
				if( $('#UsuarioPass').parent().parent().hasClass('has-error') ){
					$('#UsuarioPass').parent().parent().removeClass('has-error');
				}
				if( !$('#UsuarioPass').parent().parent().hasClass('has-success') ){
					$('#UsuarioPass').parent().parent().addClass('has-success');
				}
				if( $("#UsuarioPass").parent().find('#ayudaPass').length ){
					$('#ayudaPass').remove();	
				}
				ban_pas = true;
			}else{
				if( $('#UsuarioPass').parent().parent().hasClass('has-success') ){
					$('#UsuarioPass').parent().parent().removeClass('has-success');
				}
				if( !$('#UsuarioPass').parent().parent().hasClass('has-error') ){
					$('#UsuarioPass').parent().parent().addClass('has-error');
				}
				if( !$("#UsuarioPass").parent().find('#ayudaPass').length ){
					$("#UsuarioPass").parent().append('<p id = "ayudaPass" class="help-block"> Su contraseña debe contener entre 6 y 20 caracteres. </p>');	
				}
				ban_pas = false;
			}
			if( $("#UsuarioPass").parent().find('#pasObligatorio').length ){
				$('#pasObligatorio').remove();
			}
		}else{
			ban_pas = false;
			if( !$("#UsuarioPass").parent().find('p').length ){
				$("#UsuarioPass").parent().append('<p id = "pasObligatorio" class="help-block">Debe ingresar su contraseña.</p>');	
			}
			if( $('#UsuarioPass').parent().parent().hasClass('has-success') ){
				$('#UsuarioPass').parent().parent().removeClass('has-success');
			}
		}
		
		//valido el UsuarioPass1
		var ban_pas1 = true;
		if( $('#UsuarioPass1').val() != '' ){
			if( $('#UsuarioPass1').val() != $('#UsuarioPass').val() ){
				ban_pas1 = false;
				if( !$("#UsuarioPass1").parent().find('#Confirmar').length ){
					$("#UsuarioPass1").parent().append('<p id = "Confirmar" class="help-block"> Las contraseñas no coinciden. </p>');	
				}
				if( !$('#UsuarioPass1').parent().parent().hasClass('has-error') ){
					$('#UsuarioPass1').parent().parent().addClass('has-error');
				}
				if( $('#UsuarioPass1').parent().parent().hasClass('has-success') ){
					$('#UsuarioPass1').parent().parent().removeClass('has-success');
				}
			}else{
				if( $("#UsuarioPass1").parent().find('#Confirmar').length ){
					$("#Confirmar").remove();	
				}
				if( $('#UsuarioPass1').parent().parent().hasClass('has-error') ){
					$('#UsuarioPass1').parent().parent().removeClass('has-error');
				}
				if( !$('#UsuarioPass1').parent().parent().hasClass('has-success') ){
					$('#UsuarioPass1').parent().parent().addClass('has-success');
				}
			}
			if( $("#UsuarioPass1").parent().find('#pas1Obligatorio').length ){
				$("#pas1Obligatorio").remove();	
			}
		}else{
			ban_pas1 = false;
			if( !$("#UsuarioPass1").parent().find('p').length ){
				$("#UsuarioPass1").parent().append('<p id = "pas1Obligatorio" class="help-block">Debe confirmar su contraseña.</p>');	
			}
		}
		
		//valido el tel
		//valido caracteristica
		var ban_tel = true;
		
		if( $('#caract').val() != '' ){
			if( $('#caract').val().match( new RegExp('^[0-9]{3}$') ) ){
				if( $('#caract').parent().hasClass('has-error') ){
					$('#caract').parent().removeClass('has-error');
				}
				if( !$('#caract').parent().hasClass('has-success') ){
					$('#caract').parent().addClass('has-success');
				}
				if( $("#numero").parent().parent().parent().parent().find('#ayudaCaract').length ){
					$('#ayudaCaract').remove();	
				}
				ban_tel = true;
			}else{
				if( $('#caract').parent().hasClass('has-success') ){
					$('#caract').parent().removeClass('has-success');
				}
				if( !$('#caract').parent().hasClass('has-error') ){
					$('#caract').parent().addClass('has-error');
				}
				if( !$("#numero").parent().parent().parent().parent().find('#ayudaCaract').length ){
					$("#numero").parent().parent().parent().parent().append('<p id = "ayudaCaract" class="help-block"> La caracteristica consta de 3 digitos.</p>');	
				}
				ban_tel = false;
			}
		}else{
			ban_tel = false;
			if( $('#caract').parent().hasClass('has-success') ){
				$('#caract').parent().removeClass('has-success');
			}
		}
		
		//valido numero
		if( $('#numero').val() != '' ){
			if( $('#numero').val().match( new RegExp('^[0-9]{7}$') ) ){
				if( $('#numero').parent().hasClass('has-error') ){
					$('#numero').parent().removeClass('has-error');
				}
				if( !$('#numero').parent().hasClass('has-success') ){
					$('#numero').parent().addClass('has-success');
				}
				if( $("#numero").parent().parent().parent().parent().find('#ayudaNumero').length ){
					$('#ayudaNumero').remove();	
				}
				ban_tel = true;
			}else{
				if( $('#numero').parent().hasClass('has-success') ){
					$('#numero').parent().removeClass('has-success');
				}
				if( !$('#numero').parent().hasClass('has-error') ){
					$('#numero').parent().addClass('has-error');
				}
				if( !$("#numero").parent().parent().parent().parent().find('#ayudaNumero').length ){
					$("#numero").parent().parent().parent().parent().append('<p id = "ayudaNumero" class="help-block"> Su número debe contener 7 digitos.</p>');	
				}
				ban_tel = false; 
			}
		}else{
			ban_tel = false;
			if( $('#numero').parent().hasClass('has-success') ){
				$('#numero').parent().removeClass('has-success');
			}
		}
		
		if( !ban_tel ){
			if( !$("#numero").parent().parent().parent().parent().find('#ayudaTel').length ){
				$("#numero").parent().parent().parent().parent().append('<p id = "ayudaTel" class="help-block">Debe ingresar su teléfono móvil. (Característica + número)</p>');	
			}
		}else{
			if( $("#numero").parent().parent().parent().parent().find('#ayudaTel').length ){
				$("#ayudaTel").remove();	
			}
		}
		
		if( !ban_ape || !ban_nom || !ban_eme || !ban_pas || !ban_tel ){
			e.preventDefault();
		}
	});
	
	$('#botonEmpresas').click(function(e){
		
		//valido el EmpresaPass
		var ban_pas = true;
		if( $('#EmpresaPass').val() != '' ){
			if( $('#EmpresaPass').val().match( new RegExp('^[a-zA-Z0-9]{6,20}$') ) ){
				if( $('#EmpresaPass').parent().parent().hasClass('has-error') ){
					$('#EmpresaPass').parent().parent().removeClass('has-error');
				}
				if( !$('#EmpresaPass').parent().parent().hasClass('has-success') ){
					$('#EmpresaPass').parent().parent().addClass('has-success');
				}
				if( $("#EmpresaPass").parent().find('#ayudaPass').length ){
					$('#ayudaPass').remove();	
				}
				ban_pas = true;
			}else{
				if( $('#EmpresaPass').parent().parent().hasClass('has-success') ){
					$('#EmpresaPass').parent().parent().removeClass('has-success');
				}
				if( !$('#EmpresaPass').parent().parent().hasClass('has-error') ){
					$('#EmpresaPass').parent().parent().addClass('has-error');
				}
				if( !$("#EmpresaPass").parent().find('#ayudaPass').length ){
					$("#EmpresaPass").parent().append('<p id = "ayudaPass" class="help-block"> Su contraseña debe contener entre 6 y 20 caracteres. </p>');	
				}
				ban_pas = false;
			}
			if( $("#EmpresaPass").parent().find('#pasObligatorio').length ){
				$('#pasObligatorio').remove();
			}
		}else{
			ban_pas = false;
			if( !$("#EmpresaPass").parent().find('p').length ){
				$("#EmpresaPass").parent().append('<p id = "pasObligatorio" class="help-block"> Debe ingresar su contraseña. </p>');	
			}
			if( $('#EmpresaPass').parent().parent().hasClass('has-success') ){
				$('#EmpresaPass').parent().parent().removeClass('has-success');
			}
		}
		
		//valido el EmpresaPass1
		var ban_pas1 = true;
		if( $('#EmpresaPass1').val() != '' ){
			if( $('#EmpresaPass1').val() != $('#EmpresaPass').val() ){
				ban_pas1 = false;
				if( !$("#EmpresaPass1").parent().find('#Confirmar').length ){
					$("#EmpresaPass1").parent().append('<p id = "Confirmar" class="help-block"> Las contraseñas no coinciden. </p>');	
				}
				if( !$('#EmpresaPass1').parent().parent().hasClass('has-error') ){
					$('#EmpresaPass1').parent().parent().addClass('has-error');
				}
				if( $('#EmpresaPass1').parent().parent().hasClass('has-success') ){
					$('#EmpresaPass1').parent().parent().removeClass('has-success');
				}
			}else{
				if( $("#EmpresaPass1").parent().find('#Confirmar').length ){
					$("#Confirmar").remove();	
				}
				if( $('#EmpresaPass1').parent().parent().hasClass('has-error') ){
					$('#EmpresaPass1').parent().parent().removeClass('has-error');
				}
				if( !$('#EmpresaPass1').parent().parent().hasClass('has-success') ){
					$('#EmpresaPass1').parent().parent().addClass('has-success');
				}
			}
			if( $("#EmpresaPass1").parent().find('#pas1Obligatorio').length ){
				$("#pas1Obligatorio").remove();	
			}
		}else{
			ban_pas1 = false;
			if( !$("#EmpresaPass1").parent().find('p').length ){
				$("#EmpresaPass1").parent().append('<p id = "pas1Obligatorio" class="help-block"> Debe confirmar su contraseña. </p>');	
			}
		}
		
		//valido el UsuarioEmail
		var ban_eme = true;
		if( $('#EmpresaEmail').val() != '' ){
			if( $('#EmpresaEmail').val().match( new RegExp('^([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}$') ) ){
				if( $('#EmpresaEmail').parent().parent().hasClass('has-error') ){
					$('#EmpresaEmail').parent().parent().removeClass('has-error');
				}
				if( !$('#EmpresaEmail').parent().parent().hasClass('has-success') ){
					$('#EmpresaEmail').parent().parent().addClass('has-success');
				}
				if( $("#EmpresaEmail").parent().find('#ayudaEmail').length ){
					$('#ayudaEmail').remove();	
				}
				ban_eme = true;
			}else{
				if( $('#EmpresaEmail').parent().parent().hasClass('has-success') ){
					$('#EmpresaEmail').parent().parent().removeClass('has-success');
				}
				if( !$('#EmpresaEmail').parent().parent().hasClass('has-error') ){
					$('#EmpresaEmail').parent().parent().addClass('has-error');
				}
				if( !$("#EmpresaEmail").parent().find('#ayudaEmail').length ){
					$("#EmpresaEmail").parent().append('<p id = "ayudaEmail" class="help-block"> Su correo debe seguir la siguiente estructura: pepe@dominio.com </p>');	
				}
				ban_eme = false;
			}
			if( $("#EmpresaEmail").parent().find('p').length == 2 ){
				$('#emeObligatorio').remove();
			}
		}else{
			ban_eme = false;
			if( !$("#EmpresaEmail").parent().find('p').length ){
				$("#EmpresaEmail").parent().append('<p id = "emeObligatorio" class="help-block"> Debe ingresar su email. </p>');	
			}
			if( $('#EmpresaEmail').parent().parent().hasClass('has-success') ){
				$('#EmpresaEmail').parent().parent().removeClass('has-success');
			}
		}
		
		//valido el UsuarioCuit
		var ban_cuit = true;
		if( $('#EmpresaCuit').val() != '' ){
			if( $('#EmpresaCuit').val().match( new RegExp('^[0-9]{2}-[0-9]{8}-[0-9]$') ) ){
				if( $('#EmpresaCuit').parent().parent().hasClass('has-error') ){
					$('#EmpresaCuit').parent().parent().removeClass('has-error');
				}
				if( !$('#EmpresaCuit').parent().parent().hasClass('has-success') ){
					$('#EmpresaCuit').parent().parent().addClass('has-success');
				}
				if( $("#EmpresaCuit").parent().find('#ayudaCuit').length ){
					$('#ayudaCuit').remove();	
				}
				ban_cuit = true;
			}else{
				if( $('#EmpresaCuit').parent().parent().hasClass('has-success') ){
					$('#EmpresaCuit').parent().parent().removeClass('has-success');
				}
				if( !$('#EmpresaCuit').parent().parent().hasClass('has-error') ){
					$('#EmpresaCuit').parent().parent().addClass('has-error');
				}
				if( !$("#EmpresaCuit").parent().find('#ayudaCuit').length ){
					$("#EmpresaCuit").parent().append('<p id = "ayudaCuit" class="help-block"> Su cuit debe seguir la estructura: 20-32123232-4 </p>');	
				}
				ban_cuit = false;
			}
			if( $("#EmpresaCuit").parent().find('#cuitObligatorio').length ){
				$('#cuitObligatorio').remove();
			}
		}else{
			ban_cuit = false;
			if( !$("#EmpresaCuit").parent().find('#cuitObligatorio').length ){
				$("#EmpresaCuit").parent().append('<p id = "cuitObligatorio" class="help-block">Debe ingresar su cuit.</p>');	
			}
			if( $('#EmpresaCuit').parent().parent().hasClass('has-success') ){
				$('#EmpresaCuit').parent().parent().removeClass('has-success');
			}
		}
		
		e.preventDefault();

	});
	
});


