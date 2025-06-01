@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-700">Manage Permissions</h1>
        {{-- @can('create permissions') --}}
        <a href="{{ route('admin.permissions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Create New Permission
        </a>
        {{-- @endcan --}}
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Name
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Guard
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($permissions as $permission)
                    <tr>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $permission->name }}</p>
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $permission->guard_name }}</p>
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            {{-- @can('view permissions') --}}
                            <a href="{{ route('admin.permissions.show', $permission->uuid) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                            {{-- @endcan --}}
                            {{-- @can('edit permissions') --}}
                            <a href="{{ route('admin.permissions.edit', $permission->uuid) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                            {{-- @endcan --}}
                            {{-- @can('delete permissions') --}}
                            <form action="{{ route('admin.permissions.destroy', $permission->uuid) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this permission? It might affect existing roles.');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                            {{-- @endcan --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                            No permissions found. You can create them using <code class="bg-gray-200 p-1 rounded text-sm">php artisan permission:create-permission "permission.name"</code> or via the create button.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
            {{ $permissions->links() }}
        </div>
    </div>
</div>
@endsection 