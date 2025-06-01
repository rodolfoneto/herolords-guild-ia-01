@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-700">Permission Details: {{ $permission->name }}</h1>
        <a href="{{ route('admin.permissions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Back to Permissions List
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <strong class="text-gray-700">ID (UUID):</strong>
            <p class="text-gray-900">{{ $permission->uuid }}</p>
        </div>
        <div class="mb-4">
            <strong class="text-gray-700">Name:</strong>
            <p class="text-gray-900">{{ $permission->name }}</p>
        </div>
        <div class="mb-4">
            <strong class="text-gray-700">Guard Name:</strong>
            <p class="text-gray-900">{{ $permission->guard_name }}</p>
        </div>
        <div class="mb-4">
            <strong class="text-gray-700">Created At:</strong>
            <p class="text-gray-900">{{ $permission->created_at->toDayDateTimeString() }}</p>
        </div>
        <div class="mb-6">
            <strong class="text-gray-700">Updated At:</strong>
            <p class="text-gray-900">{{ $permission->updated_at->toDayDateTimeString() }}</p>
        </div>

        <div class="mt-6">
            {{-- @can('edit permissions') --}}
            <a href="{{ route('admin.permissions.edit', $permission->uuid) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-3">
                Edit Permission
            </a>
            {{-- @endcan --}}
            {{-- @can('delete permissions') --}}
            <form action="{{ route('admin.permissions.destroy', $permission->uuid) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this permission? It might affect existing roles.');" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Delete Permission
                </button>
            </form>
            {{-- @endcan --}}
        </div>
    </div>
</div>
@endsection 