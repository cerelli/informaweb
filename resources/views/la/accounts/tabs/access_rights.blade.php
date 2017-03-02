<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-access_rights">
    <div class="guide1">
        <span class="pull-left">Module Access for Users</span>
    </div>
    <form action="{{ url(config('laraadmin.adminRoute') . '/save_role_module_permissions/'.$module->id) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <table class="table table-bordered dataTable no-footer table-access_rights" id="tablea-access_rights">
            <thead>
                <tr class="blockHeader">
                    <th width="14%">
                        <input class="alignTop" type="checkbox" id="role_select_all" >&nbsp; Users
                    </th>
                    <th width="14%">
                        <input type="checkbox" id="view_all" >&nbsp; View
                    </th>
                    <th width="14%">
                        <input type="checkbox" id="create_all" >&nbsp; Create
                    </th>
                    <th width="14%">
                        <input type="checkbox" id="edit_all" >&nbsp; Edit
                    </th>
                    <th width="14%">
                        <input class="alignTop" type="checkbox" id="delete_all" >&nbsp; Delete
                    </th>
                </tr>
            </thead>
            @foreach($usersAccess-> as $userAccess)
                $userAccess;
            @endforeach
        </table>
        <center><input class="btn btn-success" type="submit" name="Save"></center>
    </form>
<!--<div class="text-center p30"><i class="fa fa-list-alt" style="font-size: 100px;"></i> <br> No posts to show</div>-->
</div>

@push('styles')

<style>
.btn-default{border-color:#D6D3D3}
.slider .tooltip{display:none !important;}
.slider.gray .slider-handle{background-color:#888;}
.slider.orange .slider-handle{background-color:#FF9800;}
.slider.green .slider-handle{background-color:#8BC34A;}

.guide1{text-align: right;margin: 0px 15px 15px 0px;font-size:16px;}
.guide1 .fa{font-size:22px;vertical-align:bottom;margin-left:17px;}
.guide1 .fa.gray{color:#888;}
.guide1 .fa.orange{color:#FF9800;}
.guide1 .fa.green{color:#8BC34A;}

.table-access_rights{border:1px solid #CCC;}
.table-access_rights thead tr{background-color: #DDD;}
.table-access_rights thead tr th{border-bottom:1px solid #CCC;padding:10px 10px;text-align:center;}
.table-access_rights thead tr th:first-child{text-align:left;}
.table-access_rights input[type="checkbox"]{margin-right:5px;vertical-align:text-top;}
.table-access_rights > tbody > tr > td{border-bottom:1px solid #EEE !important;padding:10px 10px;text-align:center;}
.table-access_rights > tbody > tr > td:first-child {text-align:left;}

.table-access_rights .tr-access-adv {background:#b9b9b9;}
.table-access_rights .tr-access-adv .table{margin:0px;}
.table-access_rights .tr-access-adv > td{padding: 7px 6px;}
.table-access_rights .tr-access-adv .table-bordered td{padding:10px;}

.ui-field{list-style: none;padding: 3px 7px;border: solid 1px #cccccc;border-radius: 3px;background: #f5f5f5;margin-bottom: 4px;}

</style>

@endpush

@push('scripts')
<script>
$(function () {
    $("#tablea-access_rights").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url(config('laraadmin.adminRoute') . '/account_access_right') }}',
        columns: [
            { data: 'name', name: 'name'}
        ]
    });

});
</script>
@endpush
