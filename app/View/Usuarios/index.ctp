

<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
    <!--<![endif]-->

    <?php /*
      <!-- ======================================= content ======================================= -->
      <section id="page">
      <section id="content" class="mt30 pb30">
      <header class="page-header mb30">
      <div class="container">
      <div class="row">
      <div class="col-sm-6">
      <h1> <?php echo __($usuario['Usuario']['apellido'].', '.$usuario['Usuario']['nombre']); ?> </h1>
      <h4><i> <?php echo __('Inicio'); ?> </i> </h4>
      </div>
      <div class="col-sm-6 hidden-xs">
      <ul id="navTrail">
      <li><a href="http://www.quboodev.comusuarios"> <?php echo __('Usuarios'); ?> </a></li>
      <li id="navTrailLast"> <?php echo __('index'); ?> </li>
      </ul>
      </div>
      </div>
      </div>
      </header>
      <div class="container">
      <div class="row" style = "margin-top: 35px;">
      <!-- sidebar -->
      <aside id="sidebar" class="col-md-3">
      <nav id="subnav">
      <ul>
      <li><a href = 'http://www.quboodev.comusuarios/reservation' class = "active"> <?php echo __('Reserva'); ?> <i class="icon-right-open"></i></a></li>
      <li><a href = 'http://www.quboodev.comusuarios/myReservs' > <?php echo __('Mis reservas'); ?> <i class="icon-right-open"></i></a></li>
      <li><a href = 'http://www.quboodev.comusuarios/miPerfil' > <?php echo __('Mi perfil'); ?> <i class="icon-right-open"></i></a></li>
      <li><a href = 'http://www.quboodev.comusuarios/history' > <?php echo __('Historial'); ?> <i class="icon-right-open"></i></a></li>
      <li><a href = 'http://www.quboodev.comusuarios/logout' > <?php echo __('Cerrar sesión'); ?> <i class="icon-right-open"></i></a></li>
      </ul>
      </nav>
      </aside>
      <section id = "content" class="col-md-9">
      </section>
      </div>
      </div>
      </section>
      </section>
     */ ?>

    <script>
        $(document).ready(function() {
            $('.pricingBloc').mouseover(function() {
                $(this).addClass('focusPlan');
            });
            $('.pricingBloc').mouseout(function() {
                $(this).removeClass('focusPlan');
            });
        });
    </script>

    <script language="javascript">
        function popup(id) {
            document.getElementById("popup_video").style.display = "";
            document.getElementById("telon").style.display = "";
            document.getElementById("popup_video").innerHTML = '<iframe style=" margin-left:18px; margin-top:73px;" width="473" height="265" src="http://www.youtube.com/embed/' + id + '" frameborder="0" allowfullscreen></iframe>';
        }
        function cerrar() {
            document.getElementById("popup_video").innerHTML = "";
            document.getElementById("popup_video").style.display = "none";
            document.getElementById("telon").style.display = "none";
        }
    </script>


    <!-- ======================================= content ======================================= -->
    


