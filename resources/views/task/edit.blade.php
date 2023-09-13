@extends('layouts.app')

@section('content')
    <div class="grid col-span-full">
        <h1 class="mb-5">
            {{ __('layout.update_task') }}
        </h1>

        {{ Form::model($task, ['route' => ['tasks.update', $task], 'method' => 'PATCH', 'class' => 'w-50']) }}
            <div class="flex flex-col">
                <div>
                    {{ Form::label('name', __('layout.name')) }}
                </div>
                <div class="mt-2">
                    {{ Form::text('name', $task->name, ['class' => 'rounded border-gray-300 w-1/3']) }}
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
                    {{ Form::textarea('description', $task->description, [
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
                    {{ Form::select('status_id', $statuses, $task->status_id, [
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
                    {{ Form::select('assigned_to_id', $users, $task->assigned_to_id, [
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
                    {{ Form::label('labels', __('layout.labels')) }}
                </div>
                <div class="mt-2">
                    {{ Form::select('labels[]', $labels, $task->labels, [
                        'placeholder' => '',
                        'class' => 'form-control rounded border-gray-300 w-1/3 h-32',
                        'multiple' => 'multiple'
                    ]) }}
                </div>                
                <div class="mt-2">
                    {{ Form::submit(__('layout.update'), ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }}
                </div>
            </div>
        {{ Form::close() }}

    </div>
@endsection