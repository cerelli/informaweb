<?php $__env->startSection("contentheader_title"); ?>
    <a href="<?php echo e(url(config('laraadmin.adminRoute') . '/accounts')); ?>">Account</a> :
<?php $__env->stopSection(); ?>
<?php $__env->startSection("contentheader_description", $account->$view_col); ?>
<?php $__env->startSection("section", "Accounts"); ?>
<?php $__env->startSection("section_url", url(config('laraadmin.adminRoute') . '/accounts')); ?>
<?php $__env->startSection("sub_section", "Edit"); ?>

<?php $__env->startSection("htmlheader_title", "Accounts Edit : ".$account->$view_col); ?>

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

<div class="box">
    <div class="box-header">

    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <?php echo Form::model($account, ['route' => [config('laraadmin.adminRoute') . '.accounts.update', $account->id ], 'method'=>'PUT', 'id' => 'account-edit-form']); ?>

                    <?php echo LAFormMaker::form($module); ?>
                    
                    <br>
                    <div class="form-group">
                        <?php echo Form::submit( 'Update', ['class'=>'btn btn-success']); ?> <a href="<?php echo e(url(config('laraadmin.adminRoute') . '/accounts')); ?>" class="btn btn-default pull-right">Cancel</a>
                    </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(function () {
    $("#account-edit-form").validate({

    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make("la.layouts.app", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>