@extends('admin.layouts.main')

@section('title', __('core::page.title.update'))
@section('module', 'core')

@section('content')
<div class="card card-info card-outline">
    <div class="card-header p-2 border-bottom-0">
        <h3 class="card-title float-sm-left">{{ __('core::page.title.update') }}</h3>
    </div>    
    <div class="card-body">   
        
        @if (!empty($page->params))
        <div class="mb-2">
            @foreach ($page->params as $param => $paramTitle)
                <span class="badge badge-info" title="{{ $paramTitle }}">[{{ $param }}]</span>
            @endforeach
            </div>
        @endif
            
        @include('Core.admin::page._form', [
            'action' => r('admin.core.pages.update', [$page->id]),
        ])
    </div>    
</div>    
@endsection