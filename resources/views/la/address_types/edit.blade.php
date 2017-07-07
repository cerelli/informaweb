@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/address_types') }}">Address type</a> :
@endsection
@section("contentheader_description", $address_type->$view_col)
@section("section", "Address types")
@section("section_url", url(config('laraadmin.adminRoute') . '/address_types'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Address types Edit : ".$address_type->$view_col)

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
                {!! Form::model($address_type, ['route' => [config('laraadmin.adminRoute') . '.address_types.update', $address_type->id ], 'method'=>'PUT', 'id' => 'address_type-edit-form']) !!}
                    @la_form($module)
                    
                    {{--
                    @la_input($module, 'description')
					@la_input($module, 'fa_icon')
                    --}}
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/address_types') }}" class="btn btn-default pull-right">Cancel</a>
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
    $("#address_type-edit-form").validate({
        
    });
});
</script>
@endpush
