@extends('admin.layouts.main')

@section('title', __('core::domain.title.update'))
@section('module', 'core')

@section('content')
<div class="card card-info card-outline">
    <div class="card-header p-2 border-bottom-0">
        <h3 class="card-title float-sm-left">{{ __('core::domain.title.update') }}</h3>
    </div>    
    <div class="card-body">    
        @include('Core.admin::domain._form', [
            'action' => route('admin.core.domains.update', [$domain->id]),
        ])
    </div>    
</div>    
@endsection