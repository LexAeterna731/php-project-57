@extends('layouts.app')

@section('content')
    @include('flash::message')

    <div class="grid col-span-full">
        <h1 class="mb-5">
            {{ __('layout.statuses') }}
        </h1>

        @auth
            <div>
                <a href="{{ route('task_statuses.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('layout.create_status') }}
                </a>
            </div>
        @endauth

        <table class="mt-4">
            <thead class="border-b-2 border-solid border-black text-left">
                <tr>
                    <th>
                        {{ __('layout.table_id') }}
                    </th>
                    <th>
                        {{ __('layout.table_name') }}
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

            @foreach ($taskStatuses as $taskStatus)
                <tr class="border-b border-dashed text-left">
                    <td>
                        {{ $taskStatus->id }}
                    </td>
                    <td>
                        {{ $taskStatus->name }}
                    </td>
                    <td>
                        {{ $taskStatus->created_at }}
                    </td>

                    @auth
                        <td>
                            <a data-confirm="{{ __('layout.delete_pop_up') }}" rel="nofollow" data-method="delete" class="text-red-600 hover:text-red-900" href="{{ route('task_statuses.destroy', $taskStatus) }}">
                                {{ __('layout.table_delete') }}
                            </a>
                            <a class="text-blue-600 hover:text-blue-900" href="{{ route('task_statuses.edit', $taskStatus) }}">
                                {{ __('layout.table_update') }}
                            </a>
                        </td>
                    @endauth

                </tr>
            @endforeach

            </tbody>
        </table>

        <div class="mt-4 grid col-span-full">{{ $taskStatuses->links() }}</div>

    </div>
@endsection
