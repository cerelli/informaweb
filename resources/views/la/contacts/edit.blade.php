@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/contacts') }}">Contact</a> :
@endsection
@section("contentheader_description", $contact->$view_col)
@section("section", "Contacts")
@section("section_url", url(config('laraadmin.adminRoute') . '/contacts'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Contacts Edit : ".$contact->$view_col)

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

<div class="box">
    <div class="box-header">

    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                {!! Form::model($contact, ['route' => [config('laraadmin.adminRoute') . '.contacts.update', $contact->id ], 'method'=>'PUT', 'id' => 'contact-edit-form']) !!}
                    @la_form($module)
                    {{-- @include('la.contacts.panel.contact_details') --}}
                    {{--
                    @la_input($module, 'title_id')
					@la_input($module, 'contact_type_id')
					@la_input($module, 'account_id')
					@la_input($module, 'office_id')
					@la_input($module, 'first_name')
					@la_input($module, 'last_name')
					@la_input($module, 'notes')
                    --}}
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/contacts') }}" class="btn btn-default pull-right">Cancel</a>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
    $("#contact-edit-form").validate({

    });
});
</script>
@endpush
