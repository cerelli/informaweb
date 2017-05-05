@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/contact_detail_types') }}">Contact detail type</a> :
@endsection
@section("contentheader_description", $contact_detail_type->$view_col)
@section("section", "Contact detail types")
@section("section_url", url(config('laraadmin.adminRoute') . '/contact_detail_types'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Contact detail types Edit : ".$contact_detail_type->$view_col)

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
                {!! Form::model($contact_detail_type, ['route' => [config('laraadmin.adminRoute') . '.contact_detail_types.update', $contact_detail_type->id ], 'method'=>'PUT', 'id' => 'contact_detail_type-edit-form']) !!}
                    @la_form($module)
                    
                    {{--
                    @la_input($module, 'description')
					@la_input($module, 'fa_icon')
                    --}}
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/contact_detail_types') }}" class="btn btn-default pull-right">Cancel</a>
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
    $("#contact_detail_type-edit-form").validate({
        
    });
});
</script>
@endpush
