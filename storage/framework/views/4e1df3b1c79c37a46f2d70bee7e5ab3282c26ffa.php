<?php if(LAFormMaker::la_access("Addresses", "create")) { ?>
<div class="modal modal-wide fade" id="AddAddressModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo e(__('Add Contact')); ?></h4>
            </div>
            
            <form action="<?php echo e(url(config('laraadmin.adminRoute') . '/add_address/'.$account->id)); ?>" method="post" id="address-create-modal-form">
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
            <div class="modal-body">
                <div class="box-body">
                    <?php ($fields = array('address_type_id','street')); ?>
                    <?php echo LAFormMaker::formMultiple("Addresses", $fields); ?>
                    

                    <input type="hidden" id="locality_id" name="locality_id" value="">
                    <input type="hidden" id="account_id" name="account_id" value=<?php echo e($account->id); ?>>
                    <input type="text" style="width: 100%;" id="localityString" name="localityString" value="" readonly placeholder="<?php echo e(__("Select locality below")); ?>" class="form-control">

                    <?php ($fields = array('note')); ?>
                    <?php echo LAFormMaker::formMultiple("Addresses", $fields); ?>

                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><?php echo e(__('Save')); ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                </div>
                </form>
                <hr size="5">
                <h4 class="modal-filtre-title" ><?php echo e(__('Localities')); ?></h4>
                <form id="form-filter-add" class='filter-form-add'>
                    
                    </form>
            <table id="example5" class="datatable table table-bordered display" style="width: 100%">
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

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('la-assets/plugins/datatables/datatables.min.css')); ?>"/>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('la-assets/plugins/datatables/datatables.min.js')); ?>"></script>
<script>
    $(document).ready(function(){
        $("#address-create-modal-form").validate({
            lang: 'it',
            rules: {
              localityString: "required"
            },
            messages: {
              localityString: "<?php echo e(__("Select locality below")); ?>",
            },
          });

        var table_add = $('#example5').DataTable({
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


        $('#example5 thead th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );

        // Apply the search
        table_add.columns().every( function () {
            var that = this;

            $( 'input', this.header() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        $('#example5 tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    $("#AddAddressModal input[name=locality_id]").val("");
                    $("#AddAddressModal input[name=localityString]").val("");
                }
                else {
                    table_add.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    console.log(table_add.row(this).data()[0]);
                    $("#AddAddressModal input[name=locality_id]").val(table_add.row(this).data()[0]);
                    var locality = table_add.row(this).data()[1]+' '+table_add.row(this).data()[2];
                    if ( table_add.row(this).data()[3] == '' ) {
                        // $('[name="localityString"]').text(locality);
                        $("#AddAddressModal input[name=localityString]").val(locality);
                    }else {
                        locality += ' ('+table_add.row(this).data()[3]+')';
                        // $('[name="localityString"]').text(locality);
                        $("#AddAddressModal input[name=localityString]").val(locality);
                    }

                }
            } );

            $('#locality_selected').click( function () {
                table_add.row('.selected').remove().draw( false );
            } );


    });




  </script>
<?php $__env->stopPush(); ?>
