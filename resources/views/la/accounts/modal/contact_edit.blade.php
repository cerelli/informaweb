@la_access("Contacts", "edit")

{{-- <div class="modal fade" id="EditModal" role="dialog" aria-labelledby="myModalLabel"> --}}
<div class="modal fade" id="modal-edit-contact" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> --}}
                {{-- <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">{{ __('Add Account') }}</button> --}}
                {{-- <h4 class="modal-title" id="myModalLabel">{{ __('Edit Contact') }}</h4> --}}
                <h4 class="modal-title" id="favoritesModalLabel">The Sun Also Rises</h4>
            </div>
            {{-- <form action="{{ url(config('laraadmin.adminRoute') . '/edit_contact/1') }}" method="post"> --}}
            @php($prova = Request::get('FormModale'))

            @php($modalContact = $account->contacts->find($prova))

            {!! Form::model($modalContact, ['method' => 'put', 'url' => config('laraadmin.adminRoute') . '/edit_contact/'.$modalContact['id']]) !!}

            <div class="modal-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="id">

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
                <input type="submit" value="Delete">
                {!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
            </div>
            // </form>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endla_access
