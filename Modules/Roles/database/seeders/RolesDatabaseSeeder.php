<?php

namespace Modules\Roles\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Roles\Models\Permission;
use Modules\Roles\Models\Role;

class RolesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Role::create([
            'name'    => 'Super Admin',
            'name_ar' => 'مشرف عام',
            'undeleteble' => 1
        ]);

        Role::create([
            'name'    => 'admin',
            'name_ar' => 'مشرف',
            'undeleteble' => 1
        ]);

        Role::create([
            'name'    => 'professor',
            'name_ar' => 'معلم',
            'undeleteble' => 1
        ]);

        Role::create([
            'name'    => 'student',
            'name_ar' => 'طالب',
            'undeleteble' => 1
        ]);

        Role::create([
            'name'    => 'staff',
            'name_ar' => 'عضو إدارة',
            'undeleteble' => 1
        ]);

        // PERMISSIONS =========================================================

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
            'name_ar' => 'مشاهدة أعضاء الإدارة',
            'name_en' => 'Show moderators',
            'module'  => 'Moderators',
        ]);
        Permission::create([
            'name'    => 'moderators.create',
            'name_ar' => 'إضافة عضو إدارة',
            'name_en' => 'Create a moderator',
            'module'  => 'Moderators',
        ]);
        Permission::create([
            'name'    => 'moderators.edit',
            'name_ar' => 'تعديل بيانات أعضاء الإدارة',
            'name_en' => 'Edit moderators',
            'module'  => 'Moderators',
        ]);
        Permission::create([
            'name'    => 'moderators.delete',
            'name_ar' => 'حذف عضو إدارة',
            'name_en' => 'Delete moderators',
            'module'  => 'Moderators',
        ]);

        //***************************************************************** */
        Permission::create([
            'name'    => 'professors.index',
            'name_ar' => 'مشاهدة المعلمين',
            'name_en' => 'Show professors',
            'module'  => 'Professors',
        ]);
        Permission::create([
            'name'    => 'professors.create',
            'name_ar' => 'إضافة معلم',
            'name_en' => 'Create a professor',
            'module'  => 'Professors',
        ]);
        Permission::create([
            'name'    => 'professors.edit',
            'name_ar' => 'تعديل بيانات معلم',
            'name_en' => 'Edit professors',
            'module'  => 'Professors',
        ]);
        Permission::create([
            'name'    => 'professors.delete',
            'name_ar' => 'حذف معلم',
            'name_en' => 'Delete professors',
            'module'  => 'Professors',
        ]);

        //****************************************************************** */
        Permission::create([
            'name'    => 'roles.index',
            'name_ar' => 'مشاهدة جميع الأدوار',
            'name_en' => 'Show all roles',
            'module'  => 'Roles',
        ]);
        Permission::create([
            'name'    => 'roles.show',
            'name_ar' => 'مشاهدة الأدوار',
            'name_en' => 'Show roles',
            'module'  => 'Roles',
        ]);
        Permission::create([
            'name'    => 'roles.create',
            'name_ar' => 'إضافة دور',
            'name_en' => 'Create a roles',
            'module'  => 'Roles',
        ]);
        Permission::create([
            'name'    => 'roles.edit',
            'name_ar' => 'تعديل بيانات الأدوار',
            'name_en' => 'Edit roles',
            'module'  => 'Roles',
        ]);
        Permission::create([
            'name'    => 'roles.delete',
            'name_ar' => 'حذف الأدوار',
            'name_en' => 'Delete roles',
            'module'  => 'Roles',
        ]);

        //********************************************************************** */
        Permission::create([
            'name'    => 'courses.index',
            'name_ar' => 'مشاهدة جميع المقررات',
            'name_en' => 'Show all courses',
            'module'  => 'Courses',
        ]);
        Permission::create([
            'name'    => 'courses.show',
            'name_ar' => 'مشاهدة المقررات',
            'name_en' => 'Show courses',
            'module'  => 'Courses',
        ]);
        Permission::create([
            'name'    => 'courses.create',
            'name_ar' => 'إضافة مقرر',
            'name_en' => 'Create a courses',
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
        Permission::create([
            'name'    => 'schedule.index',
            'name_ar' => 'الاطلاع على الجدول الدراسي',
            'name_en' => 'Show schedule',
            'module'  => 'Courses',
        ]);
        Permission::create([
            'name'    => 'schedule.edit',
            'name_ar' => 'التعديل على الجدول الدراسي',
            'name_en' => 'Edit schedule',
            'module'  => 'Courses',
        ]);
        Permission::create([
            'name'    => 'courses.enrollment',
            'name_ar' => 'تسجيل مقررات',
            'name_en' => 'Enrolling in courses',
            'module'  => 'Courses',
        ]);
        Permission::create([
            'name'    => 'courses.student.show',
            'name_ar' => 'مشاهدة المقررات الفصل كطالب',
            'name_en' => 'Showing smester courses as a student',
            'module'  => 'Courses',
        ]);
        Permission::create([
            'name'    => 'courses.professor.show',
            'name_ar' => 'مشاهدة المقررات الفصل كمعلم',
            'name_en' => 'Showing semseter courses as a professor',
            'module'  => 'Courses',
        ]);
        Permission::create([
            'name'    => 'courses.requests.stats',
            'name_ar' => 'الاطلاع على نتائج طلبات المقررات',
            'name_en' => 'Showing courses requests stats',
            'module'  => 'Courses',
        ]);
        Permission::create([
            'name'    => 'courses.professor-show',
            'name_ar' => 'مشاهدة المقررات الفصل كمعلم',
            'name_en' => 'Showing semseter courses as a professor',
            'module'  => 'Courses',
        ]);

        //************************************************************************** */
        Permission::create([
            'name'    => 'halls.view',
            'name_ar' => 'عرض القاعات',
            'name_en' => 'View halls',
            'module'  => 'Halls',
        ]);

        Permission::create([
            'name'    => 'halls.create',
            'name_ar' => 'إضافة قاعة',
            'name_en' => 'Create a hall',
            'module'  => 'Halls',
        ]);

        Permission::create([
            'name'    => 'halls.update',
            'name_ar' => 'تحديث القاعة',
            'name_en' => 'Update a hall',
            'module'  => 'Halls',
        ]);

        Permission::create([
            'name'    => 'halls.delete',
            'name_ar' => 'حذف القاعة',
            'name_en' => 'Delete a hall',
            'module'  => 'Halls',
        ]);

        Permission::create([
            'name'    => 'halls.manage_status',
            'name_ar' => 'إدارة حالة القاعة',
            'name_en' => 'Manage hall status',
            'module'  => 'Halls',
        ]);

        Permission::create([
            'name'    => 'semester.settings',
            'name_ar' => 'إعدادات الفصل الدراسي',
            'name_en' => 'Semester settings',
            'module'  => 'Semesters',
        ]);

        Permission::create([
            'name' => 'quizzes.index',
            'name_ar' => 'عرض الامتحانات كمعلم',
            'name_en' => 'Show quizzes list as a professor',
            'module' => 'Quizzes',
        ]);

        Permission::create([
            'name' => 'quizzes.show',
            'name_ar' => 'عرض امتحان كمعلم',
            'name_en' => 'Show a quiz as a professor',
            'module' => 'Quizzes',
        ]);

        Permission::create([
            'name' => 'quizzes.create',
            'name_ar' => 'إنشاء امتحانات',
            'name_en' => 'Create quizzes',
            'module' => 'Quizzes',
        ]);

        Permission::create([
            'name' => 'quizzes.edit',
            'name_ar' => 'تعديل امتحانات',
            'name_en' => 'Create edit',
            'module' => 'Quizzes',
        ]);

        Permission::create([
            'name' => 'quizzes.index-student',
            'name_ar' => 'عرض قائمة الامتحانات كطالب',
            'name_en' => 'Show quizzes list as a student',
            'module' => 'Quizzes',
        ]);

        Permission::create([
            'name' => 'quizzes.take-quiz',
            'name_ar' => 'خوض الامتحانات',
            'name_en' => 'Take quizzes',
            'module' => 'Quizzes',
        ]);

        Permission::create([
            'name' => 'students.guidence',
            'name_ar' => 'إرشاد الطلاب',
            'name_en' => 'Guide students',
            'module' => 'Students',
        ]);

        Permission::create([
            'name' => 'students.guidence.edit',
            'name_ar' => 'تعديل إرشاد الطلاب',
            'name_en' => 'Edit students guidences',
            'module' => 'Students',
        ]);

        $this->call([]);
    }
}
