@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-700">Role Details: {{ $role->name }}</h1>
        <a href="{{ route('admin.roles.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Back to Roles List
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <strong class="text-gray-700">ID:</strong>
            <p class="text-gray-900">{{ $role->id }}</p>
        </div>
        <div class="mb-4">
            <strong class="text-gray-700">Name:</strong>
            <p class="text-gray-900">{{ $role->name }}</p>
        </div>
        <div class="mb-4">
            <strong class="text-gray-700">Guard Name:</strong>
            <p class="text-gray-900">{{ $role->guard_name }}</p>
        </div>
        <div class="mb-6">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Permissions:</strong>
            @if($rolePermissions->count() > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach($rolePermissions as $permissionName)
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $permissionName }}
                        </span>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No permissions assigned to this role.</p>
            @endif
        </div>

        <div class="mt-6">
            {{-- @can('edit roles') --}}
            <a href="{{ route('admin.roles.edit', $role->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-3">
                Edit Role
            </a>
            {{-- @endcan --}}
            {{-- @can('delete roles') --}}
                @if($role->name !== 'Super Admin')
                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?');" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Delete Role
                    </button>
                </form>
                @endif
            {{-- @endcan --}}
        </div>
    </div>
</div>
@endsection 