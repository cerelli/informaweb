@la_access("Contacts", "create")
<div class="modal fade" id="AddContactModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> --}}
                {{-- <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">{{ __('Add Account') }}</button> --}}
                <h4 class="modal-title" id="myModalLabel">{{ __('Add Contact') }}</h4>
            </div>
            <form action="{{ url(config('laraadmin.adminRoute') . '/add_contact/'.$account->id) }}" method="post">
            {{-- {!! Form::open(['action' => 'LA\AccountsController@add_contact', 'id' => '$account->id']) !!} --}}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="modal-body">
                <div class="box-body">
                    @php ($fields = array('title_id','contact_type_id','office_id','first_name','last_name','notes'))
                    @la_formMultiple("Contacts", $fields)

                    {{--
                    @la_input($module, 'title_id')
					@la_input($module, 'is_person')
					@la_input($module, 'name1')
					@la_input($module, 'name2')
					@la_input($module, 'notes')
					@la_input($module, 'account_account_type')
					@la_input($module, 'account_user')
                    --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
                {{-- {!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!} --}}
            </div>
            </form>
            {{-- {!! Form::close() !!} --}}
        </div>
    </div>
</div>
@endla_access
