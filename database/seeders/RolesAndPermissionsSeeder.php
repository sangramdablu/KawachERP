<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // ALWAYS reset cached permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Use guard_name = school for ALL roles + permissions
        $permissions = [
            'manage students',
            'manage teachers',
            'manage subjects',
            'manage classes',
            'manage exams',
            'view dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'school',
            ]);
        }

        // Create roles with guard_name = school
        $admin   = Role::firstOrCreate(['name' => 'Admin',   'guard_name' => 'school']);
        $teacher = Role::firstOrCreate(['name' => 'Teacher', 'guard_name' => 'school']);
        $student = Role::firstOrCreate(['name' => 'Student', 'guard_name' => 'school']);
        $parent  = Role::firstOrCreate(['name' => 'Parent',  'guard_name' => 'school']);

        // Admin = everything
        $admin->syncPermissions(Permission::all());

        // Teacher
        $teacher->syncPermissions([
            'manage students',
            'manage classes',
            'manage subjects',
            'view dashboard',
        ]);

        // Student
        $student->syncPermissions([
            'view dashboard',
        ]);

        // Parent
        $parent->syncPermissions([
            'view dashboard',
        ]);
    }
}





// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;

// class RolesAndPermissionsSeeder extends Seeder
// {
//     public function run()
//     {
//         // Reset cached roles and permissions
//         app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

//         // Permissions for modules
//         $permissions = [
//             'manage students',
//             'manage teachers',
//             'manage subjects',
//             'manage classes',
//             'manage exams',
//             'view dashboard',
//         ];

//         foreach ($permissions as $permission) {
//             Permission::firstOrCreate([
//                 'name' => $permission,
//                 'guard_name' => 'web'
//             ]);
//         }

//         // Create roles
//         $admin   = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'school']);
//         $teacher = Role::firstOrCreate(['name' => 'Teacher', 'guard_name' => 'teacher']);
//         $student = Role::firstOrCreate(['name' => 'Student', 'guard_name' => 'student']);
//         $parent  = Role::firstOrCreate(['name' => 'Parent', 'guard_name' => 'parent']);

//         // Assign permissions
//         $admin->syncPermissions(Permission::all());

//         $teacher->syncPermissions([
//             'manage students',
//             'manage classes',
//             'manage subjects',
//             'view dashboard',
//         ]);

//         $student->syncPermissions(['view dashboard']);

//         $parent->syncPermissions(['view dashboard']);
//     }
// }
