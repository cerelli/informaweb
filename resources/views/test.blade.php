@extends('master')
pippo
@section('content')
    <table class="table table-bordered" id="tablea-access_rights">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>acc_view</th>
                <th>acc_create</th>
                <th>acc_edit</th>
            </tr>
        </thead>
    </table>
@stop

@push('scripts')
<script>
$(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('test.data') !!}',
        columns: [
            { data: 'account_user_id', name: 'account_user_id' },
            { data: 'name', name: 'name' },
            { data: 'acc_view', name: 'acc_view' },
            { data: 'acc_create', name: 'acc_create' },
            { data: 'acc_edit', name: 'acc_edit' }
        ]
    });
    $("#tablea-access_rights").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url(config('laraadmin.adminRoute') . '/account_access_right') }}',
        columns: [
            { data: 'name', name: 'name'},
            { data: 'id', name: 'id' }

        ]
    });
});
</script>
@endpush
