<?php
use Dwij\Laraadmin\Models\Module;
?>

<?php $__env->startSection("contentheader_title", "Menus"); ?>
<?php $__env->startSection("contentheader_description", "Editor"); ?>
<?php $__env->startSection("section", "Menus"); ?>
<?php $__env->startSection("sub_section", "Editor"); ?>
<?php $__env->startSection("htmlheader_title", "Menu Editor"); ?>

<?php $__env->startSection("headerElems"); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("main-content"); ?>

<div class="box box-success menus">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<div class="row">
			<div class="col-md-4 col-lg-4">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-modules" data-toggle="tab">Modules</a></li>
						<li><a href="#tab-custom-link" data-toggle="tab">Custom Links</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab-modules">
							<ul>
							<?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<li><i class="fa <?php echo e($module->fa_icon); ?>"></i> <?php echo e($module->label); ?> <a module_id="<?php echo e($module->id); ?>" class="addModuleMenu pull-right"><i class="fa fa-plus"></i></a></li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
						<div class="tab-pane" id="tab-custom-link">

							<?php echo Form::open(['action' => '\Dwij\Laraadmin\Controllers\MenuController@store', 'id' => 'menu-custom-form']); ?>

								<input type="hidden" name="type" value="custom">
								<div class="form-group">
									<label for="url" style="font-weight:normal;">URL</label>
									<input class="form-control" placeholder="URL" name="url" type="text" value="http://" data-rule-minlength="1" required>
								</div>
								<div class="form-group">
									<label for="name" style="font-weight:normal;">Label</label>
									<input class="form-control" placeholder="Label" name="name" type="text" value=""  data-rule-minlength="1" required>
								</div>
								<div class="form-group">
									<label for="icon" style="font-weight:normal;">Icon</label>
									<div class="input-group">
										<input class="form-control" placeholder="FontAwesome Icon" name="icon" type="text" value="fa-cube"  data-rule-minlength="1" required>
										<span class="input-group-addon"></span>
									</div>
								</div>
								<input type="submit" class="btn btn-primary pull-right mr10" value="Add to menu">
							<?php echo Form::close(); ?>

						</div>
					</div><!-- /.tab-content -->
				</div><!-- nav-tabs-custom -->
			</div>
			<div class="col-md-8 col-lg-8">
				<div class="dd" id="menu-nestable">
					<ol class="dd-list">
						<?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php echo LAHelper::print_menu_editor($menu); ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ol>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="EditModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Edit Menu Item</h4>
			</div>
			<?php echo Form::open(['action' => ['\Dwij\Laraadmin\Controllers\MenuController@update', 1], 'id' => 'menu-edit-form']); ?>

			<input name="_method" type="hidden" value="PUT">
			<div class="modal-body">
				<div class="box-body">
                    <input type="hidden" name="type" value="custom">
					<div class="form-group">
						<label for="url" style="font-weight:normal;">URL</label>
						<input class="form-control" placeholder="URL" name="url" type="text" value="http://" data-rule-minlength="1" required>
					</div>
					<div class="form-group">
						<label for="name" style="font-weight:normal;">Label</label>
						<input class="form-control" placeholder="Label" name="name" type="text" value=""  data-rule-minlength="1" required>
					</div>
					<div class="form-group">
						<label for="icon" style="font-weight:normal;">Icon</label>
						<div class="input-group">
							<input class="form-control" placeholder="FontAwesome Icon" name="icon" type="text" value="fa-cube"  data-rule-minlength="1" required>
							<span class="input-group-addon"></span>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<?php echo Form::submit( 'Submit', ['class'=>'btn btn-success']); ?>

			</div>
			<?php echo Form::close(); ?>

		</div>
	</div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('la-assets/plugins/nestable/jquery.nestable.js')); ?>"></script>
<script src="<?php echo e(asset('la-assets/plugins/iconpicker/fontawesome-iconpicker.js')); ?>"></script>
<script>
$(function () {
	$('input[name=icon]').iconpicker();

	$('#menu-nestable').nestable({
        group: 1
    });
	$('#menu-nestable').on('change', function() {
		var jsonData = $('#menu-nestable').nestable('serialize');
		// console.log(jsonData);
		$.ajax({
			url: "<?php echo e(url(config('laraadmin.adminRoute') . '/la_menus/update_hierarchy')); ?>",
			method: 'POST',
			data: {
				jsonData: jsonData,
				"_token": '<?php echo e(csrf_token()); ?>'
			},
			success: function( data ) {
				// console.log(data);
			}
		});
	});
	$("#menu-custom-form").validate({

	});


	$("#menu-nestable .editMenuBtn").on("click", function() {
		var info = JSON.parse($(this).attr("info"));

		var url = $("#menu-edit-form").attr("action");
		index = url.lastIndexOf("/");
		url2 = url.substring(0, index+1)+info.id;
		console.log(url2);
		$("#menu-edit-form").attr("action", url2);
		$("#EditModal input[name=url]").val(info.url);
		$("#EditModal input[name=name]").val(info.name);
		$("#EditModal input[name=icon]").val(info.icon);
		$("#EditModal").modal("show");
	});

	$("#menu-edit-form").validate({

	});

	$("#tab-modules .addModuleMenu").on("click", function() {
		var module_id = $(this).attr("module_id");
		$.ajax({
			url: "<?php echo e(url(config('laraadmin.adminRoute') . '/la_menus')); ?>",
			method: 'POST',
			data: {
				type: 'module',
				module_id: module_id,
				"_token": '<?php echo e(csrf_token()); ?>'
			},
			success: function( data ) {
				// console.log(data);
				window.location.reload();
			}
		});
	});
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make("la.layouts.app", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>