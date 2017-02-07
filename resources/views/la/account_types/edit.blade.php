@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/account_types') }}">Account Type</a> :
@endsection
@section("contentheader_description", $account_type->$view_col)
@section("section", "Account_Types")
@section("section_url", url(config('laraadmin.adminRoute') . '/account_types'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Account_Types Edit : ".$account_type->$view_col)

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
                {!! Form::model($account_type, ['route' => [config('laraadmin.adminRoute') . '.account_types.update', $account_type->id ], 'method'=>'PUT', 'id' => 'account_type-edit-form']) !!}
                    @la_form($module)
                    
                    {{--
                    @la_input($module, 'description')
					@la_input($module, 'name')
					@la_input($module, 'parent')
					@la_input($module, 'order')
					@la_input($module, 'in_evidence')
                    --}}
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/account_types') }}" class="btn btn-default pull-right">Cancel</a>
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
    $("#account_type-edit-form").validate({
        
    });
});
</script>
@endpush
