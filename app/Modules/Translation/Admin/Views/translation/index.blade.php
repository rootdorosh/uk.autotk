@extends('admin.layouts.main')

@section('title', __('translation::translation.title.index'))
@section('module', 'translation')

@section('content')
<div class="card card-info card-outline">
    <div class="card-header">
        <h3 class="card-title float-sm-left">{{ __('translation::translation.title.index') }}</h3>
        @if (allow('translation.translation.store'))
        <a class="btn btn-success btn-xs card-title float-sm-right" href="{{ route('admin.translation.translations.create') }}">{{ __('app.add') }}</a>      
        @endif
    </div>
    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover agrid" id="translations-grid"></table>
    </div>    
</div>    
@endsection

@push('scripts')
<script>    
$(function () {

    var tableAgrid = $('#translations-grid').aGrid({
        url: '{{ route("admin.translation.translations.index") }}',
        permissions: {
            update: {{ allow('translation.translation.update') ? true : false }},
            destroy: {{ allow('translation.translation.destroy') ? true : false }},
        },
        columns: [
			{
				name: 'id',
				label: "id"
			},
			{
				name: 'slug',
				label: "{{ __('translation::translation.fields.slug') }}"
			},
			{
				name: 'value',
				label: "{{ __('translation::translation.fields.value') }}"
			},
			{
				name: 'params',
				label: "{{ __('translation::translation.fields.params') }}"
			},
          ],
        sort: {
            attr: 'id',
            dir: 'asc'
        },
        rowActions: aGridExt.defaultRowActions({
            baseUrl: '{{ route("admin.translation.translations.index") }}'
        }),    
        theadPanelCols: {
            pager: 'col-sm-4',
            actions: 'col-sm-8'
        }                    
    });
});
</script>
@endpush