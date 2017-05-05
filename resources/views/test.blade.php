<div>
    {!! Form::open(['action' => 'LA\Contact_detailsController@store', 'id' => 'contact_detail-add-form']) !!}
    <div class="modal-body">
        <div class="box-body">
            {{ dd($module) }}

            {{--
            @la_input($module, 'contact_id')
            @la_input($module, 'contact_detail_type_id')
            @la_input($module, 'communication_type_id')
            @la_input($module, 'value')
            @la_input($module, 'notes')
            --}}
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
        {!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
    </div>
    {!! Form::close() !!}
</div>
