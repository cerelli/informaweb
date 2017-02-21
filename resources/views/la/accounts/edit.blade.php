@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/accounts') }}">Account</a> :
@endsection
@section("contentheader_description", $account->$view_col)
@section("section", "Accounts")
@section("section_url", url(config('laraadmin.adminRoute') . '/accounts'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Accounts Edit : ".$account->$view_col)

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
                {!! Form::model($account, ['route' => [config('laraadmin.adminRoute') . '.accounts.update', $account->id ], 'method'=>'PUT', 'id' => 'account-edit-form']) !!}
                    @la_form($module)
                    
                    {{--
                    @la_input($module, 'title_id')
					@la_input($module, 'is_person')
					@la_input($module, 'name1')
					@la_input($module, 'name2')
					@la_input($module, 'notes')
					@la_input($module, 'account_account_type')
					@la_input($module, 'account_user')
                    --}}
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/accounts') }}" class="btn btn-default pull-right">Cancel</a>
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
    $("#account-edit-form").validate({
        
    });
});
</script>
@endpush
