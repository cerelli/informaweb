@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/addresses') }}">Address</a> :
@endsection
@section("contentheader_description", $address->$view_col)
@section("section", "Addresses")
@section("section_url", url(config('laraadmin.adminRoute') . '/addresses'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Addresses Edit : ".$address->$view_col)

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
                {!! Form::model($address, ['route' => [config('laraadmin.adminRoute') . '.addresses.update', $address->id ], 'method'=>'PUT', 'id' => 'address-edit-form']) !!}
                    @la_form($module)
                    
                    {{--
                    @la_input($module, 'street')
                    --}}
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/addresses') }}" class="btn btn-default pull-right">Cancel</a>
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
    $("#address-edit-form").validate({
        
    });
});
</script>
@endpush
