<?php echo e(HTML::style('css/informaweb.css')); ?>


<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-addresses">
    <div class="tab-content">
        <div class="panel infolist">
            <div class="panel-default panel-heading">
                <h4><?php echo e(__('Addresses')); ?>

                    <?php if(LAFormMaker::la_access("Addresses", "create")) { ?>
                        <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddAddressModal"><?php echo e(__('Add Address')); ?></button>
                    <?php } ?>
                </h4>
            </div>
        </div>
        <div class="row">
            <?php $__currentLoopData = array_chunk($account->addresses->all(),3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="row">
                    <?php $__currentLoopData = $row; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4 col-sm-12"  style = "padding-bottom: 15px; padding-top: 15px;">
                            <div class="panel panel-default" id="address_panel_<?php echo e($address->id); ?>">
                                <div class="panel-heading" >
                                    <div class="row" style="text-align: center;">
                                        <span id="address_panel_title_<?php echo e($address->id); ?>" class="col-sm-10 col-md-10 label label-primary" style = "margin-left: 2px; padding-bottom: 5px; padding-top: 5px;">
                                            <?php echo LAFormMaker::displayField($address, 'address_type_id', 'Addresses', 'true'); ?>
                                        </span>
                                        <div style="margin-right: 3px;" id="address-panel">
                                            <?php echo Form::open(['action' => ['LA\AddressesController@delete_address',$address->id], 'id' => 'address-delete-modal-form', 'method' => 'POST']); ?>

                                            <input type="hidden" name="accountId" value=<?php echo e($account->id); ?>>
                                                <button class="btn btn-xs pull-right btn-danger btn-hidden" type="button" data-toggle="modal" data-target="#confirmDelete" data-title='<?php echo e(__('Delete Address')); ?>' data-message= '<?php echo e(__('Are you sure you want to delete this address ?')); ?>' >
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </button>
                                            <?php echo e(Form::close()); ?>

                                            <?php if(LAFormMaker::la_access("Addresses", "edit")) { ?>
                                                <?php echo iWHelper::print_modal_editor('Addresses', $address); ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-10 col-md-10">
                                        <h3 class="panel-title" style = "padding-bottom: 3px; padding-top: 3px;" id="address_panel_descr_<?php echo e($address->id); ?>">
                                            <?php echo LAFormMaker::displayField($address, 'street', 'Addresses'); ?>
                                            <br/>
                                            
                                            
                                            <?php if( is_null($address->locality) ): ?>

                                            <?php else: ?>
                                                <?php echo e($address->locality->getLocalityString()); ?>

                                            <?php endif; ?>
                                            <br/>
                                            
                                            <?php echo LAFormMaker::displayField($address, 'note', 'Addresses'); ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<?php echo $__env->make('la.accounts.modal.delete_confirm', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('la.accounts.modal.address_create', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('la.accounts.modal.address_edit', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->startPush('scripts'); ?>
    <script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $(document).ready(function(){
        $("#address-panel .editModalBtn").on("click", function() {
            var info = JSON.parse($(this).attr("info"));
            var select_fields = ",address_type_id,";
            var addressId = info.id;
            var url = $("#address-edit-modal-form").attr("action");
            index = url.lastIndexOf("/");
            url2 = $("#urlController").val()+'/editModalAddress/'+info.id;
            $("#address-update-form").attr("action", url2)
            $.ajax({
                url: $("#urlController").val()+'/editModalAddress/'+info.id,
                method: 'GET',
                dataType: "json",
                success: function(data){
                    info = data;
                    $('#addressId').val(info.id);
                    $.each(data, function(index, value) {
                        if ( select_fields.search(','+index+',') == -1 ) {
                            $("#address-edit-modal-form input[name="+index+"]").val(value);
                        } else {
                            $("#address-edit-modal-form select[name="+index+"]").val(value).change();
                        }
                    });
                    $("#address-edit-modal-form input[name=localityString]").val(data.locality);
                    $("#address-edit-modal-form input[name=inputLocalityString]").val(data.locality);
                    $("#address-edit-modal-form").attr("action", url2)
                    $("#EditModalAddress").modal("show");
                },
                error: function(data){
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            });
        });
    });

    </script>
<?php $__env->stopPush(); ?>
