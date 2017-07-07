@la_access("Addresses", "create")
<div class="modal modal-wide fade" id="AddAddressModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ __('Add Contact') }}</h4>
            </div>
            {{-- {!! Form::open(['action' => ['LA\AddressesController@updateModalAddress',1], 'id' => 'address-edit-modal-form', 'method' => 'POST']) !!} --}}
            <form action="{{ url(config('laraadmin.adminRoute') . '/add_address/'.$account->id) }}" method="post" id="address-create-modal-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="modal-body">
                <div class="box-body">
                    @php ($fields = array('address_type_id','street'))
                    @la_formMultiple("Addresses", $fields)
                    {{-- @if ( is_null($address->locality) )
                        @php ($valueLocality = "")
                    @else
                        @php ($valueLocality = $address->locality->getLocalityString())
                    @endif --}}

                    <input type="hidden" id="locality_id" name="locality_id" value="">
                    <input type="hidden" id="account_id" name="account_id" value={{ $account->id }}>
                    <input type="text" style="width: 100%;" id="localityString" name="localityString" value="" readonly placeholder="{{ __("Select locality below") }}" class="form-control">

                    @php ($fields = array('note'))
                    @la_formMultiple("Addresses", $fields)

                    {{--
                    @la_input($module, 'title_id')
					@la_input($module, 'is_person')
					@la_input($module, 'name1')
					@la_input($module, 'name2')
					@la_input($module, 'notes')
					@la_input($module, 'account_account_type')
					@la_input($module, 'account_user')
                    --}}
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
                </form>
                <hr size="5">
                <h4 class="modal-filtre-title" >{{ __('Localities') }}</h4>
                <form id="form-filter-add" class='filter-form-add'>
                    {{-- <input type="hidden" id="localityIdAdd" name="localityIdAdd" value=""> --}}
                    </form>
            <table id="example5" class="datatable table table-bordered display" style="width: 100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('Postal Code') }}</th>
                        <th>{{ __('Place Name') }}</th>
                        <th>{{ __('Province Code') }}</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('Postal Code') }}</th>
                        <th>{{ __('Place Name') }}</th>
                        <th>{{ __('Province Code') }}</th>
                    </tr>
                </tfoot>
                <tbody>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endla_access

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $("#address-create-modal-form").validate({
            lang: 'it',
            rules: {
              localityString: "required"
            },
            messages: {
              localityString: "{{ __("Select locality below") }}",
            },
          });

        var table_add = $('#example5').DataTable({
              responsive: true,
              processing: true,
              serverSide: true,
              ajax: "{{ url(config('laraadmin.adminRoute') . '/locality_select_dtajax') }}",
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
@endpush
