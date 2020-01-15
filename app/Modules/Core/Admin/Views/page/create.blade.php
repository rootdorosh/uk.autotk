@extends('admin.layouts.main')

@section('title', __('core::page.title.create'))
@section('module', 'core')

@section('content')
<div class="card card-info card-outline">
    <div class="card-header p-2 border-bottom-0">
        <h3 class="card-title float-sm-left">{{ __('core::page.title.create') }}</h3>
    </div>    
    <div class="card-body">    
        @include('Core.admin::page._form', [
            'action' => route('admin.core.pages.store'),
        ])
    </div>    
</div>    
@endsection