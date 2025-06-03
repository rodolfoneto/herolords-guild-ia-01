import { LucideIcon } from 'lucide-react';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    flash?: {
        success?: string;
        error?: string;
        // Add other flash message types if needed (e.g., warning, info)
    };
    [key: string]: unknown;
}

export interface User {
    id: string;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface Role {
    id: string;
    uuid: string;
    name: string;
    guard_name: string;
    permissions?: Permission[];
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface RoleResponse {
    data: Role[];
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: Links[];
    next_page_url: string;
    path: string;
    per_page: number;
    prev_page_url: string;
    to: number;
    total: number;
}

export interface Links {
    url: string;
    label: string;
    active: boolean;
}

export interface Permission {
    uuid: string;
    name: string;
    guard_name: string;
}

export interface PermissionResponse {
    data: Permission[];
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: Links[];
    next_page_url: string;
    path: string;
    per_page: number;
    prev_page_url: string;
    to: number;
    total: number;
}

export interface RoleFormData {
    name: string;
    guard_name: string;
    permissions: string[];
    [key: string]: unknown;
}
