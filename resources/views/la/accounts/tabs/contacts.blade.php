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
                            <div class="panel panel-default" >
                                <div class="panel-heading" >
                                    <div class="col-xs-3 col-sm-6">
                                        <h3 class="panel-title" style = "padding-bottom: 3px; padding-top: 3px;">
                                            @la_displayField($contact, 'first_name', 'Contacts')
                                            @la_displayField($contact, 'last_name', 'Contacts')
                                        </h3>

                                    </div>
                                    <div class="col-xs-3 col-sm-6">
                                        <a href="#" class="pull-right btn btn-xs btn-danger btn-hidden" >
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </a>
                                        @la_access("Contacts", "edit")

                                        <a href="#modal-edit-contact?a=<?php echo $contact->id; ?>" id="openModal<?php echo $contact->id; ?>" class="pull-right btn btn-xs btn-warning btn-hidden">
                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ url(config('laraadmin.adminRoute') . '/contacts/'.$contact->id.'/edit', ['account' => 2]) }}" id="modal-edit" class="pull-right btn btn-xs btn-warning btn-hidden">
                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                        </a>
                                        <a href="#modal-edit-contact" data-hover="tooltip" data-placement="top" data-target="#modal-edit-contact" data-toggle="modal" id="modal-edit" title="Edit"></a>

                                    <button type="button" class="btn btn-primary btn-lg" id="editContact"
                                        data-toggle="modal"
                                        data-target="#modal-edit-contact"
                                        data-value="{{ $contact->id }}"
                                        >Edit Contact
                                    </button>
<a href="{{ url(config('laraadmin.adminRoute') . '/edit_contact/' . $contact->id . '?account='.$account->id)}}" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
                                        @endla_access
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


{{csrf_field()}}
@push('scripts')
    <script>
    $('#modal-edit-contact').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).attr('data-value');
        $('#id').val(id);
        $.post('edit_contact', {'id': id, '_token':$('input[name=_token]').val()}, function(data) {
            console.log(data);
        });
    });

    // $(document).ready(function(){
    //     $(document).on('click', '#editContact', function(event) {
    //         var id = $("#editContact").html($(event.relatedTarget).data('value'));
    //         console.log(id);
    //     });
    // });
    </script>
@endpush


@include('la.accounts.modal.contact_create')
@include('la.accounts.modal.contact_edit')
