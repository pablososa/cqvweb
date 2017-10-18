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

     <!-- ======================================= content ======================================= -->
    <section id="layer-slider" >
        <div class="sliderr">
            <div id="layer-slider-container-fw-second"> 
                <div id="layerslider" style=" width: 100%; height: 500px; margin: 0px auto; ">

                    <div class="ls-layer" >

                        <img src="img/layer-slide1.png" class="ls-bg" alt="Slide background" />
                    <!--
                        <img class="ls-s-1" src="img/iphone.png" style="position: absolute; top: 250px; left: 480px; slidedirection : right; slideoutdirection : left; durationin : 1000; durationout : 1000; easingin : easeInOutQuart; easingout : easeInOutQuint; " />

                        <img class="ls-s-1" src="img/ipad.png" style="position: absolute; top: 100px; left: 720px; slidedirection : right; slideoutdirection : left; durationin : 1000; durationout : 1000; easingin : easeInOutQuart; easingout : easeInOutQuint; delayin : 200;" />

                        <img class="ls-s-1" src="img/minipad.png" style="position: absolute; top: 140px; left: 900px; slidedirection : right; slideoutdirection : left; durationin : 1000; durationout : 1000; easingin : easeInOutQuart; easingout : easeInOutQuint; delayin : 800;" />

                        <img class="ls-s-1" src="img/dispGooglePlay.png" style="position: absolute; top:100px; left: 0px; padding-left:10px; slidedirection : bottom; slideoutdirection : right; durationin : 2000; durationout : 1000; easingin : easeOutElastic; easingout : easeInOutQuint; delayin : 1500;">

                      				<h1 class="ls-s-1" style="position: absolute; font:   top:140px; left: 50px; padding-left:10px; slidedirection : bottom; slideoutdirection : right; durationin : 2000; durationout : 1000; easingin : easeOutElastic; easingout : easeInOutQuint; delayin : 1500;">
                                                                DISPONIBLE EN 
                                                                GOOGLE PLAY STORE
                                                        </h1>
                       


                        <img class="ls-s-1" src="img/clickDescargar.png" style="position: absolute; top:223px; left: 10px; slidedirection : bottom; slideoutdirection : right; durationin : 1000; durationout : 1000; easingin : easeInOutQuart; easingout : easeInOutQuint; delayin : 2000;">

                        <img class="ls-s-1" src="img/googlePlay.png" style="position: absolute; top:293px; left: 10px; slidedirection : bottom; slideoutdirection : right; durationin : 1000; durationout : 1000; easingin : easeInOutQuart; easingout : easeInOutQuint; delayin : 2500;">
 -->
 
					<h1 class="ls-s-8" style="position: absolute; top:100px; left: 150px; padding-left:10px;">
                       Despacho automático e inteligente de viajes <br>
                    </h1>
                    <h2 class="ls-s-8" style="position: absolute; top:250px; left: 490px; padding-left:10px;">
                     
                       <a href="../pages/contacto" class="btn btn-sm btn-primary style="color: #fff">PROBAR AHORA</a>
                    </h2>
                    
                   
                    
                    
                    </div>


                    <div class="ls-layer" >

                        <img src="img/layer-slide2.png" class="ls-bg" alt="Slide background">

                      
 
					<h1 class="ls-s-8" style="position: absolute; top:100px; left: 75px; padding-left:10px;">
                       Ahorre costos tomando el control total de su flota <br>
                    </h1>
                    <h2 class="ls-s-8" style="position: absolute; top:250px; left: 490px; padding-left:10px;">
                     
                       <a href="../pages/contacto" class="btn btn-sm btn-primary">PROBAR AHORA</a>
                    </h2>
                    </div>
  
                     <div class="ls-layer" >

                        <img src="img/layer-slide3.png" class="ls-bg" alt="Slide background">

                        <!--
                        <img class="ls-s-1" src="img/miraComoFunciona.png" style=" position: absolute; top: 90px; left: 10px; slidedirection : top; slideoutdirection : left;  durationin : 2000; durationout : 11000; easingin : easeOutElastic; easingout : linear; delayin :200; " />


                        <img class="ls-s-1" src="img/haceClick.png" style="position: absolute; top: 215px; left: 10px; slidedirection : right; slideoutdirection : right;  durationin : 500; durationout : 1500; easingin : linear; easingout : linear; delayin : 1500;  " />



-->
                        <div class="ls-s2 " style=" position: absolute; top: 60px; left: 600px; slidedirection : bottom; slideoutdirection : bottom;  durationin : 1500; durationout : 1750; easingin : easeInOutQuint; easingout : easeInBack; delayin : 500;">
                            <?php if (!IS_DEVELOPMENT_SERVER): ?>
                                <iframe src="//www.youtube.com/embed/ZoPULUq3OTI?autoplay=0” frameborder=”0″ allowfullscreen" width="547" height="359" style="border: none;"></iframe>
                            <?php endif; ?>
                        </div>



                    </div>

                   
                </div>
            </div>
        </div>
    </section>


    <section id="content">
        <!-- about -->
        <!-- <section id="about"  class="pt30 pb30 color1" style = "background-size: cover; background-image: url('img/seccion2.png'); "> -->
        	<section id="about"  class="pt30 pb30 color1" style = "background-size: cover; background-color: #FFF; ">

            <div class="container">

                <div class="row" >

                    <div class="col-md-2">
                       <img src="img/iconoCQV.png"  alt="services" class="img-responsive"> 
                    </div>
                    <div class="col-md-5">
                        <h2 style="color: #994c06; font-size: 20px; "> Aplicaciones para dispositivos móviles</h2>
                        <p style="color: #514E4C; text-align : justify;"> Brindamos un servicio para que su empresa gestione la flota y pueda dar de alta conductores y vehículos. </p>
                        <p style="color: #514E4C; text-align : justify;"> App para pasajeros : mediante esta aplicación sus clientes podrán pedir vehículos de su empresa desde un smartphone gratuitamente </p>
                        <p style="color: #514E4C; text-align : justify;"> 
App para conductores: Los conductores aceptan los pedidos del operador y los de pasajeros en otra aplicación.
 </p>
                    </div>
                    <div class="col-md-5" style=" float: left; " >
                        <h2 style="color: #994c06; font-size: 20px; ">Automatización de pedidos telefónicos</h2>
                        
                        <p style="color: #514E4C; text-align : justify;">
Nuestro servicio permite ahorrar un 50% en los costos operativos de su empresa debido a grandes automatizaciones.
	                    </p>                        
                        <p style="color: #514E4C; text-align : justify;">
El módulo "preatendedor automático de llamadas" (IVR) permite atender y despachar de forma automática los llamados telefonicos.
                        </p>
                         <p style="color: #514E4C; text-align : justify;">
Los pedidos ingresados por un operador son despachados de forma inteligente al vehículo mas cercano a la dirección ingresada.
                        </p>
                    </div>
                </div>

            </div>

        </section>
        <!-- about -->

        <section id="projects" class="color2 pt30 pb30" style=" background-image: url('img/fondo-usuarios2.png');">
            <div class="container">
                <div class="row mt15">
                    <div class="col-md-12">
                        <h2 style="color: #994c06"> Espacio de trabajo en tiempo real que permite a su empresa despachar mas viajes en menos tiempo. </h2>
                        
                   
                    </div>
                </div>
                <section id="carouselWorks3" class="owl-carousel pt30 pb30 imgHover" >
                    <!-- portfolio item -->
                    <article class="item">
                        <section class="imgWrapper">
                            <img alt="" src="img/visualizacion.png" class="img-responsive">
                        </section>
                       <!--
                        <div class="mediaHover">
                            <div class="mask"></div>
                            <div class="iconLinks"> 
                                <a href="pages/faq-conductores?p=1" title="link">
                                    <i class="icon-picture iconRounded iconMedium"></i>
                                    <span>link</span>
                                </a> 

                            </div>
                        </div>
                       -->
                        <section class="boxContent">
                           <h2 style="font-size: 18.14px; color: #994c06">VISUALIZACIÓN</h2>
                            <p style="color: #994c06; Gotham-Bold"> 
                                    Permite ver el estado de los vehículos, ya sea esten libres, ocupados, fuera de línea o alguno de sus conductores haya presionado el botón de pánico en su aplicación.
                                    Se puede hacer seguimiento de vehiculos con zoom o filtro de busqueda.
                            </p>
                        </section>
                    </article>
                    <!-- portfolio item -->
                    <article class="item">
                        <section class="imgWrapper">
                            <img alt="" src="img/login-directo.png" class="img-responsive">
                        </section>
                        
                      
                        <section class="boxContent">
                            <h2 style="font-size: 18.14px; color: #AE631E">DESPACHO DE VIAJES</h2>
                            <p style="color: #AE631E; Gotham-Bold.otf"> 
                                En esta sección el operador puede asignar viajes a los vehiculos cercanos, reasignarlos, ver su estado o cancelarlos.
                                Hay dos formas de asignación al vehiculo mas cercano o a uno determinado. 
                               
                            </p>
                            
                        </section>
                    </article>
                    <!-- portfolio item -->
                    <article class="item">
                        <section class="imgWrapper">
                            <img alt="" src="img/gestion_flota.png" class="img-responsive">
                        </section>
                        <!--
                        <div class="mediaHover">
                            <div class="mask"></div>
                            <div class="iconLinks"> 
                                <a href="pages/faq-conductores?p=3" title="link">
                                    <i class="icon-picture iconRounded iconMedium"></i>
                                    <span>link</span>
                                </a> 

                            </div>
                        </div>
                        -->
                        <section class="boxContent">
                           <h2 style="font-size: 18.14px; color: #994c06">GESTIÓN DE FLOTA</h2>
                            <p style="color: #994c06 ; Gotham-Bold"> 
                                Sección que permite dar de alta, baja, modificar, habilitar, deshabilitar y ver las calificaciones asignadas por sus clientes tanto a vehículos como a conductores. Además, se permite la creación de mas operadores.
                            </p>
                           
                        </section>
                    </article>
                    <!-- portfolio item -->
                    <article class="item">
                        <section class="imgWrapper">
                            <img alt="" src="img/estadisticas.png" class="img-responsive">
                        </section>
                        <!--
                        <div class="mediaHover">
                            <div class="mask"></div>
                            <div class="iconLinks"> 
                                <a href="pages/faq-conductores?p=4" title="link">
                                    <i class="icon-picture iconRounded iconMedium"></i>
                                    <span>link</span>
                                </a> 

                            </div>   
                        </div>
                        -->
                        <section class="boxContent">
                            
                            <h2 style="font-size: 18.14px; color: #994c06">ESTADÍSTICAS</h2>
                            <p style="color: #994c06; Gotham-Bold"> 
Ofrece información relativa a los viajes de su empresa, para saber cuantos viajes fueron despachados, cuantos se han atendidos, cuantos clientes piden a través de la app para celulares, entre otras cosas.
                            </p>
                            
                        </section>
                    </article>

                </section>
            </div>
        </section>

	<section id="paralaxSlice5" data-stellar-background-ratio="0.5" style="background-color: #555555;">
						<div class="maskParent" style="color: #994c06; font-family: Gotham-Bold ;">
							<div class="paralaxMask"></div>
							<div class="paralaxText">
								<blockquote>
									<i>Miles de usuarios realizan viajes a través de nuestra aplicación para pasajeros</i>
								</blockquote>
							</div>
						</div>
					</section>


        <section class="30 pb30" style=" background-color:#FFF;" >
            <div class="container pt30" >
                <div class="col-md-12 " style="margin-top: 30px;">
                    
                    <h2 style="color: #994c06"> PRECIOS y PLANES </h2>
                    <p>SOLICITA UNA PRUEBA GRATUITA PARA TU EMPRESA</p>
                    <p style=""> CONSULTA POR DIFERENTES CONDICIONES DE VENTA</p>

                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="pricingBloc">
                            <h2>BRONCE</h2>
                           
                            <ul>
						<li>1 Operador </li>
						<li>Visualización en cartografia</li>
						<li >Gestión de flota</li>
						<li>Estadísticas </li>
						<li >Mensajes central - conductor</li>
						<li >Aplicación para pasajeros</li>
						<li >Aplicación para conductores</li>
						<li >Hasta 100 vehículos</li>
						<li >Soporte</li>
						<li >Hosting</li>

                            </ul>
                            <p class="sign">
                                <a href="../pages/contacto" class="btn" style="font-size: 16px; color: #FFF;">
                                    Consultar
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="pricingBloc">
                            <h2>PLATA</h2>
                            
                                       <ul>
						<li>2 Operador </li>
						<li>Visualización en cartografia</li>
						<li >Gestión de flota</li>
						<li>Estadísticas </li>
						<li >Mensajes central - conductor</li>
						<li >Aplicación para pasajeros</li>
						<li >Aplicación para conductores</li>
						<li >Hasta 500 vehículos</li>
						<li >Soporte </li>
						<li >Hosting</li>

                          </ul>


                            <p class="sign">
                                <a href="../pages/contacto" class="btn" style="font-size: 16px; color: #FFF;">
                            	Consultar
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="pricingBloc">
                            <h2>ORO</h2>
                                  <ul>
						<li>4 Operador </li>
						<li>Visualización en cartografia</li>
						<li >Gestión de flota</li>
						<li>Estadísticas </li>
						<li >Mensajes central - conductor</li>
						<li >Aplicación para pasajeros</li>
						<li >Aplicación para conductores</li>
						<li >Hasta 1000 vehículos</li>
						<li >Soporte </li>
						<li >Hosting</li>

                          </ul>                            <p class="sign">
                                <a href="../pages/contacto" class="btn" style="font-size: 16px; color:#FFF;">
                                    Consultar
                                </a>
                            </p>
                        </div>
                    </div>
                   
                </div>
            </div>
        </section>
        
				<section style="background-color: #fff;">
					<div class="container" >
						<div class="row pt30 pb15">
							<div class="col-md-6">
								<img src="img/su_empresa.png" alt="services" class="img-responsive">
							</div>
							<div class="col-md-6">
								<h2>Nuestra empresa también permite que pueda hacer crecer su propia marca</h2>
								<h4>Si bien nuestros clientes pueden crecer y obtener viajes a través de la marca Con quién viajo,
									no los limitamos a ello, y las empresas que quieran tener su propia aplicación para smartphones
									también pueden hacerlo adquiriendo nuestros productos y servicios de marca blanca. </h4>
								<h4>Sin embargo, remarcamos los beneficios de adquirir todo el paquete en forma de servicio
									<br>
									<br>
									- Baja inversión inicial.
									<br>
									- Bajos costos de infraestructura.
									<br>
									- Acceso a futuras actualizaciones en las aplicaciones.
									<br>
									- Soporte incluido.
									</h4>
									<br>
									 <a href="../pages/contacto" class="btn" style="font-size: 16px; color: #FFF;">
                                    Consultar
                                </a>
							</div>
							
						</div>
					
					</div>

					</section>
        
        

    <!-- ======================================= End content ======================================= -->