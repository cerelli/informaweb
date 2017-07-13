<?php if(LAFormMaker::la_access("Contacts", "edit")) { ?>

<div class="modal fade" id="EditModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo e(__('Edit Contact')); ?></h4>
            </div>


            <div class="modal-body">
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                <input type="hidden" id="contactId" value="">
                <input type="hidden" id="urlController" value="<?php echo e(url(config('laraadmin.adminRoute'))); ?>">
                
                
                
                
                <?php echo Form::open(['action' => ['LA\ContactsController@updateModalContact',1], 'id' => 'contact-edit-modal-form', 'method' => 'POST']); ?>

                    <input type="hidden" name="accountId" value=<?php echo e($account->id); ?>>
                    <div class="box-body">
                        <?php ($fields = array('title_id','contact_type_id','office_id','first_name','last_name','notes')); ?>
                        <?php echo LAFormMaker::formMultiple("Contacts", $fields); ?>

                        
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
        $("#contact-edit-modal-form").validate({
            submitHandler: function(e) {
                    var contactId = $("#contactId").val();
                    var info = JSON.parse($('#editModalBtn_'+contactId).attr('info'));
                    var first_name = $("#formDati input[name=first_name]").val();
                    var contact_type_id = $("#formDati input[name=contact_type_id]").val();
                    var newURL = '<?php echo route(config('laraadmin.adminRoute') . '.updateModalContact',1); ?>';

                    index = newURL.lastIndexOf("/");
                    newURL = newURL.substring(0, index+1)+contactId;

                    $.ajax({
                        url: newURL,
                        type: 'POST',
                        dataType: 'json',
                        data: $("form#contact-edit-modal-form").serialize(),
                        success: function(data){
                            var title = '';
                            if ( data.title_description ) {
                                title = data.title_description+'<br/>';
                            }
                            console.log(data.title_description);
                            var titolo = title+data.first_name+' '+data.last_name+"<br/><span class='label label-primary' style='margin-right: 3px;'>"+data.contact_type_description+ "</span>"+"<span class='label label-primary'>"+data.office_description+ "</span><br/>"+data.notes;
                            $('#contact_panel_title_'+contactId+'.panel-title').html(titolo);
                            $('#EditModal').modal('hide');
                        },
                        error: function(data){
                        }
                    });
            }
          });
    });
    </script>
<?php $__env->stopPush(); ?>
