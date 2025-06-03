import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type Permission, type RoleFormData, type PermissionResponse } from '@/types';
import { Button } from '@headlessui/react';
import { Head, Link, useForm } from '@inertiajs/react';
import { SaveIcon } from 'lucide-react';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Index',
        href: route('admin.roles.index'),
    },
    {
        title: 'Create Role',
        href: route('admin.roles.create'),
    },
];

interface RoleCreateProps {
    permissions: Permission[];
}

export default function RoleCreate({ permissions }: RoleCreateProps) {
    const { data, setData, post, errors, processing } = useForm<RoleFormData>({
        name: '',
        guard_name: 'web', // Default guard_name
        permissions: [],
    });

    const handleCheckboxChange = (permissionName: string) => {
        setData(
            'permissions',
            data.permissions.includes(permissionName)
                ? data.permissions.filter((id) => id !== permissionName)
                : [...data.permissions, permissionName],
        );
    };

    const submit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        post(route('admin.roles.store'));
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create Role" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-semibold">Create Role</h1>
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
                            <span>Save Role</span>
                        </Button>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}
