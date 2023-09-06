@extends('layouts.app')

@section('content')
    <div class="grid col-span-full">
        <h1 class="mb-5">
            {{ __('layout.update_status') }}
        </h1>

        {{ Form::model($taskStatus, ['route' => ['task_statuses.update', $taskStatus], 'method' => 'PATCH', 'class' => 'w-50']) }}
            <div class="flex flex-col">
                <div>
                    {{ Form::label('name', __('layout.name')) }}
                </div>
                <div class="mt-2">
                    {{ Form::text('name', $taskStatus->name, ['class' => 'form-control rounded border-gray-300 w-1/3']) }}
                </div>
                <div class="mt-2">
                    {{ Form::submit(__('layout.update'), ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }}
                </div>
            </div>
        {{ Form::close() }}

    </div>
@endsection