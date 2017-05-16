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
                                        <h3 class="panel-title" style = "padding-bottom: 3px; padding-top: 3px;">
                                            @la_displayField($contact, 'first_name', 'Contacts')
                                            @la_displayField($contact, 'last_name', 'Contacts')
                                        </h3>
                                    </div>
                                    <div class="col-xs-3 col-sm-6">
                                        <div class="dd" id="contact-panel">

                                            <a href="#" class="pull-right btn btn-xs btn-danger btn-hidden" >
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </a>
                                            @la_access("Contacts", "edit")
                                                <?php echo iWHelper::print_contact_editor('Contacts', $contact); ?>
                                            @endla_access
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    @foreach ($contact->contact_details as $contact_detail)
                                        <div class="dats1" style = "padding-bottom: 5px; padding-top: 5px;">
                                            <i class="fa {{$contact_detail->communication_type->fa_icon}}"></i>
                                            @la_displayField($contact_detail, 'value', 'Contact_details')
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


<meta name="csrf-token" content="{{ csrf_token() }}">
@push('scripts')
    <script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $(document).ready(function(){

        $("#contact-panel .editModalBtn").on("click", function() {
            var info = JSON.parse($(this).attr("info"));

            //var url = $("#contact-update-form").attr("action");
            //index = url.lastIndexOf("/");
            //url2 = url.substring(0, index+1)+info.id;

            // $("#contact-update-form").attr("action", url2)
/*
            $.ajax({
                url: $("#urlController").val()+'/editModalContact/'+info.id,
                method: 'GET',
                dataType: "json",

                // data: {
                //     'first_name': first_name,
                // },
                success: function(data){
                    console.log('data');
                    console.log(data);
                    // $('#contact_panel_'+contactId).load(location.href + ' #contact_panel_'+contactId);
                },
                error: function(data){
                    var errors = data.responseJSON;
                    console.log(errors);
                    // Render the errors with js ...
                }
            });*/
            $('#contactId').val(info.id);
            $.each(info, function(index, value) {
                $("#EditModal input[name="+index+"]").val(value);
            });
            //$("#contact-update-form").attr("action", url2)

            $("#EditModal").modal("show");
            // var url = $("#contact-update-form").attr("action");
            // console.log(url);
        });

        // $("#EditModal").on('hidden.bs.modal', function(){
        //     alert("Modal window has been completely closed.");
        // });

        $('.modal-footer').on('click', '.save', function(e) {
            e.preventDefault();
            // console.log($("#contactId").val());
            var contactId = $("#contactId").val();
            //var first_name = $("#formDati input[name=first_name]").val();
            var newURL = '/{{ config('laraadmin.adminRoute') }}/updateModalContact/'+contactId;
            console.log('qui');
            $.ajax({
                // url: $("#urlController").val()+'/updateModalContact/'+contactId,
                url: newURL,
                type: 'POST',
                data: jQuery("#updateModalForm").serialize(),
                success: function(data){
                    console.log(data);
                    // $('#contact_panel_'+contactId).load(location.href + ' #contact_panel_'+contactId);

                    // Nasconde la modale SOLO se il salvataggio viene effettuato correttamente
                    $('#EditModal').modal('hide');
                },
                error: function(data){
                    var errors = data.responseJSON;
                    console.log(errors);
                    // Render the errors with js ...
                }
            });
        });
    });

        // $("#btn_submit").on("click", function(e) {
        //     e.preventDefault();
        //
        //     //var info = JSON.parse($(this).attr("info"));
        //     alert("info");
        // //     $.post('updateModalContact',{'_token':$('input[name=_token]')})
        // //          .done(function(response){
        // //              var obj = jQuery.parseJSON(response);
        // //              if(obj.success == true){
        // //                  initializeMap();
        // //              }
        // //              else{
        // //                  errorHandler();
        // //
        // //                  else {
        // //                      errorHandler();
        // //                  }
        // //              }
        // //          });
        // });
        //

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
