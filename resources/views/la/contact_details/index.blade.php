@extends("la.layouts.app")

@section("contentheader_title", "Contact details")
@section("contentheader_description", "Contact details listing")
@section("section", "Contact details")
@section("sub_section", "Listing")
@section("htmlheader_title", "Contact details Listing")

@section("headerElems")
@la_access("Contact_details", "create")
    <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">{{ __('Add Contact detail') }}</button>
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
        <table id="example1" class="table table-bordered">
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

@include('la.contact_details.modal.insert')


@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
    $("#example1").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/contact_detail_dt_ajax') }}",
        language: {
            lengthMenu: "_MENU_",
            search: "_INPUT_",
            searchPlaceholder: "Search"
        },
        @if($show_actions)
        columnDefs: [ { orderable: false, targets: [-1] }],
        @endif
    });
    $("#contact_detail-add-form").validate({

    });
});
</script>
@endpush
