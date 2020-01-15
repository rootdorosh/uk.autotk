<?php 
use Illuminate\Support\Str;

$columns='';

$fields = $model['fields']; 
if (!empty($model['translatable'])) {
    $fields = $fields + $model['translatable']['fields'];
}

$columns .= "\t\t\t{\n";
$columns .= "\t\t\t\tname: 'id',\n";
$columns .= "\t\t\t\tlabel: \"id\"\n";
$columns .= "\t\t\t},\n";

foreach ($fields as $key => $field) {
    if (empty($field['filter'])) {
        continue;
    }
    
    $columns .= "\t\t\t{\n";
    $columns .= "\t\t\t\tname: '".$key."',\n";
    $columns .= "\t\t\t\tlabel: \"{{ __('".Str::snake($moduleData['name'])."::".Str::snake($model['name']).".fields.".$key."') }}\"\n";
    $columns .= "\t\t\t},\n";
}   

?>

@extends('admin.layouts.main')

@section('title', __('<?= Str::snake($moduleData['name'])?>::<?= Str::snake($model['name'])?>.title.index'))
@section('module', '<?= Str::snake($moduleData['name'])?>')

@section('content')
<div class="card card-info card-outline">
    <div class="card-header">
        <h3 class="card-title float-sm-left">{{ __('<?= Str::snake($moduleData['name'])?>::<?= Str::snake($model['name'])?>.title.index') }}</h3>
        @if (allow('<?= Str::camel($moduleName)?>.<?= Str::camel($model['name'])?>.store'))
        <a class="btn btn-success btn-xs card-title float-sm-right" href="{{ route('admin.<?= Str::kebab($moduleData['name'])?>.<?= Str::kebab($model['name_plural'])?>.create') }}">{{ __('app.add') }}</a>      
        @endif
    </div>
    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover agrid" id="<?= Str::kebab($model['name_plural'])?>-grid"></table>
    </div>    
</div>    
@endsection

@push('scripts')
<script>    
$(function () {

    var tableAgrid = $('#<?= Str::kebab($model['name_plural'])?>-grid').aGrid({
        url: '{{ route("admin.<?= Str::kebab($moduleData['name'])?>.<?= Str::kebab($model['name_plural'])?>.index") }}',
        permissions: {
            update: {{ allow('<?= Str::camel($moduleName)?>.<?= Str::camel($model['name'])?>.update') ? true : false }},
            destroy: {{ allow('<?= Str::camel($moduleName)?>.<?= Str::camel($model['name'])?>.destroy') ? true : false }},
        },
        columns: [
<?= $columns?>          ],
        sort: {
            attr: 'id',
            dir: 'asc'
        },
        rowActions: aGridExt.defaultRowActions({
            baseUrl: '{{ route("admin.<?= Str::kebab($moduleData['name'])?>.<?= Str::kebab($model['name_plural'])?>.index") }}'
        }),    
        theadPanelCols: {
            pager: 'col-sm-4',
            actions: 'col-sm-8'
        }                    
    });
});
</script>
@endpush