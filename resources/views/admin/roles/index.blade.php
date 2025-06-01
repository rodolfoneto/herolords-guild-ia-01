@extends('layouts.app') {{-- Assuming you have a main layout file, adjust if not --}}

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-700">Manage Roles</h1>
        {{-- @can('create roles') --}}
        <a href="{{ route('admin.roles.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Create New Role
        </a>
        {{-- @endcan --}}
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
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
                        Permissions
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)
                    <tr>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $role->name }}</p>
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            @if($role->permissions->isNotEmpty())
                                @foreach($role->permissions->take(5) as $permission)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                                @if($role->permissions->count() > 5)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        +{{ $role->permissions->count() - 5 }} more
                                    </span>
                                @endif
                            @else
                                <span class="text-gray-500">No permissions assigned</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            {{-- @can('view roles') --}}
                            <a href="{{ route('admin.roles.show', $role->uuid) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                            {{-- @endcan --}}
                            {{-- @can('edit roles') --}}
                            <a href="{{ route('admin.roles.edit', $role->uuid) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                            {{-- @endcan --}}
                            {{-- @can('delete roles') --}}
                                @if($role->name !== 'Super Admin') {{-- Basic check to prevent deleting Super Admin --}}
                                <form action="{{ route('admin.roles.destroy', $role->uuid) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                                @endif
                            {{-- @endcan --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                            No roles found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
         <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
            {{ $roles->links() }} 
        </div>
    </div>
</div>
@endsection 