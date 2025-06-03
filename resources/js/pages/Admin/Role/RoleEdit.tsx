import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type Permission, type Role, type RoleFormData } from '@/types';
import { Button } from '@headlessui/react';
import { Head, Link, useForm } from '@inertiajs/react';
import { SaveIcon } from 'lucide-react';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

interface RoleEditProps {
    role: Role;
    permissions: Permission[];
    rolePermissions: Permission[];
}

export default function RoleEdit({ role, permissions, rolePermissions }: RoleEditProps) {

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Roles',
            href: route('admin.roles.index'),
        },
        {
            title: role.name,
            href: route('admin.roles.edit', { role: role.uuid }), // Assuming route key is 'role' for the UUID
        },
        {
            title: 'Edit',
            href: route('admin.roles.edit', { role: role.uuid }),
        },
    ];

    // @ts-expect-error TSC can't reconcile [key: string]: unknown with array properties like permissions: string[]
    const { data, setData, put, errors, processing } = useForm<RoleFormData>({
        name: role.name || '',
        guard_name: role.guard_name || 'web',
        permissions: role.permissions?.map(p => p.name) || [], // Initialize with current role's permission names
    });

    const handleCheckboxChange = (permissionName: string) => {
        setData(
            'permissions',
            data.permissions.includes(permissionName)
                ? data.permissions.filter((name) => name !== permissionName)
                : [...data.permissions, permissionName],
        );
    };

    const submit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        put(route('admin.roles.update', { role: role.uuid })); // Use PUT for update, pass role UUID
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Edit Role: ${role.name}`} />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-semibold">Edit Role: {role.name}</h1>
                </div>
                <form onSubmit={submit} className="space-y-6">
                    <div>
                        <Label htmlFor="name">Role Name</Label>
                        <Input
                            id="name"
                            name="name"
                            value={data.name}
                            className="mt-1 block w-full"
                            autoComplete="name"
                            onChange={(e) => setData('name', e.target.value)}
                            required
                        />
                        {errors.name && <p className="mt-2 text-sm text-red-600">{errors.name}</p>}
                    </div>

                    <div>
                        <Label htmlFor="guard_name">Guard Name</Label>
                        <Input
                            id="guard_name"
                            name="guard_name"
                            value={data.guard_name}
                            className="mt-1 block w-full"
                            autoComplete="guard_name"
                            onChange={(e) => setData('guard_name', e.target.value)}
                            required
                        />
                        {errors.guard_name && <p className="mt-2 text-sm text-red-600">{errors.guard_name}</p>}
                    </div>

                    <div>
                        <Label>Permissions</Label>
                        <div className="mt-2 grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                            {permissions.map((permission) => (
                                <div key={permission.name} className="flex items-center">
                                    <Checkbox
                                        id={`permission-${permission.name}`}
                                        checked={data.permissions.includes(permission.name)}
                                        onCheckedChange={() => handleCheckboxChange(permission.name)}
                                    />
                                    <Label htmlFor={`permission-${permission.name}`} className="ml-2">
                                        {permission.name}
                                    </Label>
                                </div>
                            ))}
                        </div>
                        {errors.permissions && (
                            <p className="mt-2 text-sm text-red-600">{errors.permissions}</p>
                        )}
                    </div>

                    <div className="flex items-center justify-end gap-4">
                        <Link
                            href={route('admin.roles.index')}
                            className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-400"
                        >
                            Cancel
                        </Link>
                        <Button
                            type="submit"
                            className="flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                            disabled={processing}
                        >
                            <SaveIcon className="h-5 w-5" />
                            <span>Update Role</span>
                        </Button>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
} 