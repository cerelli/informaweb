{{ HTML::style('css/informaweb.css') }}

<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-contacts">
    <div class="tab-content">
        <div class="panel infolist">
            <div class="panel-default panel-heading">
                <h4>Contacts
                    @la_access("Contacts", "create")
                        <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">{{ __('Add Contact') }}</button>
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
                                        {{-- <h3 class="panel-title" style = "padding-bottom: 3px; padding-top: 3px;" id="contact_panel_title_{{ $contact->id }}" rel="tooltip" title='{{ $contact->notes }}'> --}}
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
                                            {{-- {{ Form::open(['action' => [config('laraadmin.adminRoute') . '.delete_contact', $contact->id], 'method' => 'POST', 'style'=>'display:inline','onsubmit' => 'return confirm("are you sure ?")']) }} --}}

                                            <input type="hidden" name="accountId" value={{ $account->id }}>

                                                {{-- <button class="btn btn-xs pull-right btn-danger btn-hidden" type="submit"><i class="fa fa-times"></i></button> --}}
                                                <button class="btn btn-xs pull-right btn-danger btn-hidden" type="button" data-toggle="modal" data-target="#confirmDelete" data-title='{{ __('Delete Contact') }}' data-message= '{{ __('Are you sure you want to delete this user ?') }}' >
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </button>
                                            {{ Form::close() }}
                                            {{-- <a href="#" class="pull-right btn btn-xs btn-danger btn-hidden" >
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </a> --}}
                                            @la_access("Contacts", "edit")
                                                <?php echo iWHelper::print_contact_editor('Contacts', $contact); ?>
                                            @endla_access
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    @foreach ($contact->contact_details as $contact_detail)
                                        {{-- {{ dd($contact)}}; --}}
                                        <div class="dats1" style = "padding-bottom: 5px; padding-top: 5px;">
                                            <i class="fa {{$contact_detail->contact_detail_type->fa_icon}}"></i>
                                            <i class="fa {{$contact_detail->communication_type->fa_icon}}"></i>
                                            @la_displayField($contact_detail, 'value', 'Contact_details')
                                            <br/>
                                            <span style="font-style: italic;" >@la_displayField($contact_detail, 'notes', 'Contact_details')</span>

                                            <a href="#" class="pull-right btn btn-xs btn-danger btn-hidden"><i class="fa fa-times"  aria-hidden="true"></i></a>
                                            <a href="#" class="pull-right btn btn-xs btn-warning btn-hidden"><i class="fa fa-edit" aria-hidden="true"></i></a>
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

@include('la.accounts.modal.delete_confirm');

<meta name="csrf-token" content="{{ csrf_token() }}">
@push('scripts')
    <script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $(document).ready(function(){
        // $('[rel="tooltip"]').tooltip();
        $("#contact-panel .editModalBtn").on("click", function() {
            var info = JSON.parse($(this).attr("info"));
            var select_fields = ",title_id,contact_type_id,office_id,";
            // console.log(info);
            var contactId = info.id;
            // console.log(contactId);
            // var info = JSON.parse($('#editModalBtn').attr('info'));
            // console.log(info);
            var url = $("#contact-edit-modal-form").attr("action");
            index = url.lastIndexOf("/");
            // url2 = url.substring(0, index+1)+info.id;

            //*****************
            url2 = $("#urlController").val()+'/editModalContact/'+info.id;
            $("#contact-update-form").attr("action", url2)
            $.ajax({
                url: $("#urlController").val()+'/editModalContact/'+info.id,
                // url: url2,
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

        // $("#submit").on("click", function(e) {
        $('#contact-edit-modal-form').on('submit', function(e){
            e.preventDefault();
            var contactId = $("#contactId").val();
            var info = JSON.parse($('#editModalBtn_'+contactId).attr('info'));
            // console.log(info);
            var first_name = $("#formDati input[name=first_name]").val();
            var contact_type_id = $("#formDati input[name=contact_type_id]").val();
            var newURL = '{!!route(config('laraadmin.adminRoute') . '.updateModalContact',1)!!}';

            index = newURL.lastIndexOf("/");
            newURL = newURL.substring(0, index+1)+contactId;

            $.ajax({
                // url: $("#urlController").val()+'/updateModalContact/'+contactId,
                url: newURL,
                type: 'POST',
                // data: {
                //     'contact_type_id': contact_type_id,
                //     'first_name': first_name,
                // },
                dataType: 'json',
                data: $("form#contact-edit-modal-form").serialize(),
                success: function(data){
                    console.log(data);
                    // $('#editModalBtn_'+contactId).attr('info',data);
                    var titolo = data.title_description+'<br/>'+data.first_name+' '+data.last_name+"<br/><span class='label label-primary' style='margin-right: 3px;'>"+data.contact_type_description+ "</span>"+"<span class='label label-primary'>"+data.office_description+ "</span><br/>"+data.notes;
                    // $('#contact_panel_'+contactId).load(location.href + ' #contact_panel_'+contactId);
                    // $('#tab-contacts').load(location.href + ' #tab-contacts');
                    $('#contact_panel_title_'+contactId+'.panel-title').html(titolo);
                    $('#EditModal').modal('hide');
                },
                error: function(data){
                    // console.log(data);
                    // var errors = data.responseJSON;
                    // console.log(errors);
                    // Render the errors with js ...
                }
            });

        });

        // $(".delete").on("submit", function(){
        //     return confirm("Do you want to delete this item?");
        // });

        // $("#contact-edit-modal-form").validate({
        //
        // });
        // $("#EditModal").on('hidden.bs.modal', function(){
        //     var info = JSON.parse($(this).attr("info"));
        //     console.log(info);
        // });

        // $('.modal-footer').on('click', '.save', function(e) {
        //     // e.preventDefault();
        //     // console.log($("#contactId").val());
        //     var contactId = $("#contactId").val();
        //     var first_name = $("#formDati input[name=first_name]").val();
        //     var contact_type_id = $("#formDati input[name=contact_type_id]").val();
        //     var newURL = '{!!route(config('laraadmin.adminRoute') . '.updateModalContact',1)!!}';
        //
        //
        //
        //     console.log(newURL);
        //     $.ajax({
        //         // url: $("#urlController").val()+'/updateModalContact/'+contactId,
        //         url: newURL,
        //         type: 'POST',
        //         // data: {
        //         //     'contact_type_id': contact_type_id,
        //         //     'first_name': first_name,
        //         // },
        //         data: jQuery("form#contact-edit-modal-form").serialize(),
        //         success: function(data){
        //             console.log(data);
        //             // $('#contact_panel_'+contactId).load(location.href + ' #contact_panel_'+contactId);
        //         },
        //         error: function(data){
        //             var errors = data.responseJSON;
        //             console.log(errors);
        //             // Render the errors with js ...
        //         }
        //     });
        //     $('#EditModal').modal('hide');
        // });
    });




        // $("#contact-panel .editModalBtn").on("click", function() {
        //     var info = JSON.parse($(this).attr("info"));
        //     // console.log(info);
        //     var url = $("#contact-edit-modal-form").attr("action");
        //     index = url.lastIndexOf("/");
        //     url2 = url.substring(0, index+1)+info.id;
        //     // console.log(url2);
        //     $("#contact-edit-modal-form").attr("action", url2)
        //     $.each(info, function(index, value) {
        //         // console.log( index + ": " + value );
        //         $("#EditModal input[name="+index+"]").val(value);
        //     });
        //     // $("#EditModal input[name=first_name]").val(info.first_name);
        //     // $("#EditModal input[name=name]").val(info.name);
        //     // $("#EditModal input[name=icon]").val(info.icon);
        //     $("#EditModal").modal("show");
        // });

    </script>
@endpush


@include('la.accounts.modal.contact_create')
@include('la.accounts.modal.contact_edit')
