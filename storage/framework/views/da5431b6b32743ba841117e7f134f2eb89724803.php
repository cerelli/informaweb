<?php $__env->startSection('htmlheader_title'); ?>
	Permission View
<?php $__env->stopSection(); ?>


<?php $__env->startSection('main-content'); ?>
<div id="page-content" class="profile2">
	<div class="bg-primary clearfix">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-3">
					<!--<img class="profile-image" src="<?php echo e(asset('la-assets/img/avatar5.png')); ?>" alt="">-->
					<div class="profile-icon text-primary"><i class="fa <?php echo e($module->fa_icon); ?>"></i></div>
				</div>
				<div class="col-md-9">
					<h4 class="name"><?php echo e($permission->$view_col); ?></h4>
					<div class="row stats">
						<div class="col-md-4"><i class="fa fa-facebook"></i> 234</div>
						<div class="col-md-4"><i class="fa fa-twitter"></i> 12</div>
						<div class="col-md-4"><i class="fa fa-instagram"></i> 89</div>
					</div>
					<p class="desc">Test Description in one line</p>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="dats1"><div class="label2">Admin</div></div>
			<div class="dats1"><i class="fa fa-envelope-o"></i> superadmin@gmail.com</div>
			<div class="dats1"><i class="fa fa-map-marker"></i> Pune, India</div>
		</div>
		<div class="col-md-4">
			<!--
			<div class="teamview">
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="<?php echo e(asset('la-assets/img/user1-128x128.jpg')); ?>" alt=""><i class="status-online"></i></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="<?php echo e(asset('la-assets/img/user2-160x160.jpg')); ?>" alt=""></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="<?php echo e(asset('la-assets/img/user3-128x128.jpg')); ?>" alt=""></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="<?php echo e(asset('la-assets/img/user4-128x128.jpg')); ?>" alt=""><i class="status-online"></i></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="<?php echo e(asset('la-assets/img/user5-128x128.jpg')); ?>" alt=""></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="<?php echo e(asset('la-assets/img/user6-128x128.jpg')); ?>" alt=""></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="<?php echo e(asset('la-assets/img/user7-128x128.jpg')); ?>" alt=""></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="<?php echo e(asset('la-assets/img/user8-128x128.jpg')); ?>" alt=""></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="<?php echo e(asset('la-assets/img/user5-128x128.jpg')); ?>" alt=""></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="<?php echo e(asset('la-assets/img/user6-128x128.jpg')); ?>" alt=""><i class="status-online"></i></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="<?php echo e(asset('la-assets/img/user7-128x128.jpg')); ?>" alt=""></a>
			</div>
			-->
			<div class="dats1 pb">
				<div class="clearfix">
					<span class="pull-left">Task #1</span>
					<small class="pull-right">20%</small>
				</div>
				<div class="progress progress-xs active">
					<div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
						<span class="sr-only">20% Complete</span>
					</div>
				</div>
			</div>
			<div class="dats1 pb">
				<div class="clearfix">
					<span class="pull-left">Task #2</span>
					<small class="pull-right">90%</small>
				</div>
				<div class="progress progress-xs active">
					<div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 90%" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
						<span class="sr-only">90% Complete</span>
					</div>
				</div>
			</div>
			<div class="dats1 pb">
				<div class="clearfix">
					<span class="pull-left">Task #3</span>
					<small class="pull-right">60%</small>
				</div>
				<div class="progress progress-xs active">
					<div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 60%" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
						<span class="sr-only">60% Complete</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-1 actions">
			<?php if(LAFormMaker::la_access("Permissions", "edit")) { ?>
				<a href="<?php echo e(url(config('laraadmin.adminRoute') . '/permissions/'.$permission->id.'/edit')); ?>" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
			<?php } ?>
			
			<?php if(LAFormMaker::la_access("Permissions", "delete")) { ?>
				<?php echo e(Form::open(['route' => [config('laraadmin.adminRoute') . '.permissions.destroy', $permission->id], 'method' => 'delete', 'style'=>'display:inline'])); ?>

					<button class="btn btn-default btn-delete btn-xs" type="submit"><i class="fa fa-times"></i></button>
				<?php echo e(Form::close()); ?>

			<?php } ?>
		</div>
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class=""><a href="<?php echo e(url(config('laraadmin.adminRoute') . '/permissions')); ?>" data-toggle="tooltip" data-placement="right" title="Back to Permissions"><i class="fa fa-chevron-left"></i></a></li>
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> General Info</a></li>
		<?php if (\Entrust::hasRole("SUPER_ADMIN")) : ?>
		<li class=""><a role="tab" data-toggle="tab" href="#tab-access" data-target="#tab-access"><i class="fa fa-key"></i> Access</a></li>
		<?php endif; // Entrust::hasRole ?>
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>General Info</h4>
					</div>
					<div class="panel-body">
						<?php echo LAFormMaker::display($module, 'name'); ?>
						<?php echo LAFormMaker::display($module, 'display_name'); ?>
						<?php echo LAFormMaker::display($module, 'description'); ?>
					</div>
				</div>
			</div>
		</div>
		<?php if (\Entrust::hasRole("SUPER_ADMIN")) : ?>
		<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-access">
			<div class="tab-content">
				<div class="panel infolist">
					<form action="<?php echo e(url('/admin/save_permissions/'.$permission->id)); ?>"  method="post">
					<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
						<div class="panel-default panel-heading">
							<h4>Permissions for Roles</h4>
						</div>
						<div class="panel-body">
							<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="form-group">
									<label for="ratings_innovation" class="col-md-2"><?php echo e($role->display_name); ?> :</label>
									<div class="col-md-10 fvalue star_class">
										<?php
										$query = DB::table('permission_role')->where('permission_id', $permission->id)->where('role_id', $role->id);
										?>
										<?php if($query->count() > 0): ?>
											<input type="checkbox" name="permi_role_<?php echo e($role->id); ?>" value="1" checked>
										<?php else: ?>
											<input type="checkbox" name="permi_role_<?php echo e($role->id); ?>" value="1">
										<?php endif; ?>
									</div>
								</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							
							<div class="form-group">
								<label for="ratings_innovation" class="col-md-2"></label>
								<div class="col-md-10 fvalue star_class">
									<input class="btn btn-success" type="submit" value="Save">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php endif; // Entrust::hasRole ?>
	</div>
	</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('la.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>