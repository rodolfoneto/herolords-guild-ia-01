import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { Role, RoleResponse, type BreadcrumbItem, type SharedData } from '@/types';
import { Button } from '@headlessui/react';
import { Head, Link, usePage } from '@inertiajs/react';
import { EyeIcon, PencilIcon, PlusIcon, TrashIcon } from 'lucide-react';
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
  } from "@/components/ui/table"
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from "@/components/ui/alert-dialog"
import { Toaster, toast } from 'sonner';
import { useEffect } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Index',
        href: '/admin',
    },
    {
        title: 'Roles',
        href: '/admin/roles',
    }
];

export default function RoleIndex({ roles }: { roles: RoleResponse }) {
    const { props } = usePage<SharedData>();

    useEffect(() => {
        if (props.flash?.success) {
            toast.success(props.flash.success as string);
        }
        if (props.flash?.error) {
            toast.error(props.flash.error as string);
        }
    }, [props.flash]);

    // console.log(roles.data);
    // const { auth } = usePage<SharedData>().props;

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Toaster richColors />
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-semibold">Roles</h1>
                    <Link href={route('admin.roles.create')}>
                        <Button className="flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            <PlusIcon className="h-5 w-5" />
                            <span>Create Role</span>
                        </Button>
                    </Link>
                </div>
                <Table>
                    <TableCaption>A list of your roles.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Name</TableHead>
                            <TableHead>Guard Name</TableHead>
                            <TableHead>Permissions</TableHead>
                            <TableHead>Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {roles.data.map((role) => (
                            <TableRow key={role.uuid}>
                                <TableCell className="font-medium">{role.name}</TableCell>
                                <TableCell>{role.guard_name}</TableCell>
                                <TableCell>
                                    {role.permissions && role.permissions.length > 0 ? (
                                        <div className="flex flex-wrap gap-1">
                                            {role.permissions.map((permission) => (
                                                <span key={permission.uuid} className="px-2 py-1 text-xs font-semibold leading-5 bg-green-100 text-green-800 rounded-full">
                                                    {permission.name}
                                                </span>
                                            ))}
                                        </div>
                                    ) : (
                                        <span className="text-xs text-gray-500">No permissions</span>
                                    )}
                                </TableCell>
                                <TableCell>
                                    <div className="flex gap-2">
                                        <Link href={route('admin.roles.edit', role.uuid)}>
                                            <Button className="text-yellow-600 hover:text-yellow-900">
                                                <PencilIcon className="h-5 w-5" />
                                            </Button>
                                        </Link>
                                        <AlertDialog>
                                            <AlertDialogTrigger asChild>
                                                <Button variant="outline" className="text-red-600 hover:text-red-900 hover:bg-red-100 border-red-600 hover:border-red-700">
                                                    <TrashIcon className="h-5 w-5" />
                                                </Button>
                                            </AlertDialogTrigger>
                                            <AlertDialogContent>
                                                <AlertDialogHeader>
                                                    <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                                                    <AlertDialogDescription>
                                                        This action cannot be undone. This will permanently delete the role "{role.name}".
                                                    </AlertDialogDescription>
                                                </AlertDialogHeader>
                                                <AlertDialogFooter>
                                                    <AlertDialogCancel>Cancel</AlertDialogCancel>
                                                    <AlertDialogAction asChild>
                                                        <Link href={route('admin.roles.destroy', role.uuid)} method="delete" as="button" className="bg-red-600 hover:bg-red-700">
                                                            Delete
                                                        </Link>
                                                    </AlertDialogAction>
                                                </AlertDialogFooter>
                                            </AlertDialogContent>
                                        </AlertDialog>
                                    </div>
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </div>
        </AppLayout>
    );
}