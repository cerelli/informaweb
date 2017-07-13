<!DOCTYPE html>
<html lang="en">

<?php $__env->startSection('htmlheader'); ?>
	<?php echo $__env->make('la.layouts.partials.htmlheader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldSection(); ?>
<body class="<?php echo e(LAConfigs::getByKey('skin')); ?> <?php echo e(LAConfigs::getByKey('layout')); ?> <?php if(LAConfigs::getByKey('layout') == 'sidebar-mini'): ?> sidebar-collapse <?php endif; ?>" bsurl="<?php echo e(url('')); ?>" adminRoute="<?php echo e(config('laraadmin.adminRoute')); ?>">
<div class="wrapper">

	<?php echo $__env->make('la.layouts.partials.mainheader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

	<?php if(LAConfigs::getByKey('layout') != 'layout-top-nav'): ?>
		<?php echo $__env->make('la.layouts.partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php endif; ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<?php if(LAConfigs::getByKey('layout') == 'layout-top-nav'): ?> <div class="container"> <?php endif; ?>
		<?php if(!isset($no_header)): ?>
			<?php echo $__env->make('la.layouts.partials.contentheader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php endif; ?>
		
		<!-- Main content -->
		<section class="content <?php echo e(isset($no_padding) ? $no_padding : ''); ?>">
			<!-- Your Page Content Here -->
			<?php echo $__env->yieldContent('main-content'); ?>
		</section><!-- /.content -->

		<?php if(LAConfigs::getByKey('layout') == 'layout-top-nav'): ?> </div> <?php endif; ?>
	</div><!-- /.content-wrapper -->

	<?php echo $__env->make('la.layouts.partials.controlsidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

	<?php echo $__env->make('la.layouts.partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</div><!-- ./wrapper -->

<?php echo $__env->make('la.layouts.partials.file_manager', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('scripts'); ?>
	<?php echo $__env->make('la.layouts.partials.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldSection(); ?>

</body>
</html>
