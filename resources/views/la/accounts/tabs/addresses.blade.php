{{ HTML::style('css/informaweb.css') }}

<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-addresses">
    <div class="tab-content">
        <div class="panel infolist">
            <div class="panel-default panel-heading">
                <h4>{{ __('Addresses') }}
                    @la_access("Addresses", "create")
                        <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddAddressModal">{{ __('Add Address') }}</button>
                    @endla_access
                </h4>
            </div>
        </div>
        <div class="row">
            @foreach (array_chunk($account->addresses->all(),3) as $row)
                <div class="row">
                    @foreach ($row as $address)
                        <div class="col-md-4 col-sm-12"  style = "padding-bottom: 15px; padding-top: 15px;">
                            <div class="panel panel-default" id="address_panel_{{ $address->id }}">
                                <div class="panel-heading" >
                                    <div class="row" style="text-align: center;">
                                        <span id="address_panel_title_{{ $address->id }}" class="col-sm-10 col-md-10 label label-primary" style = "margin-left: 2px; padding-bottom: 5px; padding-top: 5px;">
                                            @la_displayField($address, 'address_type_id', 'Addresses', 'true')
                                        </span>
                                        <div style="margin-right: 3px;" id="address-panel">
                                            {!! Form::open(['action' => ['LA\AddressesController@delete_address',$address->id], 'id' => 'address-delete-modal-form', 'method' => 'POST']) !!}
                                            <input type="hidden" name="accountId" value={{ $account->id }}>
                                                <button class="btn btn-xs pull-right btn-danger btn-hidden" type="button" data-toggle="modal" data-target="#confirmDelete" data-title='{{ __('Delete Address') }}' data-message= '{{ __('Are you sure you want to delete this address ?') }}' >
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </button>
                                            {{ Form::close() }}
                                            @la_access("Addresses", "edit")
                                                <?php echo iWHelper::print_modal_editor('Addresses', $address); ?>
                                            @endla_access
                                        </div>
                                    </div>
                                    <div class="col-sm-10 col-md-10">
                                        <h3 class="panel-title" style = "padding-bottom: 3px; padding-top: 3px;" id="address_panel_descr_{{ $address->id }}">
                                            @la_displayField($address, 'street', 'Addresses')
                                            <br/>
                                            {{-- @la_displayField($address, 'locality_id', 'Addresses') --}}
                                            {{-- {{ $address->locality->getLocalityString() }} --}}
                                            @if ( is_null($address->locality) )

                                            @else
                                                {{ $address->locality->getLocalityString() }}
                                            @endif
                                            <br/>
                                            {{-- <span class='label label-primary'>@la_displayField($contact, 'contact_type_id', 'Contacts', 'true') </span>
                                            <span class='label label-primary'>@la_displayField($contact, 'office_id', 'Contacts', 'true') </span>
                                            <br/> --}}
                                            @la_displayField($address, 'note', 'Addresses')
                                        </h3>
                                    </div>
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

@include('la.accounts.modal.address_create')
@include('la.accounts.modal.address_edit')

<meta name="csrf-token" content="{{ csrf_token() }}">
@push('scripts')
    <script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $(document).ready(function(){
        $("#address-panel .editModalBtn").on("click", function() {
            var info = JSON.parse($(this).attr("info"));
            var select_fields = ",address_type_id,";
            var addressId = info.id;
            var url = $("#address-edit-modal-form").attr("action");
            index = url.lastIndexOf("/");
            url2 = $("#urlController").val()+'/editModalAddress/'+info.id;
            $("#address-update-form").attr("action", url2)
            $.ajax({
                url: $("#urlController").val()+'/editModalAddress/'+info.id,
                method: 'GET',
                dataType: "json",
                success: function(data){
                    info = data;
                    $('#addressId').val(info.id);
                    $.each(data, function(index, value) {
                        if ( select_fields.search(','+index+',') == -1 ) {
                            $("#address-edit-modal-form input[name="+index+"]").val(value);
                        } else {
                            $("#address-edit-modal-form select[name="+index+"]").val(value).change();
                        }
                    });
                    $("#address-edit-modal-form").attr("action", url2)
                    console.log(data);
                    $("#EditModalAddress").modal("show");
                },
                error: function(data){
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            });
        });
    });

    </script>
@endpush
