@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/localities') }}">Locality</a> :
@endsection
@section("contentheader_description", $locality->$view_col)
@section("section", "Localities")
@section("section_url", url(config('laraadmin.adminRoute') . '/localities'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Localities Edit : ".$locality->$view_col)

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
                {!! Form::model($locality, ['route' => [config('laraadmin.adminRoute') . '.localities.update', $locality->id ], 'method'=>'PUT', 'id' => 'locality-edit-form']) !!}
                    @la_form($module)
                    
                    {{--
                    @la_input($module, 'country_code')
					@la_input($module, 'postal_code')
					@la_input($module, 'place_name')
                    --}}
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/localities') }}" class="btn btn-default pull-right">Cancel</a>
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
    $("#locality-edit-form").validate({
        
    });
});
</script>
@endpush
