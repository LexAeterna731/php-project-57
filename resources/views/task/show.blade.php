@extends('layouts.app')

@section('content')
    <div class="grid col-span-full">
        <h2 class="mb-5">
            {{ __('layout.view_task') }}: {{ $task->name }}
            @auth
                <a href="{{ route('tasks.edit', $task) }}">⚙</a>
            @endauth
        </h2>
        <p>
            <span class="font-black">{{ __('layout.name') }}:</span> {{ $task->name }}
        </p>
        <p>
            <span class="font-black">{{ __('layout.status') }}:</span> {{ $task->status->name }}
        </p>
        <p>
            <span class="font-black">{{ __('layout.description') }}:</span> {{ $task->description }}
        </p>

    </div>
@endsection