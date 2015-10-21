@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/users/table.viewusers') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        @if (Config::get('ldap.url')!='')
            <a href="{{ route('ldap/user') }}" class="btn btn-default pull-right"><span class="fa fa-upload"></span> LDAP</a>
        @endif
	<a href="{{ route('import/user') }}" class="btn btn-default pull-right" style="margin-right: 5px;"><span class="fa fa-upload"></span> @lang('general.import')</a>
        <a href="{{ route('create/user') }}" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-plus icon-white"></i>  @lang('general.create')</a>
         @if (Input::get('status')=='deleted')
            <a class="btn btn-default pull-right" href="{{ URL::to('admin/users') }}" style="margin-right: 5px;">@lang('admin/users/table.show_current')</a>
        @else
            <a class="btn btn-default pull-right" href="{{ URL::to('admin/users?status=deleted') }}" style="margin-right: 5px;">@lang('admin/users/table.show_deleted')</a>
        @endif

        <h3>
        @if (Input::get('status')=='deleted')
            @lang('general.deleted')
        @else
            @lang('general.current')
        @endif
         @lang('general.users')
    </h3>
    </div>
</div>

<div class="row">
    {{ Form::open([
         'method' => 'POST',
         'route' => ['users/bulkedit'],
         'class' => 'form-horizontal' ]) }}

       <table name="assets" id="table" data-url="{{route('api.users.list') }}">
           <thead>
               <tr>
                   <th data-class="hidden-xs" data-switchable="false" data-searchable="false" data-sortable="false" data-field="checkbox"><div class="text-center"><input type="checkbox" id="checkAll" style="padding-left: 0px;"></div></th>
                   <th data-sortable="true" data-field="name">{{ Lang::get('admin/users/table.name') }}</th>
                   <th data-sortable="true" data-field="email"><i class="fa fa-envelope fa-lg"></i></th>
                   <th data-sortable="true" data-field="username">{{ Lang::get('admin/users/table.username') }}</th>
                   <th data-sortable="true" data-field="manager">{{ Lang::get('admin/users/table.manager') }}</th>
                   <th data-sortable="true" data-field="location">{{ Lang::get('admin/users/table.location') }}</th>
                   <th data-sortable="true" data-field="assets"><i class="fa fa-barcode fa-lg"></i></th>
                   <th data-sortable="true" data-field="licenses"><i class="fa fa-certificate fa-lg"></i></th>
                   <th data-sortable="true" data-field="accessories"><i class="fa fa-keyboard-o fa-lg"></i></th>
                   <th data-sortable="true" data-field="consumables"><i class="fa fa-tint fa-lg"></i></th>
                   <th data-sortable="true" data-field="groups">{{ Lang::get('general.groups') }}</th>
                   <th data-sortable="true" data-field="notes">{{ Lang::get('general.notes') }}</th>
                   <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions" >{{ Lang::get('table.actions') }}</th>
               </tr>
           </thead>
           <tfoot>
               <tr>
                   <td colspan="12">
                       <select name="bulk_actions">
                           <option value="delete">Bulk Delete</option>
                       </select>
                       <button class="btn btn-default" id="bulkEdit" disabled>Go</button>
                   </td>
               </tr>
           </tfoot>
       </table>

    {{ Form::close() }}
</div>
</div>
@section('moar_scripts')
<script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js?v=1') }}"></script>
<script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js?v=1') }}"></script>
<script src="//rawgit.com/kayalshri/tableExport.jquery.plugin/master/tableExport.js?v=1') }}"></script>
<script src="//rawgit.com/kayalshri/tableExport.jquery.plugin/master/jquery.base64.js?v=1') }}"></script>
<script type="text/javascript">
    $('#table').bootstrapTable({
        classes: 'table table-responsive table-no-bordered',
        undefinedText: '',
        iconsPrefix: 'fa',
        showRefresh: true,
        search: true,
        pageSize: {{{ Setting::getSettings()->per_page }}},
        pagination: true,
        sidePagination: 'server',
        sortable: true,
        cookie: true,
        mobileResponsive: true,
        columnsHidden: ['name'],
        showExport: true,
        exportLabel: 'Export',
        showColumns: true,
        maintainSelected: true,
        paginationFirstText: "@lang('general.first')",
        paginationLastText: "@lang('general.last')",
        paginationPreText: "@lang('general.previous')",
        paginationNextText: "@lang('general.next')",
        pageList: ['10','25','50','100','150','200'],
        icons: {
            paginationSwitchDown: 'fa-caret-square-o-down',
            paginationSwitchUp: 'fa-caret-square-o-up',
            columns: 'fa-columns',
            refresh: 'fa-refresh'
        },

    });
</script>


<script>

	$(function() {

		function checkForChecked() {

	        var check_checked = $('input.one_required:checked').length;

	        if (check_checked > 0) {
	            $('#bulkEdit').removeAttr('disabled');
	        }
	        else {
	            $('#bulkEdit').attr('disabled', 'disabled');
	        }
	    }

	    $('table').on('change','input.one_required',checkForChecked);

	    $("#checkAll").change(function () {
			$("input:checkbox").prop('checked', $(this).prop("checked"));
			checkForChecked();
		});

	});


</script>
@stop

@stop
