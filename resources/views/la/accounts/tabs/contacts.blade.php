{{ HTML::style('css/informaweb.css') }}

<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-contacts">
    <div class="tab-content">
        <div class="panel infolist">
            <div class="panel-default panel-heading">
                <h4>{{ __('Contacts') }}
                    @la_access("Contacts", "create")
                        <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddContactModal">{{ __('Add Contact') }}</button>
                    @endla_access
                </h4>
            </div>
        </div>
        <div class="row">
            @foreach (array_chunk($account->contacts->all(),3) as $row)
                <div class="row">
                    @foreach ($row as $contact)
                        <div class="col-md-4 col-sm-12"  style = "padding-bottom: 15px; padding-top: 15px;">
                            <div class="panel panel-default" id="contact_panel_{{ $contact->id }}">
                                <div class="panel-heading" >
                                    <div class="col-xs-3 col-sm-6">
                                        <h3 class="panel-title" style = "padding-bottom: 3px; padding-top: 3px;" id="contact_panel_title_{{ $contact->id }}">
                                            @la_displayField($contact, 'title_id', 'Contacts', 'true')
                                            <br/>
                                            @la_displayField($contact, 'first_name', 'Contacts')
                                            @la_displayField($contact, 'last_name', 'Contacts')
                                            <br/>
                                            <span class='label label-primary'>@la_displayField($contact, 'contact_type_id', 'Contacts', 'true') </span>
                                            <span class='label label-primary'>@la_displayField($contact, 'office_id', 'Contacts', 'true') </span>
                                            <br/>
                                            @la_displayField($contact, 'notes', 'Contacts')
                                        </h3>
                                    </div>
                                    <div class="col-xs-3 col-sm-6">
                                        <div class="dd" id="contact-panel">
                                            <input type="hidden" id="PanelContactId" value={{ $contact->id }}>
                                            {!! Form::open(['action' => ['LA\ContactsController@delete_contact',$contact->id], 'id' => 'contact-delete-modal-form', 'method' => 'POST']) !!}
                                            <input type="hidden" name="accountId" value={{ $account->id }}>
                                                <button class="btn btn-xs pull-right btn-danger btn-hidden" type="button" data-toggle="modal" data-target="#confirmDelete" data-title='{{ __('Delete Contact') }}' data-message= '{{ __('Are you sure you want to delete this user ?') }}' >
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </button>
                                            {{ Form::close() }}
                                            @la_access("Contacts", "edit")
                                                <?php echo iWHelper::print_modal_editor('Contacts', $contact); ?>
                                            @endla_access
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body" id="contact-detail-panel">
                                    <div class="row dats1" style="border-bottom-style: solid; border-color: #ddd; border-width: 1px;">
                                        @la_access("Contact_details", "create")
                                            <button class="btn btn-success btn-sm pull-right btn-hidden createContactDetailBtn" style = "margin-right: 3px;" data-toggle="modal" infoDet={{ $contact->id }} data-target="#AddContactDetailModal">{{ __('Add Contact Detail') }}</button>
                                        @endla_access
                                    </div>
                                    @foreach ($contact->contact_details as $contact_detail)
                                        <div class="row dats01" style="border-bottom-style: solid; border-color: #ddd; border-width: 1px;">
                                            <div class="dats2 col-xs-3 col-sm-6" style = "padding-bottom: 5px; padding-top: 5px;">
                                                <div class="details" id="contact_detail_panel_{{ $contact_detail->id }}">
                                                    <i class="fa {{$contact_detail->contact_detail_type->fa_icon}}"></i>
                                                    <i class="fa {{$contact_detail->communication_type->fa_icon}}"></i>
                                                    @la_displayField($contact_detail, 'value', 'Contact_details')
                                                    <br/>
                                                    <span style="font-style: italic;" >@la_displayField($contact_detail, 'notes', 'Contact_details')</span>
                                                </div>
                                            </div>
                                            <div class="col-xs-3 col-sm-6">
                                                {!! Form::open(['action' => ['LA\Contact_detailsController@delete_contact_detail',$contact_detail->id], 'id' => 'contact-detail-delete-modal-form', 'method' => 'POST']) !!}
                                                <input type="hidden" name="accountId" value={{ $account->id }}>
                                                    <button class="btn btn-xs pull-right btn-danger btn-hidden" type="button" data-toggle="modal" data-target="#confirmDelete" data-title='{{ __('Delete Contact') }}' data-message= '{{ __('Are you sure you want to delete this user ?') }}' >
                                                        <i class="glyphicon glyphicon-trash"></i>
                                                    </button>
                                                {{ Form::close() }}
                                                <a href="#" class="pull-right btn btn-xs btn-warning btn-hidden editDetailModalBtn" infoDetId={{ $contact_detail->id }}><i class="fa fa-edit" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>

@include('la.accounts.modal.delete_confirm')
@include('la.accounts.modal.contact_create')
@include('la.accounts.modal.contact_edit')
@include('la.accounts.modal.contact_detail_create')
@include('la.accounts.modal.contact_detail_edit')

<meta name="csrf-token" content="{{ csrf_token() }}">
@push('scripts')
    <script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $(document).ready(function(){
        $("#contact-detail-panel .createContactDetailBtn").on("click", function() {
            var contactId = $(this).attr("infoDet");
            $('#DetailContactId').val(contactId);
        });

        $("#contact-detail-panel .editDetailModalBtn").on("click", function() {
            var contactDetailId = $(this).attr("infoDetId");
            var select_fields = ",contact_detail_type_id,communication_type_id,";
            var url = $("#contact-detail-edit-modal-form").attr("action");
            index = url.lastIndexOf("/");
            url2 = $("#urlController").val()+'/editModalContactDetail/'+contactDetailId;
            console.log(url2);
            // $("#contact-update-form").attr("action", url2)
            $.ajax({
                url: $("#urlController").val()+'/editModalContactDetail/'+contactDetailId,
                // url: url2,
                method: 'GET',
                dataType: "json",
                // data: {
                //     'first_name': first_name,
                // },
                success: function(data){
                    $('#contactId').val(data.id);
                    // console.log(info);
                    $.each(data, function(index, value) {
                        if ( select_fields.search(','+index+',') == -1 ) {
                            $("#contact-detail-edit-modal-form input[name="+index+"]").val(value);
                        } else {
                            console.log(index);
                            $("#contact-detail-edit-modal-form select[name="+index+"]").val(value).change();
                        }
                    });
                    $("#contact-detail-edit-modal-form").attr("action", url2)
                    $("#EditDetailModal").modal("show");
                },
                error: function(data){
                    var errors = data.responseJSON;
                    // console.log(data);
                    // Render the errors with js ...
                }
            });
            //*************************

            // var url = $("#contact-update-form").attr("action");
            // console.log(url);
        });

        $("#contact-panel .editModalBtn").on("click", function() {
            console.log('questo');
            var info = JSON.parse($(this).attr("info"));
            var select_fields = ",title_id,contact_type_id,office_id,";
            var contactId = info.id;
            var url = $("#contact-edit-modal-form").attr("action");
            index = url.lastIndexOf("/");
            console.log(url);
            //*****************
            url2 = $("#urlController").val()+'/editModalContact/'+info.id;
            $("#contact-update-form").attr("action", url2)
            $.ajax({
                url: $("#urlController").val()+'/editModalContact/'+info.id,
                method: 'GET',
                dataType: "json",
                // data: {
                //     'first_name': first_name,
                // },
                success: function(data){
                    // console.log('success');
                    info = data;
                    // console.log(info);
                    // $('#contact_panel_'+contactId).load(location.href + ' #contact_panel_'+contactId);
                    $('#contactId').val(info.id);


                    // console.log(info);
                    $.each(data, function(index, value) {
                        if ( select_fields.search(','+index+',') == -1 ) {
                            $("#contact-edit-modal-form input[name="+index+"]").val(value);
                        } else {
                            console.log(index);
                            $("#contact-edit-modal-form select[name="+index+"]").val(value).change();
                        }
                    });
                    $("#contact-edit-modal-form").attr("action", url2)
                    $("#EditModal").modal("show");
                },
                error: function(data){
                    var errors = data.responseJSON;
                    // console.log(data);
                    // Render the errors with js ...
                }
            });
            //*************************

            // var url = $("#contact-update-form").attr("action");
            // console.log(url);
        });
    });

    </script>
@endpush
