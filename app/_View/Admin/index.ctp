<header class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<h1> Admin </h1>
			</div>
			<div class="col-sm-6 hidden-xs">
				<ul id="navTrail">
					<li><a href="admin"> <?php echo __('Admin'); ?> </a></li>
					<li id="navTrailLast"> <?php echo __('Inicio'); ?> </li>
				</ul>
			</div>
		</div>
	</div>
</header>
<div class="container">
	<div class="row pt15">
		<aside id="sidebar" class="col-md-3">
			<nav id="subnav">
				<ul>
					<li><a href = '/empresas/view' class = "active"> <?php echo __('Empresas'); ?> <i class="icon-right-open"></i></a></li>
					<li><a href = '/usuarios/view' > <?php echo __('Usuarios'); ?> <i class="icon-right-open"></i></a></li>
					<li><a href = '/admin/logout' > <?php echo __('Cerrar sesión'); ?> <i class="icon-right-open"></i></a></li>
				</ul>
			</nav>
		</aside>
	</div>
</div>

