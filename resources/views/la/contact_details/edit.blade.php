@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/contact_details') }}">Contact detail</a> :
@endsection
@section("contentheader_description", $contact_detail->$view_col)
@section("section", "Contact details")
@section("section_url", url(config('laraadmin.adminRoute') . '/contact_details'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Contact details Edit : ".$contact_detail->$view_col)

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
                {!! Form::model($contact_detail, ['route' => [config('laraadmin.adminRoute') . '.contact_details.update', $contact_detail->id ], 'method'=>'PUT', 'id' => 'contact_detail-edit-form']) !!}
                    @la_form($module)
                    
                    {{--
                    @la_input($module, 'contact_id')
					@la_input($module, 'contact_detail_type_id')
					@la_input($module, 'communication_type_id')
					@la_input($module, 'value')
					@la_input($module, 'notes')
                    --}}
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/contact_details') }}" class="btn btn-default pull-right">Cancel</a>
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
    $("#contact_detail-edit-form").validate({
        
    });
});
</script>
@endpush
