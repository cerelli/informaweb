<?php if(LAFormMaker::la_access("Addresses", "edit")) { ?>
<div class="modal modal-wide fade" id="EditModalAddress" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo e(__('Edit Address')); ?></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                <input type="hidden" id="addressId" value="">
                <input type="hidden" id="urlController" value="<?php echo e(url(config('laraadmin.adminRoute'))); ?>">

                <?php echo Form::open(['action' => ['LA\AddressesController@updateModalAddress',1], 'id' => 'address-edit-modal-form', 'method' => 'POST']); ?>

                    <input type="hidden" id="account_id" name="account_id" value=<?php echo e($account->id); ?>>
                    <div class="box-body">
                        <?php ($fields = array('address_type_id','street')); ?>
                        <?php echo LAFormMaker::formMultiple("Addresses", $fields); ?>
                        
                        <input type="text" style="width: 100%;" id="localityString" name="localityString" value="" readonly placeholder="<?php echo e(__("Select locality below")); ?>" class="form-control">

                        
                        <input type="hidden" name="inputLocalityString" value="">
                        <?php ($fields = array('note')); ?>
                        <br/>
                        <?php echo LAFormMaker::formMultiple("Addresses", $fields); ?>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-right" style="margin-left: 3px" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                        <?php echo Form::submit( __('Save'), ['id'=>'submitAddr', 'class'=>'btn btn-success pull-right']); ?>

                    </div>

                <?php echo Form::close(); ?>

                    <hr size="5">
                    <h4 class="modal-filtre-title" ><?php echo e(__('Localities')); ?></h4>
            <form id="form-filter" class='filter-form'>
                <input type="hidden" id="localityId" name="localityId" value="">
                </form>
                    <table id="example1" class="datatable table table-bordered display" style="width: 100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th><?php echo e(__('Postal Code')); ?></th>
                                <th><?php echo e(__('Place Name')); ?></th>
                                <th><?php echo e(__('Province Code')); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th><?php echo e(__('Postal Code')); ?></th>
                                <th><?php echo e(__('Place Name')); ?></th>
                                <th><?php echo e(__('Province Code')); ?></th>
                            </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>


            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php echo $__env->make('la.accounts.modal.delete_confirm', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('la-assets/plugins/datatables/datatables.min.css')); ?>"/>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('la-assets/plugins/datatables/datatables.min.js')); ?>"></script>
<script>
    $(document).ready(function(){
        var table = $('#example1').DataTable({
                                responsive: true,
                                processing: true,
                                serverSide: true,
                                ajax: "<?php echo e(url(config('laraadmin.adminRoute') . '/locality_select_dtajax')); ?>",
                                language: {
                                    lengthMenu: "_MENU_",
                                    searchPlaceholder: "Search"
                                },
                                columnDefs: [
                                    { targets: [0], visible: false },
                                    { targets: [1], width: "20%" },
                                    { targets: [2], width: "70%" },
                                    { targets: [3], width: "10%" }
                                ],
                            });


        $('#example1 thead th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );

        // Apply the search
        table.columns().every( function () {
            var that = this;

            $( 'input', this.header() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        $('#example1 tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    $("#EditModalAddress input[name=localityString]").val("");
                    $("#EditModalAddress input[name=inputLocalityString]").val("");
                }
                else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    console.log(table.row(this).data()[0]);
                    $("#EditModalAddress input[name=localityId]").val(table.row(this).data()[0]);
                    var locality = table.row(this).data()[1]+' '+table.row(this).data()[2];
                    if ( table.row(this).data()[3] == '' ) {
                        $("#EditModalAddress input[name=localityString]").val(locality);
                        $("#EditModalAddress input[name=inputLocalityString]").val(locality);
                    }else {
                        locality += ' ('+table.row(this).data()[3]+')';
                        $("#EditModalAddress input[name=localityString]").val(locality);
                        $("#EditModalAddress input[name=inputLocalityString]").val(locality);
                    }

                }
            } );

            $('#locality_selected').click( function () {
                table.row('.selected').remove().draw( false );
            } );

    });

    $("#address-edit-modal-form").validate({
        lang: 'it',
        // Specify validation rules
        rules: {
          // The key name on the left side is the name attribute
          // of an input field. Validation rules are defined
          // on the right side
          localityString: "required"
        },
        // Specify validation error messages
        messages: {
          localityString: "<?php echo e(__("Select locality below")); ?>",
          lastname: "Please enter your lastname"
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function(e) {
            // console.log('pippo');
            // $('#submitAddr').on( 'click', function (e) {
            // $('#address-edit-modal-form').on('submit', function(e){
                console.log('prova');
                var addressId = $("#addressId").val();
                var info = JSON.parse($('#editModalBtn_'+addressId).attr('info'));
                var newURL = '<?php echo route(config('laraadmin.adminRoute') . '.updateModalAddress',1); ?>';
                index = newURL.lastIndexOf("/");
                newURL = newURL.substring(0, index+1)+addressId;console.log(newURL);
                $.ajax({
                    url: newURL,
                    type: 'POST',
                    dataType: 'json',
                    data: $("form#address-edit-modal-form").serialize(),
                    success: function(data){
                        console.log(data);
                        var titolo = data.street+'<br/>'+data.localityString+'<br/>'+data.note;
                        $('#address_panel_descr_'+addressId+'.panel-title').html(titolo);
                        titolo = data.address_type_description;
                        $('#address_panel_title_'+addressId).html(titolo);
                        $('#EditModalAddress').modal('hide');
                    },
                    error: function(data){
                    }
                });
            // });
        }
      });


  </script>
<?php $__env->stopPush(); ?>
