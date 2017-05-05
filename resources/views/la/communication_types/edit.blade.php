@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/communication_types') }}">Communication type</a> :
@endsection
@section("contentheader_description", $communication_type->$view_col)
@section("section", "Communication types")
@section("section_url", url(config('laraadmin.adminRoute') . '/communication_types'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Communication types Edit : ".$communication_type->$view_col)

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
                {!! Form::model($communication_type, ['route' => [config('laraadmin.adminRoute') . '.communication_types.update', $communication_type->id ], 'method'=>'PUT', 'id' => 'communication_type-edit-form']) !!}
                    {{-- @la_form($module) --}}


                    @la_input($module, 'description')
					@la_input($module, 'fa_icon')

                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/communication_types') }}" class="btn btn-default pull-right">Cancel</a>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('la-assets/plugins/iconpicker/fontawesome-iconpicker.js') }}"></script>
<script>
$(function () {
    $("#communication_type-edit-form").validate({

    });
    $('input[name=icon]').iconpicker();
});
</script>
@endpush
