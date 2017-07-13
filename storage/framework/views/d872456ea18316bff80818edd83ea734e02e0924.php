<?php $__env->startSection("contentheader_title", "Accounts"); ?>
<?php $__env->startSection("contentheader_description", "Accounts listing"); ?>
<?php $__env->startSection("section", "Accounts"); ?>
<?php $__env->startSection("sub_section", "Listing"); ?>
<?php $__env->startSection("htmlheader_title", "Accounts Listing"); ?>

<?php $__env->startSection("headerElems"); ?>
<?php if(LAFormMaker::la_access("Accounts", "create")) { ?>
    <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal"><?php echo e(__('Add Account')); ?></button>
<?php } ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("main-content"); ?>

<?php if(count($errors) > 0): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<div class="box box-success">
    <!--<div class="box-header"></div>-->
    <div class="box-body">
        <table id="example1" class="table table-bordered">
        <thead>
        <tr class="success">
            <?php $__currentLoopData = $listing_cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($col === 'id'): ?>
                    <th><?php echo e(isset($module->fields[$col]['label']) ? $module->fields[$col]['label'] : __(ucfirst($col))); ?></th>
                <?php else: ?>
                    <th><?php echo e(__($module->fields[$col]['label'])); ?></th>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($show_actions): ?>
            <th><?php echo e(__('Actions')); ?></th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>

        </tbody>
        </table>
    </div>
</div>

<?php if(LAFormMaker::la_access("Accounts", "create")) { ?>
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo e(__('Add Account')); ?></h4>
            </div>
            <?php echo Form::open(['action' => 'LA\AccountsController@store', 'id' => 'account-add-form']); ?>

            <div class="modal-body">
                <div class="box-body">
                    <?php echo LAFormMaker::form($module); ?>

                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                <?php echo Form::submit( 'Submit', ['class'=>'btn btn-success']); ?>

            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
<?php } ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('la-assets/plugins/datatables/datatables.min.css')); ?>"/>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('la-assets/plugins/datatables/datatables.min.js')); ?>"></script>
<script>
$(function () {
    $("#example1").DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?php echo e(url(config('laraadmin.adminRoute') . '/account_dt_ajax')); ?>",
        language: {
            lengthMenu: "_MENU_",
            search: "_INPUT_",
            searchPlaceholder: "Search"
        },
        <?php if($show_actions): ?>
            columnDefs: [ { orderable: false, targets: [-1] }],
        <?php endif; ?>
    });
    $("#account-add-form").validate({

    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make("la.layouts.app", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>