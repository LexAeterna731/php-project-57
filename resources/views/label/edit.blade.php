@extends('layouts.app')

@section('content')
    <div class="grid col-span-full">
        <h1 class="mb-5">
            {{ __('layout.update_label') }}
        </h1>

        {{ Form::model($label, ['route' => ['labels.store', $label], 'method' => 'PATCH', 'class' => 'w-50']) }}
            <div class="flex flex-col">
                <div>
                    {{ Form::label('name', __('layout.name')) }}
                </div>
                <div class="mt-2">
                    {{ Form::text('name', $label->name, ['class' => 'form-control rounded border-gray-300 w-1/3']) }}
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
                    {{ Form::textarea('description', $label->description, [
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
                    {{ Form::submit(__('layout.create'), ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }}
                </div>
            </div>
        {{ Form::close() }}

    </div>
@endsection