<?php

return [
    'roles' => [
        'title' => 'نوع المستخدم',
        'permissions_number' => 'عدد الصلاحيات',
        'users_number' => 'عدد المسجلين في الدور',
        'permissions' => 'الصلاحيات:',
        'success' => [
            'create' => 'نجح إنشاء نوع مستخدم جديد',
            'update' => 'نجح تعديل نوع المستخدم',
        ],
        'failure' => 'فشل إنشاء نوع المستخدم',
        'create' => 'إضافة نوع مستخدم',
        'edit' => 'تعديل نوع مستخدم',
    ],

    'students' => [
        'name' => 'اسم الطالب',
        'gender' => 'النوع',
        'credits' => 'الساعات المكتسبة',
        'level' => 'المرحلة',
        'gpa' => 'GPA',
        'success' => [
            'store' => 'نجح إنشاء طالب جديد',
            'update' => 'نجح تعديل بيانات الطالب',
        ],
        'create' => 'إضافة طالب',
        'show' => 'عرض بيانات الطالب',
        'edit' => 'تعديل البيانات',
        'index' => 'عرض الطلاب',
        'empty' => 'لا يوجد طلّاب للعرض',
        'credits_to_enroll' => 'عدد الساعات المتبقية المسموحة للتسجيل',
        'total_earned_credits' => 'عدد الساعات المنتهية',
        'head_professor' => 'المشرف الأكاديمي',
        'core_earned_credits' => 'الساعات الأساسية المنتهية',
        'university_elected_earned_credits' => 'ساعات متطلبات الجامعة المنتهية',
        'faculty_elected_earned_credits' => 'ساعات متطلبات الكلية المنتهية',
        'program_elected_earned_credits' => 'ساعات متطلبات البرنامج المنتهية',
    ],

    'professors' => [
        'professor' => 'المعلم',
    ],

    'courses' => [
        'course' => 'المقرر',
        'name_en' => 'الاسم بالإنجليزية',
        'name_ar' => 'الاسم بالعربية',
        'code' => 'الكود',
        'level' => 'المستوى',
        'index' => 'عرض المقررات الدراسية',
        'create' => 'إضافة مقرر',
        'edit' => 'تعديل بيانات المقرر',
        'show' => 'عرض بيانات المقرر',
        'success' => [
            'create' => 'نجح إنشاء مقرر جديد',
            'update' => 'نجح تعديل المقرر',
            'send_requests' => 'نجح إرسال طلب المقررات',
        ],
        'schedule' => 'الجدول الدراسي',
        'add_schedule' => 'إضافة مقرر يوم :day الفترة :period',
        'schedule_course' => 'إضافة مقرر ":code - :course" إلى الجدول الدراسي',
        'empty' => 'لا توجد مقررات للعرض',
        'enrollment_success' => 'نجح تسجيل المادة',
        'enrollment_deleted' => 'نجح حذف المادة',
        'enrollments_number' => 'عدد الطلاب المسموح للتسجيل',
        'enrolled_already' => 'هذا المقرر مُسجل في موعد آخر',
        'no_seats_left' => 'لم يتبق أي مقعد',
        'already_enrolled' => 'هذا المقرر مسجل بالفعل',
        'student_enrolled' => ':count طالب سجّل المادة',
        'enrollment_end' => 'ينتهي التسجيل في',
        'period' => 'الفترة',
        'semester_courses' => 'مقررات الفصل',
        'midterm_exam' => 'امتحان منتصف الفصل',
        'final_exam' => 'امتحان نهاية الفصل',
        'total' => 'المجموع',
        'percentage' => 'النسبة المئوية',
        'grade' => 'التقدير',
        'work_mark' => 'درجة أعمال السنة',
        'not_revealed' => 'غير مٌعلن',
        'enrollments_count' => 'عدد الطلاب المسجلين هذا الفصل',
        'show_marks' => 'عرض كشف درجات مادة :course',
    ],

    'halls' => [
        'hall' => 'القاعة',
        'name' => 'اسم القاعة',
        'address' => 'المكان',
        'type' => 'نوع القاعة',
        'create' => 'إضافة قاعة جديدة',
        'edit' => 'تعديل بيانات القاعة',
        'index' => 'عرض قاعات الدراسة',
        'show' => 'عرض بيانات القاعة',
        'delete' => 'حذف القاعة',
        'types' => [
            'theatre' => 'مدرّج',
            'lab' => 'معمل',
        ],
        'status' => [
            'title' => 'الحالة',
            'available' => 'متاح',
            'under_maintenance' => 'قيد الصيانة',
            'reserved' => 'محفوظة',
        ],
        'success' => [
            'store' => 'أُضيفت قاعة جديدة بنجاح',
            'update' => 'حُدّثت بيانات القاعة بنجاح',
            'delete' => 'حُذفت القاعة بنجاح',
        ],
        'empty' => 'لا يوجد قاعات للعرض',
    ],

    'semester' => [
        'success' => [
            'start' => 'بُدء فصل دراسي جديد',
            'end' => 'أُنهي الفصل الدراسي الحالي',
        ],
    ]

];
