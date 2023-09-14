@extends('layouts.app')

@section('content')
    @include('flash::message')

    <div class="grid col-span-full">
        <h1 class="mb-5">
            {{ __('layout.tasks') }}
        </h1>
        <div class="w-full flex items-center">
            <div>
                {{ Form::open(['route' => 'tasks.index', 'method' => 'GET']) }}
                <div class="flex">
                <div>
                {{ Form::select('filter[status_id]', $statuses, $filter['status_id'] ?? null, [
                    'placeholder' => __('layout.status'),
                    'class' => 'rounded border-gray-300'
                ]) }}
                </div>
                <div>
                {{ Form::select('filter[created_by_id]', $users, $filter['created_by_id'] ?? null, [
                    'placeholder' => __('layout.creator'),
                    'class' => 'rounded border-gray-300'
                ]) }}
                </div>
                <div>
                {{ Form::select('filter[assigned_to_id]', $users, $filter['assigned_to_id'] ?? null, [
                    'placeholder' => __('layout.executor'),
                    'class' => 'rounded border-gray-300'
                ]) }}
                </div>
                <div>
                    {{ Form::submit(__('layout.submit'), [
                        'class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2']
                    ) }}
                </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
        @auth
            <div class="w-full flex items-center">
                <div class="ml-auto">
                    <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                        {{ __('layout.create_task') }}
                    </a>
                </div>
            </div>
        @endauth

        <table class="mt-4">
            <thead class="border-b-2 border-solid border-black text-left">
                <tr>
                    <th>
                        {{ __('layout.table_id') }}
                    </th>
                    <th>
                        {{ __('layout.table_status') }}
                    </th>
                    <th>
                        {{ __('layout.table_name') }}
                    </th>
                    <th>
                        {{ __('layout.table_creator') }}
                    </th>
                    <th>
                        {{ __('layout.table_executor') }}
                    </th>
                    <th>
                        {{ __('layout.table_date') }}
                    </th>

                    @auth
                        <th>
                            {{ __('layout.table_actions') }}
                        </th>
                    @endauth

                </tr>
            </thead>
            <tbody>

            @foreach ($tasks as $task)
                <tr class="border-b border-dashed text-left">
                    <td>
                        {{ $task->id }}
                    </td>
                    <td>
                        {{ $task->status->name }}
                    </td>
                    <td>
                        <a class="text-blue-600 hover:text-blue-900" href="{{ route('tasks.show', $task) }}">
                            {{ $task->name }}
                        </a>
                    </td>
                    <td>
                        {{ $task->creator->name }}
                    </td>
                    <td>
                        {{ $task->executor->name }}
                    </td>
                    <td>
                        {{ date_format($task->created_at, 'd.m.Y') }}
                    </td>

                    @auth
                        <td>
                            @can('delete', $task)
                                <a data-confirm="{{ __('layout.delete_pop_up') }}" rel="nofollow" data-method="delete" class="text-red-600 hover:text-red-900" href="{{ route('tasks.destroy', $task) }}">
                                    {{ __('layout.table_delete') }}
                                </a>
                            @endcan
                            <a class="text-blue-600 hover:text-blue-900" href="{{ route('tasks.edit', $task) }}">
                                {{ __('layout.table_update') }}
                            </a>
                        </td>
                    @endauth

                </tr>
            @endforeach

            </tbody>
        </table>

        <div class="mt-4 grid col-span-full">{{ $tasks->links() }}</div>

    </div>
@endsection