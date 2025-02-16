<?php

namespace Modules\Roles\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $role = Role::create([
            'name'    => 'Super Admin',
            'name_ar' => 'مشرف عام',
        ]);

        \App\Models\User::findOrFail(1)->assignRole($role);

        Permission::create([
            'name'    => 'students.index',
            'name_ar' => 'مشاهدة الطلاب',
            'name_en' => 'Show students',
            'module'  => 'Students',
        ]);
        Permission::create([
            'name'    => 'students.create',
            'name_ar' => 'إضافة طالب',
            'name_en' => 'Create a student',
            'module'  => 'Students',
        ]);
        Permission::create([
            'name'    => 'students.edit',
            'name_ar' => 'تعديل بيانات الطلاب',
            'name_en' => 'Edit students',
            'module'  => 'Students',
        ]);
        Permission::create([
            'name'    => 'students.delete',
            'name_ar' => 'حذف الطلاب',
            'name_en' => 'Delete students',
            'module'  => 'Students',
        ]);

        //************************************************************************* */
        Permission::create([
            'name'    => 'moderators.index',
            'name_ar' => 'مشاهدة المشرفين',
            'name_en' => 'Show moderators',
            'module'  => 'Moderators',
        ]);
        Permission::create([
            'name'    => 'moderators.create',
            'name_ar' => 'إضافة مشرف',
            'name_en' => 'Create a moderator',
            'module'  => 'Moderators',
        ]);
        Permission::create([
            'name'    => 'moderators.edit',
            'name_ar' => 'تعديل بيانات المشرفين',
            'name_en' => 'Edit moderators',
            'module'  => 'Moderators',
        ]);
        Permission::create([
            'name'    => 'moderators.delete',
            'name_ar' => 'حذف المشرفين',
            'name_en' => 'Delete moderators',
            'module'  => 'Moderators',
        ]);

        //***************************************************************** */
        Permission::create([
            'name'    => 'professors.index',
            'name_ar' => 'مشاهدة الأساتذة',
            'name_en' => 'Show professors',
            'module'  => 'Professors',
        ]);
        Permission::create([
            'name'    => 'professors.create',
            'name_ar' => 'إضافة أستاذ',
            'name_en' => 'Create a professor',
            'module'  => 'Professors',
        ]);
        Permission::create([
            'name'    => 'professors.edit',
            'name_ar' => 'تعديل بيانات الأساتذة',
            'name_en' => 'Edit professors',
            'module'  => 'Professors',
        ]);
        Permission::create([
            'name'    => 'professors.delete',
            'name_ar' => 'حذف الأساتذة',
            'name_en' => 'Delete professors',
            'module'  => 'Professors',
        ]);

        //****************************************************************** */
        Permission::create([
            'name'    => 'courses.index',
            'name_ar' => 'مشاهدة المقررات',
            'name_en' => 'Show courses',
            'module'  => 'Courses',
        ]);
        Permission::create([
            'name'    => 'courses.create',
            'name_ar' => 'إضافة مقرر',
            'name_en' => 'Create a course',
            'module'  => 'Courses',
        ]);
        Permission::create([
            'name'    => 'courses.edit',
            'name_ar' => 'تعديل بيانات المقررات',
            'name_en' => 'Edit courses',
            'module'  => 'Courses',
        ]);
        Permission::create([
            'name'    => 'courses.delete',
            'name_ar' => 'حذف المقررات',
            'name_en' => 'Delete courses',
            'module'  => 'Courses',
        ]);

        //****************************************************************** */
        Permission::create([
            'name'    => 'roles.index',
            'name_ar' => 'مشاهدة الأدوار',
            'name_en' => 'Show roles',
            'module'  => 'Roles',
        ]);
        Permission::create([
            'name'    => 'roles.show',
            'name_ar' => 'مشاهدة الأدوار',
            'name_en' => 'Show roles',
            'module'  => 'Roles',
        ]);
        Permission::create([
            'name'    => 'courses.create',
            'name_ar' => 'إضافة دور',
            'name_en' => 'Create a roles',
            'module'  => 'Roles',
        ]);
        Permission::create([
            'name'    => 'courses.edit',
            'name_ar' => 'تعديل بيانات الأدوار',
            'name_en' => 'Edit roles',
            'module'  => 'Roles',
        ]);
        Permission::create([
            'name'    => 'courses.delete',
            'name_ar' => 'حذف الأدوار',
            'name_en' => 'Delete roles',
            'module'  => 'Roles',
        ]);

        $this->call([]);
    }
}
