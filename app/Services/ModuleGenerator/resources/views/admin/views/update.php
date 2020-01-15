@extends('admin.layouts.main')

@section('title', __('<?= Str::snake($moduleData['name'])?>::<?= Str::snake($model['name'])?>.title.update'))
@section('module', '<?= Str::snake($moduleData['name'])?>')

@section('content')
<div class="card card-info card-outline">
    <div class="card-header p-2 border-bottom-0">
        <h3 class="card-title float-sm-left">{{ __('<?= Str::snake($moduleData['name'])?>::<?= Str::snake($model['name'])?>.title.update') }}</h3>
    </div>    
    <div class="card-body">    
        @include('<?= $moduleData['name']?>.admin::<?= Str::camel($model['name'])?>._form', [
            'action' => route('admin.<?= Str::kebab($moduleData['name'])?>.<?= Str::kebab($model['name_plural'])?>.update', [$<?= Str::camel($model['name'])?>->id]),
        ])
    </div>    
</div>    
@endsection