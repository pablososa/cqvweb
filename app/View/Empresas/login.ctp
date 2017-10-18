</br>
<center>
 <form action = "/empresas/login" role="form" method = "post" novalidate>


<div class="row" style="margin-top:10%">
    <img style="" src="/img/<?php echo LOGO_LOGIN;?>">
</div>
</br></br>
<div class="row">
<div style="width:500px" >
<div class="row">
<div class="col-sm-12">
<div class="form-group">
<input autofocus="autofocus" class="form-control" id = "email" name="data[Empresa][email]" type="email" placeholder="Email" >
</div>
<div class="form-group last">
<input class="form-control" id = "pass" name="data[Empresa][pass]" type="password"  placeholder="Contraseña" type="password">
</div>
</div>
</div>
<div class="row">
<div class="col-sm-6 col-xs-12 forgot_password vertical_center">
<a class="forgot_pass" href="/password_resets/new">¿Has olvidado tu contraseña?</a>
</div>
<div class="col-sm-6">
<input class="btn btn-primary" id="new_session_button" value="Entrar" type="submit">
</div>
</div>

</div>
</div>
</form>

</center>
