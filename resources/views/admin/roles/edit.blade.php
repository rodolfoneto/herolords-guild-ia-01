@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold text-gray-700 mb-6">Edit Role: {{ $role->name }}</h1>

    <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Role Name:</label>
                <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Permissions:</label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($permissions as $id => $name)
                        <div class="flex items-center">
                            <input type="checkbox" name="permissions[]" id="permission_{{ $id }}" value="{{ $name }}" 
                                   class="form-checkbox h-5 w-5 text-blue-600" 
                                   {{ in_array($name, $rolePermissions) ? 'checked' : '' }}>
                            <label for="permission_{{ $id }}" class="ml-2 text-gray-700">{{ $name }}</label>
                        </div>
                    @empty
                         <p class="text-gray-500">No permissions available.</p>
                         <p class="text-gray-500">You can create permissions using <code class="bg-gray-200 p-1 rounded text-sm">php artisan permission:create-permission "permission name"</code></p>
                    @endforelse
                </div>
                 @error('permissions')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
                 @error('permissions.*')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Role
                </button>
                <a href="{{ route('admin.roles.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection 