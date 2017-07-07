@extends("la.layouts.app")

@section("contentheader_title", "Localities")
@section("contentheader_description", "Localities listing")
@section("section", "Localities")
@section("sub_section", "Listing")
@section("htmlheader_title", "Localities Listing")

@section("headerElems")
@la_access("Localities", "create")
    <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">{{ __('Add Locality') }}</button>
@endla_access
@endsection

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box box-success">
    <!--<div class="box-header"></div>-->
    <div class="box-body">
        <form class='filter-form'>
  <h3>Filters</h3>
  <div>
    <label>postal_code :</label>
    <input type='text' value='' class='filter' data-column-index='2'>
  </div>
  <div>
    <label>place_name :</label>
    <input type='text' value='' class='filter' data-column-index='3'>
  </div>
</form>
        <table id="example1" class="table table-bordered display">
        <thead>
        <tr class="success">
            
            @foreach( $listing_cols as $col )
                @if ($col === 'id')
                    <th>{{ $module->fields[$col]['label'] or __(ucfirst($col)) }}</th>
                @else
                    <th>{{ __($module->fields[$col]['label']) }}</th>
                @endif
            @endforeach
            @if($show_actions)
            <th>{{ __('Actions') }}</th>
            @endif
        </tr>
        </thead>
        <tbody>

        </tbody>
        </table>
    </div>
</div>

@la_access("Localities", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ __('Add Locality') }}</h4>
            </div>
            {!! Form::open(['action' => 'LA\LocalitiesController@store', 'id' => 'locality-add-form']) !!}
            <div class="modal-body">
                <div class="box-body">
                    @la_form($module)

                    {{--
                    @la_input($module, 'country_code')
					@la_input($module, 'postal_code')
					@la_input($module, 'place_name')
                    --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
                {!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endla_access

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
    $(document).ready(function() {
    var table = $('#example1').DataTable();

    $('.filter').on('keyup change', function() {
      //clear global search values
      table.search('');
      table.column($(this).data('columnIndex')).search(this.value).draw();
    });

    $(".dataTables_filter input").on('keyup change', function() {
        //clear column search values
        table.columns().search('');
        //clear input values
        $('.filter').val('');
    });

    $('#example1 tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

    } );

    $('#example1 tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );


    $("#example1").DataTable({
        pageLength: 20,
        processing: true,
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/locality_dt_ajax') }}",
        language: {
            lengthMenu: "_MENU_",
            search: "_INPUT_",
            searchPlaceholder: "Search"
        },
        @if($show_actions)
        columnDefs: [ { orderable: false, targets: [-1] }],
        @endif
    });

    $("#locality-add-form").validate({

    });
});
</script>
@endpush
