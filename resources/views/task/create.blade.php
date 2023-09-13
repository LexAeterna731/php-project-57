@extends('layouts.app')

@section('content')
    <div class="grid col-span-full">
        <h1 class="mb-5">
            {{ __('layout.create_task') }}
        </h1>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif        
        {{ Form::model($task, ['route' => 'tasks.store', 'class' => 'w-50']) }}
            <div class="flex flex-col">
                <div>
                    {{ Form::label('name', __('layout.name')) }}
                </div>
                <div class="mt-2">
                    {{ Form::text('name', '', ['class' => 'rounded border-gray-300 w-1/3']) }}
                </div>
                @error('name')
                    <div class="text-rose-600">
                        {{ $message }}
                    </div>
                @enderror
                <div>
                    {{ Form::label('description', __('layout.description')) }}
                </div>
                <div>
                    {{ Form::textarea('description', '', [
                        'class' => 'rounded border-gray-300 w-1/3 h-32',
                        'cols' => '50',
                        'rows' => '10'
                        ]) }}
                </div>
                @error('description')
                    <div class="text-rose-600">
                        {{ $message }}
                    </div>
                @enderror
                <div class="mt-2">
                    {{ Form::label('status_id', __('layout.status')) }}
                </div>
                <div>
                    {{ Form::select('status_id', $statuses, null, [
                        'placeholder' => '----------',
                        'class' => 'rounded border-gray-300 w-1/3 h-32'
                    ]) }}
                </div>
                @error('status_id')
                    <div class="text-rose-600">
                        {{ $message }}
                    </div>
                @enderror
                <div class="mt-2">
                    {{ Form::label('assigned_to_id', __('layout.executor')) }}
                </div>
                <div>
                    {{ Form::select('assigned_to_id', $users, null, [
                        'placeholder' => '----------',
                        'class' => 'rounded border-gray-300 w-1/3 h-32'
                    ]) }}
                </div>
                @error('assigned_to_id')
                    <div class="text-rose-600">
                        {{ $message }}
                    </div>
                @enderror
                <div class="mt-2">
                    {{ Form::submit(__('layout.create'), ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }}
                </div>
            </div>
        {{ Form::close() }}

    </div>
@endsection