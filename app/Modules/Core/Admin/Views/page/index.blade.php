@extends('admin.layouts.main')

@section('title', __('core::page.title.index'))
@section('module', 'core')

@section('content')
<div class="card card-info card-outline">
    <div class="card-header">
        <h3 class="card-title float-sm-left">{{ __('core::page.title.index') }}</h3>
        @if (allow('core.page.store'))
        <a class="btn btn-success btn-xs card-title float-sm-right" href="{{ route('admin.core.pages.create') }}">{{ __('app.add') }}</a>      
        @endif
    </div>
    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover agrid" id="pages-grid"></table>
    </div>    
</div>    
@endsection

@push('scripts')
<script>    
$(function () {

    var tableAgrid = $('#pages-grid').aGrid({
        url: '{{ route("admin.core.pages.index") }}',
        permissions: {
            update: {{ allow('core.page.update') ? true : false }},
            destroy: {{ allow('core.page.destroy') ? true : false }},
        },
        columns: [
			{
				name: 'id',
				label: "id"
			},
			{
				name: 'alias',
				label: "{{ __('core::page.fields.alias') }}"
			},
			{
				name: 'title',
				label: "{{ __('core::page.fields.title') }}"
			},
          ],
        sort: {
            attr: 'id',
            dir: 'asc'
        },
        rowActions: aGridExt.defaultRowActions({
            baseUrl: '{{ route("admin.core.pages.index") }}'
        }),    
        theadPanelCols: {
            pager: 'col-sm-4',
            actions: 'col-sm-8'
        }                    
    });
});
</script>
@endpush