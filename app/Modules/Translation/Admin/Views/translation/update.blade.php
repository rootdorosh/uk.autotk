@extends('admin.layouts.main')

@section('title', __('translation::translation.title.update'))
@section('module', 'translation')

@section('content')
<div class="card card-info card-outline">
    <div class="card-header p-2 border-bottom-0">
        <h3 class="card-title float-sm-left">{{ __('translation::translation.title.update') }}</h3>
    </div>    
    <div class="card-body">    
        @if (!empty($translation->params))
        <div class="mb-2">
            @foreach ($translation->params as $param)
                <span class="badge badge-info">[{{ $param }}]</span>
            @endforeach
            </div>
        @endif
        
        @include('Translation.admin::translation._form', [
            'action' => route('admin.translation.translations.update', [$translation->id]),
        ])
    </div>    
</div>    
@endsection