<?php if(LAFormMaker::la_access("Contact_details", "edit")) { ?>

<div class="modal fade" id="EditDetailModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo e(__('Edit Contact Detail')); ?></h4>
            </div>


            <div class="modal-body">
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                <input type="hidden" id="contactId" value="">
                <input type="hidden" id="urlController" value="<?php echo e(url(config('laraadmin.adminRoute'))); ?>">
                <?php echo Form::open(['action' => ['LA\Contact_detailsController@updateModalContactDetail',1], 'id' => 'contact-detail-edit-modal-form', 'method' => 'POST']); ?>

                    <input type="hidden" name="accountId" value=<?php echo e($account->id); ?>>
                    <div class="box-body">
                        <?php ($fields = array('contact_detail_type_id','communication_type_id','value','notes')); ?>
                        <?php echo LAFormMaker::formMultiple("Contact_details", $fields); ?>
                    </div>

                    <button type="button" class="btn btn-default pull-right" style="margin-left: 3px" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                    <?php echo Form::submit( __('Save'), ['id'=>'submit', 'class'=>'btn btn-success pull-right']); ?>

                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php $__env->startPush('scripts'); ?>
    <script>
    $(document).ready(function(){
        $("#contact-detail-edit-modal-form").validate({
            submitHandler: function(e) {
                var contactId = $("#contactId").val();
                var newURL = '<?php echo route(config('laraadmin.adminRoute') . '.updateModalContactDetail',1); ?>';
                index = newURL.lastIndexOf("/");
                newURL = newURL.substring(0, index+1)+contactId;

                $.ajax({
                    url: newURL,
                    type: 'POST',
                    dataType: 'json',
                    data: $("form#contact-detail-edit-modal-form").serialize(),
                    success: function(data){
                        var test = $('#contact_detail_panel_'+contactId+'.details').html();
                        var textModified = '  <i class="fa '+data.contact_detail_type_fa_icon+'" style="margin-right: 3px;"></i><i class="fa '+ data.communication_type_fa_icon+'"  style="margin-right: 3px;"></i>'+data.value+'<br/><span style="font-style: italic;" >'+data.notes+'</span>  ';
                        $('#contact_detail_panel_'+contactId+'.details').html(textModified);
                        $('#EditDetailModal').modal('hide');
                    },
                    error: function(data){
                    }
                });
            }
          });
    });
    </script>
<?php $__env->stopPush(); ?>
