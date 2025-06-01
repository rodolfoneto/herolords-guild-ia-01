@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold text-gray-700 mb-6">Edit Permission: {{ $permission->name }}</h1>

    <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
        <form action="{{ route('admin.permissions.update', $permission->uuid) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Permission Name:</label>
                <input type="text" name="name" id="name" value="{{ old('name', $permission->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" required>
                 <p class="text-xs text-gray-600 mt-1">Example: <code class="bg-gray-200 p-1 rounded">edit articles</code>, <code class="bg-gray-200 p-1 rounded">delete users</code>.</p>
                @error('name')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="guard_name" class="block text-gray-700 text-sm font-bold mb-2">Guard Name: (Optional)</label>
                <input type="text" name="guard_name" id="guard_name" value="{{ old('guard_name', $permission->guard_name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('guard_name') border-red-500 @enderror">
                 <p class="text-xs text-gray-600 mt-1">Default is <code class="bg-gray-200 p-1 rounded">web</code>. Change only if you have multiple guards.</p>
                @error('guard_name')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Permission
                </button>
                <a href="{{ route('admin.permissions.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection 