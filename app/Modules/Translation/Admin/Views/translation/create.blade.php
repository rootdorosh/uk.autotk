@extends('admin.layouts.main')

@section('title', __('translation::translation.title.create'))
@section('module', 'translation')

@section('content')
<div class="card card-info card-outline">
    <div class="card-header p-2 border-bottom-0">
        <h3 class="card-title float-sm-left">{{ __('translation::translation.title.create') }}</h3>
    </div>    
    <div class="card-body">    
        @include('Translation.admin::translation._form', [
            'action' => route('admin.translation.translations.store'),
        ])
    </div>    
</div>    
@endsection