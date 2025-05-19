<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EnrollmentPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Daftar permission baru untuk fitur Enrollment
        $newPermissions = [
            'view_enrollments',
            'create_enrollments',
            'edit_enrollments',
            'delete_enrollments',
            'approve_enrollments',
            'reject_enrollments',
        ];
        
        // Buat permission jika belum ada
        foreach ($newPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        
        // Berikan permission ke role Admin
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($newPermissions);
        }
        
        // Berikan permission ke role Instructor
        $instructorRole = Role::where('name', 'instructor')->first();
        if ($instructorRole) {
            $instructorPermissions = [
                'view_enrollments',
                'edit_enrollments',
                'approve_enrollments',
                'reject_enrollments',
            ];
            
            $instructorRole->givePermissionTo($instructorPermissions);
        }
        
        // Berikan permission ke role Student
        $studentRole = Role::where('name', 'student')->first();
        if ($studentRole) {
            $studentPermissions = [
                'view_enrollments',
                'create_enrollments',
            ];
            
            $studentRole->givePermissionTo($studentPermissions);
        }
    }
}