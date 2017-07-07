@la_access("Contact_details", "create")
<div class="modal fade" id="AddContactDetailModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{ __('Add Contact Detail') }}</h4>
            </div>
            <form action="{{ url(config('laraadmin.adminRoute') . '/add_contact_detail/'.$account->id) }}" method="post" id="create-contact-detail-modal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="DetailContactId" id="DetailContactId" value="">

            <div class="modal-body">
                <div class="box-body">
                    @php ($fields = array('contact_detail_type_id','communication_type_id','value','notes'))
                    @la_formMultiple("Contact_details", $fields)
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endla_access

@push('scripts')
    <script>
    $(document).ready(function(){
        $("#create-contact-detail-modal").validate({
        });
    });
    </script>
@endpush
