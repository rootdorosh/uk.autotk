@extends('admin.layouts.main')

@section('title', __('core::domain.title.index'))
@section('module', 'core')

@section('content')
<div class="card card-info card-outline">
    <div class="card-header">
        <h3 class="card-title float-sm-left">{{ __('core::domain.title.index') }}</h3>
        @if (allow('core.domain.store'))
        <a class="btn btn-success btn-xs card-title float-sm-right" href="{{ route('admin.core.domains.create') }}">{{ __('app.add') }}</a>      
        @endif
    </div>
    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover agrid" id="domains-grid"></table>
    </div>    
</div>    
@endsection

@push('scripts')
<script>    
$(function () {

    var tableAgrid = $('#domains-grid').aGrid({
        url: '{{ route("admin.core.domains.index") }}',
        permissions: {
            update: {{ allow('core.domain.update') ? true : false }},
            destroy: {{ allow('core.domain.destroy') ? true : false }},
        },
        columns: [
			{
				name: 'id',
				label: "id"
			},
			{
				name: 'alias',
				label: "{{ __('core::domain.fields.alias') }}",
                render: function(value) {
                    return `<a href="//${value}" target="_blank">${value}</a>`;
                },
			},
			{
				name: 'is_active',
				label: "{{ __('core::domain.fields.is_active') }}",
                render: function(value) {
                    return aGridExt.renderYesNo(value);
                },
                filter: {type: 'select'}
			},
			{
				name: 'lang',
				label: "{{ __('core::domain.fields.lang') }}",
                render: function(value) {
                    return aGridExt.renderBadge(value, 'info');
                },
			},
			{
				name: 'rank',
				label: "{{ __('core::domain.fields.rank') }}"
			},
			{
				name: 'title',
				label: "{{ __('core::domain.fields.title') }}"
			},
          ],
        sort: {
            attr: 'id',
            dir: 'asc'
        },
        rowActions: aGridExt.defaultRowActions({
            baseUrl: '{{ route("admin.core.domains.index") }}'
        }),    
        theadPanelCols: {
            pager: 'col-sm-4',
            actions: 'col-sm-8'
        }                    
    });
});
</script>
@endpush