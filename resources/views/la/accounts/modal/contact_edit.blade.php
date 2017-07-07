@la_access("Contacts", "edit")

<div class="modal fade" id="EditModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ __('Edit Contact') }}</h4>
            </div>


            <div class="modal-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="contactId" value="">
                <input type="hidden" id="urlController" value="{{ url(config('laraadmin.adminRoute')) }}">
                {{-- <form id="formDati" class="form-horizontal" role="form"> --}}
                {{-- {!! Form::open(['action' => ['LA\ContactsController@updateModal',1], 'id' => 'contact-edit-modal-form']) !!} --}}
                {{-- {!! Form::model($contact, ['method'=>'put', 'url' => config('laraadmin.adminRoute') . '/contacts/'. $contact->id,  'id' => 'contact-update-form']) !!} --}}
                {{-- {!! Form::model($contact, ['route' => [config('laraadmin.adminRoute') . '.updateModalContact', 1 ], 'method'=>'PUT', 'id' => 'contact-update-form']) !!} --}}
                {!! Form::open(['action' => ['LA\ContactsController@updateModalContact',1], 'id' => 'contact-edit-modal-form', 'method' => 'POST']) !!}
                    <input type="hidden" name="accountId" value={{ $account->id }}>
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

                    <button type="button" class="btn btn-default pull-right" style="margin-left: 3px" data-dismiss="modal">{{ __('Close') }}</button>
                    {!! Form::submit( __('Save'), ['id'=>'submit', 'class'=>'btn btn-success pull-right']) !!}
                {!! Form::close() !!}
                {{-- </form> --}}
                {{-- {!! Form::submit( 'Submit', ['class'=>'btn btn-success', 'id'=>'btn_submit']) !!} --}}
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" class="btn btn-primary save" data-dismiss="modal">
                    <span class='glyphicon glyphicon-check'></span> Save
                </button>

            </div> --}}
            {{-- // </form> --}}
            {{-- {!! Form::close() !!} --}}
        </div>
    </div>
</div>
@endla_access

@push('scripts')
    <script>
    $(document).ready(function(){
        $("#contact-edit-modal-form").validate({
            submitHandler: function(e) {
                    var contactId = $("#contactId").val();
                    var info = JSON.parse($('#editModalBtn_'+contactId).attr('info'));
                    var first_name = $("#formDati input[name=first_name]").val();
                    var contact_type_id = $("#formDati input[name=contact_type_id]").val();
                    var newURL = '{!!route(config('laraadmin.adminRoute') . '.updateModalContact',1)!!}';

                    index = newURL.lastIndexOf("/");
                    newURL = newURL.substring(0, index+1)+contactId;

                    $.ajax({
                        url: newURL,
                        type: 'POST',
                        dataType: 'json',
                        data: $("form#contact-edit-modal-form").serialize(),
                        success: function(data){
                            var title = '';
                            if ( data.title_description ) {
                                title = data.title_description+'<br/>';
                            }
                            console.log(data.title_description);
                            var titolo = title+data.first_name+' '+data.last_name+"<br/><span class='label label-primary' style='margin-right: 3px;'>"+data.contact_type_description+ "</span>"+"<span class='label label-primary'>"+data.office_description+ "</span><br/>"+data.notes;
                            $('#contact_panel_title_'+contactId+'.panel-title').html(titolo);
                            $('#EditModal').modal('hide');
                        },
                        error: function(data){
                        }
                    });
            }
          });
    });
    </script>
@endpush
