<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        // Create permissions
        $permissions = [
            // User Management
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
           
            // Role Management
            'view_roles',
            'create_roles',
            'edit_roles',
            'delete_roles',
           
            // Permission Management
            'view_permissions',
            'create_permissions',
            'edit_permissions',
            'delete_permissions',
           
            // Course Management
            'view_courses',
            'create_courses',
            'edit_courses',
            'delete_courses',
            
            // Enrollment Management (Ditambahkan untuk MVP 2)
            'view_enrollments',
            'create_enrollments',
            'edit_enrollments',
            'delete_enrollments',
            'approve_enrollments',
            'reject_enrollments',
           
            // Lesson Management
            'view_lessons',
            'create_lessons',
            'edit_lessons',
            'delete_lessons',
           
            // Assignment Management
            'view_assignments',
            'create_assignments',
            'edit_assignments',
            'delete_assignments',
            'grade_assignments',
           
            // Announcement Management
            'view_announcements',
            'create_announcements',
            'edit_announcements',
            'delete_announcements',
           
            // Attendance Management
            'view_attendance',
            'create_attendance',
            'edit_attendance',
            'mark_attendance',
           
            // System Settings
            'manage_system_settings',
            'manage_language_translations',
            'manage_import_export_templates',
            'view_import_export_logs',
           
            // Student Permissions
            'view_enrolled_courses',
            'submit_assignments',
            'view_grades',
            'view_attendance_records',
           
            // Panel Access
            'access_admin_panel',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
        
        $instructorRole = Role::create(['name' => 'instructor']);
        $instructorRole->givePermissionTo([
            'access_admin_panel',
            'view_users',
            
            // Course & Enrollment Management
            'create_courses',
            'edit_courses',
            'view_courses',
            'view_enrollments',
            'edit_enrollments',
            'approve_enrollments',
            'reject_enrollments',
            
            // Lesson Management
            'create_lessons',
            'edit_lessons',
            'view_lessons',
            'delete_lessons',
            
            // Assignment Management
            'create_assignments',
            'edit_assignments',
            'view_assignments',
            'delete_assignments',
            'grade_assignments',
            
            // Announcement Management
            'create_announcements',
            'edit_announcements',
            'view_announcements',
            'delete_announcements',
            
            // Attendance Management
            'create_attendance',
            'edit_attendance',
            'view_attendance',
            'mark_attendance',
        ]);
        
        $studentRole = Role::create(['name' => 'student']);
        $studentRole->givePermissionTo([
            'view_enrolled_courses',
            'view_enrollments',     // Bisa melihat status pendaftaran mereka
            'create_enrollments',   // Bisa mendaftar ke kursus
            'submit_assignments',
            'view_grades',
            'view_attendance_records',
            'view_announcements',
        ]);
    }
}