@la_access("Contacts", "edit")

<div class="modal fade" id="EditModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ __('Edit Contact') }}</h4>
            </div>


            <div class="modal-body">
                {!! form::open(['url' => '#', 'method' => 'post', 'id' => 'updateModalForm']) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="contactId" value="">
                {{-- <form id="formDati" class="form-horizontal" role="form"> --}}
                {{-- {!! Form::open(['action' => ['LA\ContactsController@updateModal',1], 'id' => 'contact-edit-modal-form']) !!} --}}
                {{-- {!! Form::model($contact, ['method'=>'put', 'url' => config('laraadmin.adminRoute') . '/contacts/'. $contact->id,  'id' => 'contact-update-form']) !!} --}}
                {{-- {!! Form::model($contact, ['route' => [config('laraadmin.adminRoute') . '.updateModalContact', 1 ], 'method'=>'PUT', 'id' => 'contact-update-form']) !!} --}}
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
                {!! Form::close() !!}
                {{-- </form> --}}
                {{-- {!! Form::submit( 'Submit', ['class'=>'btn btn-success', 'id'=>'btn_submit']) !!} --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" class="btn btn-primary save" data-dismiss="modal">
                    <span class='glyphicon glyphicon-check'></span> Save
                </button>

            </div>
            // </form>
            {{-- {!! Form::close() !!} --}}
        </div>
    </div>
</div>
@endla_access
