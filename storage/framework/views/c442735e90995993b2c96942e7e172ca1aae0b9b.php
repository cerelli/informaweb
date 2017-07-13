<!-- Main Header -->
<header class="main-header">

	<?php if(LAConfigs::getByKey('layout') != 'layout-top-nav'): ?>
	<!-- Logo -->
	<a href="<?php echo e(url(config('laraadmin.adminRoute'))); ?>" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b><?php echo e(LAConfigs::getByKey('sitename_short')); ?></b></span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b><?php echo e(LAConfigs::getByKey('sitename_part1')); ?></b>
		 <?php echo e(LAConfigs::getByKey('sitename_part2')); ?></span>
	</a>
	<?php endif; ?>

	<!-- Header Navbar -->
	<nav class="navbar navbar-static-top" role="navigation">
	<?php if(LAConfigs::getByKey('layout') == 'layout-top-nav'): ?>
		<div class="container">
			<div class="navbar-header">
				<a href="<?php echo e(url(config('laraadmin.adminRoute'))); ?>" class="navbar-brand"><b><?php echo e(LAConfigs::getByKey('sitename_part1')); ?></b><?php echo e(LAConfigs::getByKey('sitename_part2')); ?></a>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>
			</div>
			<?php echo $__env->make('la.layouts.partials.top_nav_menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			<?php echo $__env->make('la.layouts.partials.notifs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		</div><!-- /.container-fluid -->
	<?php else: ?>
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle b-l" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<?php echo $__env->make('la.layouts.partials.notifs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php endif; ?>
	
	</nav>
</header>
