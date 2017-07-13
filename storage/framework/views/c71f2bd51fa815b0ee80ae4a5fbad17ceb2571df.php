<?php if(LAFormMaker::la_access("Contacts", "create")) { ?>
<div class="modal fade" id="AddContactModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                
                
                <h4 class="modal-title" id="myModalLabel"><?php echo e(__('Add Contact')); ?></h4>
            </div>
            <form action="<?php echo e(url(config('laraadmin.adminRoute') . '/add_contact/'.$account->id)); ?>" method="post" id="create-contact-modal">
            
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
            <div class="modal-body">
                <div class="box-body">
                    <?php ($fields = array('title_id','contact_type_id','office_id','first_name','last_name','notes')); ?>
                    <?php echo LAFormMaker::formMultiple("Contacts", $fields); ?>

                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><?php echo e(__('Save')); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                
            </div>
            </form>
            
        </div>
    </div>
</div>
<?php } ?>


<?php $__env->startPush('scripts'); ?>
    <script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $(document).ready(function(){
        $("#create-contact-modal").validate({
            // rules: {
            //      // The key name on the left side is the name attribute
            //      // of an input field. Validation rules are defined
            //      // on the right side
            //      notes: "required",
            //    },
            //    // Specify validation error messages
            //    messages: {
            //      notes: "Please enter your firstname",
            //      first_name: "Pipppppo",
            //    },
        });
    });

    </script>
<?php $__env->stopPush(); ?>
