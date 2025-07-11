const readline = require('readline');

class StudentChatbot {
    constructor() {
        // Load the knowledge base
        this.knowledge_base = {
            "program_name": "الهندسة الكهربية والحاسبات",
            "program_code": "ECE-C",
            "university": "جامعة المنوفية",
            "faculty": "كلية الهندسة",
            "degree_awarded": "بكالوريوس في الهندسة",
            "study_system": "نظام الساعات المعتمدة",
            "total_required_credits": 180,
            "program_duration": "عشر فصول دراسية كحد أقصى",
            "admission_requirements": [
                "الحصول على شهادة الثانوية العامة - شعبة رياضيات",
                "أو ما يعادلها حسب تنسيق الجامعات"
            ],
            "total_credits": 180,
            "requirements": {
                "university": 25,
                "faculty": 45,
                "specialization": 110
            },
            "registration": {
                "eligibility": "شهادة الثانوية العامة شعبة الرياضيات أو ما يعادلها",
                "max_duration": "10 سنوات (10 فصول دراسية رئيسية)",
                "min_duration": "9 فصول دراسية رئيسية",
                "max_credits_per_semester": {
                    "GPA_above_3": 21,
                    "GPA_above_2": 18,
                    "GPA_below_2": 14
                },
                "summer_max_credits": 6
            },
            "graduation_requirements": {
                "minimum_gpa": 2.00,
                "honors_requirements": {
                    "minimum_gpa": 3.3,
                    "no_F_grades": true
                },
                "project_requirement": "تنفيذ مشروع تخرج خلال فصلين دراسيين",
                "internship": "تدريب ميداني لمدة لا تقل عن 8 أسابيع",
                "credit_hours": {
                    "university_requirements": 25,
                    "faculty_requirements": 45,
                    "specialization_requirements": 110
                }
            },
            "grading_scale": {
                "A+": "4.00 (97% فما فوق)",
                "A": "4.00 (93%-96%)",
                "A-": "3.70 (89%-92%)",
                "B+": "3.30 (84%-88%)",
                "B": "3.00 (80%-83%)",
                "B-": "2.70 (76%-79%)",
                "C+": "2.30 (73%-75%)",
                "C": "2.00 (70%-72%)",
                "D": "1.00 (60%-64%)",
                "F": "0.00 (أقل من 60%)"
            },
            "language_of_instruction": "اللغة الإنجليزية",
            "semesters": {
                "fall": "يبدأ في سبتمبر",
                "spring": "يبدأ في فبراير",
                "summer": "اختياري، يبدأ في يوليو"
            },
            "courses": {
                "university_requirements": [
                    {"code": "GEN-C001", "name": "English Language", "credits": 3},
                    {"code": "GEN-C002", "name": "Introduction to Computers", "credits": 3},
                    {"code": "GEN-C101", "name": "Human Rights", "credits": 2},
                    {"code": "GEN-C102", "name": "Project Management", "credits": 2},
                    {"code": "GEN-C201", "name": "Presentation Skills", "credits": 3},
                    {"code": "GEN-C202", "name": "Foundation of Economics", "credits": 3},
                    {"code": "GEN-C301", "name": "Writing Technical Report", "credits": 3}
                ],
                "electrical_engineering_core": [
                    {"code": "ELE-C101", "name": "Circuits (1)", "credits": 3},
                    {"code": "ECE-C101", "name": "Digital Logic", "credits": 3},
                    {"code": "ELE-C102", "name": "Circuits (2)", "credits": 3},
                    {"code": "ELE-C201", "name": "Electromagnetic Fields", "credits": 3},
                    {"code": "ELE-C301", "name": "Control Systems", "credits": 3},
                    {"code": "ELE-C401", "name": "Electrical Machines", "credits": 3},
                    {"code": "ELE-C501", "name": "Power Systems", "credits": 3}
                ]
            },
            "policies": {
                "attendance": "الحضور الإلزامي 75% على الأقل لدخول الامتحان",
                "academic_warning": "إنذار أكاديمي إذا كان المعدل التراكمي أقل من 2.0",
                "course_repeat": "يمكن إعادة المقرر لتحسين المعدل (بحد أقصى 5 مقررات)",
                "withdrawal": "الانسحاب مسموح خلال 8 أسابيع في الفصول الرئيسية/4 أسابيع في الصيفي"
            },
            "student_services": {
                "academic_advisor": "يتم تعيين مرشد أكاديمي لكل طالب عند الالتحاق",
                "industrial_training": {
                    "requirement": "8 أسابيع تدريب بعد إكمال 120 ساعة معتمدة",
                    "credits": 2
                },
                "graduation_project": {
                    "requirement": "مشروع التخرج (2 ساعة معتمدة)",
                    "duration": "يمكن تقسيمه على فصلين دراسيين"
                },
                "meeting_frequency": "يفضل مقابلة المرشد الأكاديمي قبل كل فترة تسجيل.",
                "advising_purpose": [
                    "تحديد المقررات المناسبة حسب التخصص",
                    "مراقبة الأداء الأكاديمي",
                    "مناقشة الخيارات المستقبلية (تدريب - مشروع - فرص عمل)"
                ]
            },
            "fees_structure": {
                "payment_policy": "الرسوم تحدد سنوياً بحد أقصى 5% زيادة للطلاب الجدد",
                "min_payment": "رسوم 12 ساعة معتمدة لكل فصل رئيسي"
            }
        };
        
        // Course descriptions
        this.course_descriptions = {
            "ECE-C101": {
                "title": "Digital Logic",
                "prerequisite": "GEN-C002",
                "topics": [
                    "Boolean algebra and logic gates (AND, OR, NAND, NOR)",
                    "Memory elements design",
                    "Sequential machines: synchronous & asynchronous",
                    "Digital circuit construction and troubleshooting"
                ]
            },
            "ECE-C102": {
                "title": "Computer Programming (1)",
                "prerequisite": "GEN-C002",
                "topics": [
                    "Problem solving, algorithms, flowcharting",
                    "Control structures, arrays, strings, matrices",
                    "Files, structured programming, software tools"
                ]
            },
            "ECE-C103": {
                "title": "Data Structure",
                "prerequisite": "ECE-C102",
                "topics": [
                    "Data types and memory allocation",
                    "File structures, sorting and searching",
                    "Algorithm analysis"
                ]
            },
            "ECE-C201": {
                "title": "Digital Electronics",
                "prerequisite": "ELE-C102",
                "topics": [
                    "Logic gates, Flip-flops, Memory, A/D & D/A Converters",
                    "Simplifying logic circuits, ALUs"
                ]
            },
            "ECE-C202": {
                "title": "Database (1)",
                "prerequisite": "ECE-C104",
                "topics": [
                    "Database models, data manipulation, SQL",
                    "Database design principles"
                ]
            },
            "ECE-C301": {
                "title": "Programmable Logic Controllers",
                "prerequisite": "ECE-C201",
                "topics": [
                    "PLCs architecture and programming, case studies"
                ]
            },
            "ECE-C302": {
                "title": "Operating Systems",
                "prerequisite": "ECE-C203",
                "topics": [
                    "OS types and functions, memory and process management"
                ]
            },
            "ECE-C401": {
                "title": "Digital Signal Processing",
                "prerequisite": "ECE-C303",
                "topics": [
                    "Digital filter design, spectral estimation, signal processors"
                ]
            },
            "ECE-C402": {
                "title": "Computer Network",
                "prerequisite": "ECE-C204",
                "topics": [
                    "Network design, protocols, routing, management"
                ]
            },
            "ECE-C405": {
                "title": "Artificial Intelligence",
                "prerequisite": "ECE-C307",
                "topics": [
                    "Prolog, search methods, image & language processing, expert systems"
                ]
            }
        };
        
        this.keywords = {
            "program": ["برنامج", "program", "تخصص", "specialization"],
            "credits": ["ساعات", "credits", "معتمدة", "credit hours"],
            "duration": ["مدة", "duration", "فترة", "period"],
            "requirements": ["متطلبات", "requirements", "شروط", "conditions"],
            "registration": ["تسجيل", "registration", "enrollment", "التحاق"],
            "gpa": ["معدل", "gpa", "grade point average", "المعدل التراكمي"],
            "semester": ["فصل", "semester", "term", "فصل دراسي"],
            "courses": ["مقررات", "courses", "subjects", "مواد"],
            "prerequisites": ["متطلبات سابقة", "prerequisites", "pre-requisites"],
            "course_code": ["كود المقرر", "course code", "رمز المقرر"],
            "grades": ["درجات", "grades", "marks", "علامات"],
            "grading": ["تقييم", "grading", "evaluation"],
            "attendance": ["حضور", "attendance", "presence"],
            "policies": ["سياسات", "policies", "rules", "قواعد"],
            "withdrawal": ["انسحاب", "withdrawal", "drop"],
            "advisor": ["مرشد", "advisor", "academic advisor", "مرشد أكاديمي"],
            "training": ["تدريب", "training", "internship"],
            "project": ["مشروع", "project", "graduation project", "مشروع التخرج"],
            "fees": ["رسوم", "fees", "tuition", "الرسوم الدراسية"],
            "payment": ["دفع", "payment", "pay"],
            "help": ["مساعدة", "help", "مساعدة", "support"],
            "menu": ["قائمة", "menu", "options", "خيارات"],
            "exit": ["خروج", "exit", "quit", "end", "إنهاء"]
        };
        
        this.current_language = "ar";
    }
    
    detectLanguage(text) {
        /** Detect if text is Arabic or English */
        const arabicChars = text.match(/[\u0600-\u06FF]/g) || [];
        return arabicChars.length > text.length * 0.3 ? "ar" : "en";
    }
    
    getResponse(userInput) {
        /** Main method to process user input and return response */
        if (!userInput.trim()) {
            return this.getHelpMessage();
        }
        
        this.current_language = this.detectLanguage(userInput);
        const userInputLower = userInput.toLowerCase();
        
        // Check for exit commands
        if (this.keywords.exit.some(keyword => userInputLower.includes(keyword))) {
            return this.getExitMessage();
        }
        
        // Check for help commands
        if (this.keywords.help.some(keyword => userInputLower.includes(keyword)) || 
            this.keywords.menu.some(keyword => userInputLower.includes(keyword))) {
            return this.getHelpMessage();
        }
        
        // Process different types of queries
        let response = this.processProgramInfo(userInputLower);
        if (response) return response;
        
        response = this.processRegistrationInfo(userInputLower);
        if (response) return response;
        
        response = this.processCourseInfo(userInputLower);
        if (response) return response;
        
        response = this.processGradingInfo(userInputLower);
        if (response) return response;
        
        response = this.processPoliciesInfo(userInputLower);
        if (response) return response;
        
        response = this.processServicesInfo(userInputLower);
        if (response) return response;
        
        response = this.processFeesInfo(userInputLower);
        if (response) return response;
        
        return this.getDefaultResponse();
    }
    
    processProgramInfo(userInput) {
        /** Process queries about program information */
        if (this.keywords.program.some(keyword => userInput.includes(keyword))) {
            return this.getProgramInfo();
        }
        
        if (this.keywords.credits.some(keyword => userInput.includes(keyword))) {
            return this.getCreditsInfo();
        }
        
        if (this.keywords.duration.some(keyword => userInput.includes(keyword))) {
            return this.getDurationInfo();
        }
        
        if (this.keywords.requirements.some(keyword => userInput.includes(keyword))) {
            return this.getAdmissionRequirements();
        }
        
        return null;
    }
    
    processRegistrationInfo(userInput) {
        /** Process queries about registration */
        if (this.keywords.registration.some(keyword => userInput.includes(keyword))) {
            return this.getRegistrationInfo();
        }
        
        if (this.keywords.gpa.some(keyword => userInput.includes(keyword))) {
            return this.getGpaInfo();
        }
        
        if (this.keywords.semester.some(keyword => userInput.includes(keyword))) {
            return this.getSemesterInfo();
        }
        
        return null;
    }
    
    processCourseInfo(userInput) {
        /** Process queries about courses */
        if (this.keywords.courses.some(keyword => userInput.includes(keyword))) {
            return this.getCoursesOverview();
        }
        
        // Check for course codes
        const courseCodes = userInput.toUpperCase().match(/[A-Z]{3}-C\d{3}/g);
        if (courseCodes) {
            return this.getCourseDetails(courseCodes[0]);
        }
        
        if (this.keywords.prerequisites.some(keyword => userInput.includes(keyword))) {
            return this.getPrerequisitesInfo();
        }
        
        return null;
    }
    
    processGradingInfo(userInput) {
        /** Process queries about grading */
        if (this.keywords.grades.some(keyword => userInput.includes(keyword)) || 
            this.keywords.grading.some(keyword => userInput.includes(keyword))) {
            return this.getGradingInfo();
        }
        
        return null;
    }
    
    processPoliciesInfo(userInput) {
        /** Process queries about policies */
        if (this.keywords.attendance.some(keyword => userInput.includes(keyword))) {
            return this.getAttendancePolicy();
        }
        
        if (this.keywords.policies.some(keyword => userInput.includes(keyword))) {
            return this.getPoliciesOverview();
        }
        
        if (this.keywords.withdrawal.some(keyword => userInput.includes(keyword))) {
            return this.getWithdrawalPolicy();
        }
        
        return null;
    }
    
    processServicesInfo(userInput) {
        /** Process queries about student services */
        if (this.keywords.advisor.some(keyword => userInput.includes(keyword))) {
            return this.getAdvisorInfo();
        }
        
        if (this.keywords.training.some(keyword => userInput.includes(keyword))) {
            return this.getTrainingInfo();
        }
        
        if (this.keywords.project.some(keyword => userInput.includes(keyword))) {
            return this.getProjectInfo();
        }
        
        return null;
    }
    
    processFeesInfo(userInput) {
        /** Process queries about fees */
        if (this.keywords.fees.some(keyword => userInput.includes(keyword)) || 
            this.keywords.payment.some(keyword => userInput.includes(keyword))) {
            return this.getFeesInfo();
        }
        
        return null;
    }
    
    getProgramInfo() {
        /** Get program information */
        if (this.current_language === "ar") {
            return `
🎓 معلومات البرنامج:
• اسم البرنامج: ${this.knowledge_base.program_name}
• رمز البرنامج: ${this.knowledge_base.program_code}
• الجامعة: ${this.knowledge_base.university}
• الكلية: ${this.knowledge_base.faculty}
• الدرجة الممنوحة: ${this.knowledge_base.degree_awarded}
• نظام الدراسة: ${this.knowledge_base.study_system}
• لغة التدريس: ${this.knowledge_base.language_of_instruction}
`;
        } else {
            return `
🎓 Program Information:
• Program Name: ${this.knowledge_base.program_name}
• Program Code: ${this.knowledge_base.program_code}
• University: ${this.knowledge_base.university}
• Faculty: ${this.knowledge_base.faculty}
• Degree Awarded: ${this.knowledge_base.degree_awarded}
• Study System: ${this.knowledge_base.study_system}
• Language of Instruction: ${this.knowledge_base.language_of_instruction}
`;
        }
    }
    
    getCreditsInfo() {
        /** Get credits information */
        if (this.current_language === "ar") {
            return `
معلومات الساعات المعتمدة:
• إجمالي الساعات المطلوبة: ${this.knowledge_base.total_required_credits} ساعة معتمدة
• متطلبات الجامعة: ${this.knowledge_base.requirements.university} ساعة معتمدة
• متطلبات الكلية: ${this.knowledge_base.requirements.faculty} ساعة معتمدة
• متطلبات التخصص: ${this.knowledge_base.requirements.specialization} ساعة معتمدة
`;
        } else {
            return `
Credit Hours Information:
• Total Required Credits: ${this.knowledge_base.total_required_credits} credit hours
• University Requirements: ${this.knowledge_base.requirements.university} credit hours
• Faculty Requirements: ${this.knowledge_base.requirements.faculty} credit hours
• Specialization Requirements: ${this.knowledge_base.requirements.specialization} credit hours
`;
        }
    }
    
    getDurationInfo() {
        /** Get program duration information */
        if (this.current_language === "ar") {
            return `
مدة البرنامج:
• المدة القصوى: ${this.knowledge_base.program_duration}
• الحد الأدنى: ${this.knowledge_base.registration.min_duration}
• الحد الأقصى: ${this.knowledge_base.registration.max_duration}
`;
        } else {
            return `
Program Duration:
• Maximum Duration: ${this.knowledge_base.program_duration}
• Minimum Duration: ${this.knowledge_base.registration.min_duration}
• Maximum Duration: ${this.knowledge_base.registration.max_duration}
`;
        }
    }
    
    getAdmissionRequirements() {
        /** Get admission requirements */
        if (this.current_language === "ar") {
            const requirementsText = this.knowledge_base.admission_requirements.map(req => `• ${req}`).join('\n');
            return `
متطلبات القبول:
${requirementsText}
`;
        } else {
            const requirementsText = this.knowledge_base.admission_requirements.map(req => `• ${req}`).join('\n');
            return `
Admission Requirements:
${requirementsText}
`;
        }
    }
    
    getRegistrationInfo() {
        /** Get registration information */
        if (this.current_language === "ar") {
            return `
معلومات التسجيل:
• الأهلية: ${this.knowledge_base.registration.eligibility}
• الحد الأقصى للساعات في الفصل الدراسي:
  - معدل تراكمي أعلى من 3: ${this.knowledge_base.registration.max_credits_per_semester.GPA_above_3} ساعة
  - معدل تراكمي أعلى من 2: ${this.knowledge_base.registration.max_credits_per_semester.GPA_above_2} ساعة
  - معدل تراكمي أقل من 2: ${this.knowledge_base.registration.max_credits_per_semester.GPA_below_2} ساعة
• الحد الأقصى للفصل الصيفي: ${this.knowledge_base.registration.summer_max_credits} ساعة معتمدة
`;
        } else {
            return `
Registration Information:
• Eligibility: ${this.knowledge_base.registration.eligibility}
• Maximum Credits per Semester:
  - GPA above 3: ${this.knowledge_base.registration.max_credits_per_semester.GPA_above_3} credits
  - GPA above 2: ${this.knowledge_base.registration.max_credits_per_semester.GPA_above_2} credits
  - GPA below 2: ${this.knowledge_base.registration.max_credits_per_semester.GPA_below_2} credits
• Summer Maximum: ${this.knowledge_base.registration.summer_max_credits} credits
`;
        }
    }
    
    getGpaInfo() {
        /** Get GPA information */
        if (this.current_language === "ar") {
            return `
معلومات المعدل التراكمي:
• الحد الأدنى للتخرج: ${this.knowledge_base.graduation_requirements.minimum_gpa}
• متطلبات التكريم: ${this.knowledge_base.graduation_requirements.honors_requirements.minimum_gpa}
• إنذار أكاديمي: ${this.knowledge_base.policies.academic_warning}
`;
        } else {
            return `
GPA Information:
• Minimum for Graduation: ${this.knowledge_base.graduation_requirements.minimum_gpa}
• Honors Requirements: ${this.knowledge_base.graduation_requirements.honors_requirements.minimum_gpa}
• Academic Warning: ${this.knowledge_base.policies.academic_warning}
`;
        }
    }
    
    getSemesterInfo() {
        /** Get semester information */
        if (this.current_language === "ar") {
            return `
معلومات الفصول الدراسية:
• الفصل الخريفي: ${this.knowledge_base.semesters.fall}
• الفصل الربيعي: ${this.knowledge_base.semesters.spring}
• الفصل الصيفي: ${this.knowledge_base.semesters.summer}
`;
        } else {
            return `
Semester Information:
• Fall Semester: ${this.knowledge_base.semesters.fall}
• Spring Semester: ${this.knowledge_base.semesters.spring}
• Summer Semester: ${this.knowledge_base.semesters.summer}
`;
        }
    }
    
    getCoursesOverview() {
        /** Get courses overview */
        if (this.current_language === "ar") {
            const uniCourses = this.knowledge_base.courses.university_requirements
                .map(course => `• ${course.code}: ${course.name} (${course.credits} ساعة)`)
                .join('\n');
            const elecCourses = this.knowledge_base.courses.electrical_engineering_core
                .map(course => `• ${course.code}: ${course.name} (${course.credits} ساعة)`)
                .join('\n');
            return `
نظرة عامة على المقررات:

متطلبات الجامعة:
${uniCourses}

المقررات الأساسية للهندسة الكهربية:
${elecCourses}

للمزيد من التفاصيل عن مقرر معين، اكتب كود المقرر (مثل: ECE-C101)
`;
        } else {
            const uniCourses = this.knowledge_base.courses.university_requirements
                .map(course => `• ${course.code}: ${course.name} (${course.credits} credits)`)
                .join('\n');
            const elecCourses = this.knowledge_base.courses.electrical_engineering_core
                .map(course => `• ${course.code}: ${course.name} (${course.credits} credits)`)
                .join('\n');
            return `
Courses Overview:

University Requirements:
${uniCourses}

Electrical Engineering Core Courses:
${elecCourses}

For more details about a specific course, type the course code (e.g., ECE-C101)
`;
        }
    }
    
    getCourseDetails(courseCode) {
        /** Get specific course details */
        if (this.course_descriptions[courseCode]) {
            const course = this.course_descriptions[courseCode];
            if (this.current_language === "ar") {
                const topics = course.topics.map(topic => `• ${topic}`).join('\n');
                return `
تفاصيل المقرر ${courseCode}:
• العنوان: ${course.title}
• المتطلبات السابقة: ${course.prerequisite}
• الموضوعات:
${topics}
`;
            } else {
                const topics = course.topics.map(topic => `• ${topic}`).join('\n');
                return `
Course Details for ${courseCode}:
• Title: ${course.title}
• Prerequisite: ${course.prerequisite}
• Topics:
${topics}
`;
            }
        } else {
            if (this.current_language === "ar") {
                return `عذراً، لا توجد معلومات متاحة للمقرر ${courseCode}`;
            } else {
                return `Sorry, no information available for course ${courseCode}`;
            }
        }
    }
    
    getPrerequisitesInfo() {
        /** Get prerequisites information */
        if (this.current_language === "ar") {
            return `
معلومات المتطلبات السابقة:
• يجب إكمال المتطلبات السابقة قبل التسجيل في المقرر
• يمكن التحقق من المتطلبات السابقة لكل مقرر
• اكتب كود المقرر لمعرفة متطلباته السابقة
`;
        } else {
            return `
Prerequisites Information:
• Prerequisites must be completed before registering for a course
• Prerequisites can be checked for each course
• Type the course code to see its prerequisites
`;
        }
    }
    
    getGradingInfo() {
        /** Get grading information */
        if (this.current_language === "ar") {
            const gradesText = Object.entries(this.knowledge_base.grading_scale)
                .map(([grade, gpa]) => `• ${grade}: ${gpa}`)
                .join('\n');
            return `
نظام التقييم:
${gradesText}
`;
        } else {
            const gradesText = Object.entries(this.knowledge_base.grading_scale)
                .map(([grade, gpa]) => `• ${grade}: ${gpa}`)
                .join('\n');
            return `
Grading Scale:
${gradesText}
`;
        }
    }
    
    getAttendancePolicy() {
        /** Get attendance policy */
        if (this.current_language === "ar") {
            return `
سياسة الحضور:
${this.knowledge_base.policies.attendance}
`;
        } else {
            return `
Attendance Policy:
${this.knowledge_base.policies.attendance}
`;
        }
    }
    
    getPoliciesOverview() {
        /** Get policies overview */
        if (this.current_language === "ar") {
            return `
السياسات الأكاديمية:
• الحضور: ${this.knowledge_base.policies.attendance}
• الإنذار الأكاديمي: ${this.knowledge_base.policies.academic_warning}
• إعادة المقرر: ${this.knowledge_base.policies.course_repeat}
• الانسحاب: ${this.knowledge_base.policies.withdrawal}
`;
        } else {
            return `
Academic Policies:
• Attendance: ${this.knowledge_base.policies.attendance}
• Academic Warning: ${this.knowledge_base.policies.academic_warning}
• Course Repeat: ${this.knowledge_base.policies.course_repeat}
• Withdrawal: ${this.knowledge_base.policies.withdrawal}
`;
        }
    }
    
    getWithdrawalPolicy() {
        /** Get withdrawal policy */
        if (this.current_language === "ar") {
            return `
سياسة الانسحاب:
${this.knowledge_base.policies.withdrawal}
`;
        } else {
            return `
Withdrawal Policy:
${this.knowledge_base.policies.withdrawal}
`;
        }
    }
    
    getAdvisorInfo() {
        /** Get academic advisor information */
        if (this.current_language === "ar") {
            const purposes = this.knowledge_base.student_services.advising_purpose
                .map(purpose => `• ${purpose}`)
                .join('\n');
            return `
معلومات المرشد الأكاديمي:
• ${this.knowledge_base.student_services.academic_advisor}
• ${this.knowledge_base.student_services.meeting_frequency}
• أغراض الإرشاد:
${purposes}
`;
        } else {
            const purposes = this.knowledge_base.student_services.advising_purpose
                .map(purpose => `• ${purpose}`)
                .join('\n');
            return `
Academic Advisor Information:
• ${this.knowledge_base.student_services.academic_advisor}
• ${this.knowledge_base.student_services.meeting_frequency}
• Advising Purposes:
${purposes}
`;
        }
    }
    
    getTrainingInfo() {
        /** Get training information */
        if (this.current_language === "ar") {
            return `
معلومات التدريب الميداني:
• المتطلب: ${this.knowledge_base.student_services.industrial_training.requirement}
• الساعات المعتمدة: ${this.knowledge_base.student_services.industrial_training.credits} ساعة معتمدة
`;
        } else {
            return `
Industrial Training Information:
• Requirement: ${this.knowledge_base.student_services.industrial_training.requirement}
• Credits: ${this.knowledge_base.student_services.industrial_training.credits} credit hours
`;
        }
    }
    
    getProjectInfo() {
        /** Get graduation project information */
        if (this.current_language === "ar") {
            return `
معلومات مشروع التخرج:
• المتطلب: ${this.knowledge_base.student_services.graduation_project.requirement}
• المدة: ${this.knowledge_base.student_services.graduation_project.duration}
`;
        } else {
            return `
Graduation Project Information:
• Requirement: ${this.knowledge_base.student_services.graduation_project.requirement}
• Duration: ${this.knowledge_base.student_services.graduation_project.duration}
`;
        }
    }
    
    getFeesInfo() {
        /** Get fees information */
        if (this.current_language === "ar") {
            return `
معلومات الرسوم:
• سياسة الدفع: ${this.knowledge_base.fees_structure.payment_policy}
• الحد الأدنى للدفع: ${this.knowledge_base.fees_structure.min_payment}
`;
        } else {
            return `
Fees Information:
• Payment Policy: ${this.knowledge_base.fees_structure.payment_policy}
• Minimum Payment: ${this.knowledge_base.fees_structure.min_payment}
`;
        }
    }
    
    getHelpMessage() {
        /** Get help message with available keywords */
        if (this.current_language === "ar") {
            return `
مرحباً بك في المساعد الآلي لبرنامج الهندسة الكهربية والحاسبات!

الكلمات المفتاحية المتاحة:
• برنامج / program - معلومات البرنامج
• ساعات / credits - الساعات المعتمدة
• مدة / duration - مدة البرنامج
• متطلبات / requirements - متطلبات القبول
• تسجيل / registration - معلومات التسجيل
• معدل / gpa - معلومات المعدل التراكمي
• فصل / semester - معلومات الفصول الدراسية
• مقررات / courses - نظرة عامة على المقررات
• متطلبات سابقة / prerequisites - المتطلبات السابقة
• درجات / grades - نظام التقييم
• حضور / attendance - سياسة الحضور
• سياسات / policies - السياسات الأكاديمية
• انسحاب / withdrawal - سياسة الانسحاب
• مرشد / advisor - معلومات المرشد الأكاديمي
• تدريب / training - التدريب الميداني
• مشروع / project - مشروع التخرج
• رسوم / fees - معلومات الرسوم
• مساعدة / help - هذه القائمة
• خروج / exit - إنهاء المحادثة

يمكنك أيضاً كتابة كود مقرر معين (مثل: ECE-C101) للحصول على تفاصيله
`;
        } else {
            return `
Welcome to the Electrical and Computer Engineering Program Assistant!

Available Keywords:
• program - Program information
• credits - Credit hours information
• duration - Program duration
• requirements - Admission requirements
• registration - Registration information
• gpa - GPA information
• semester - Semester information
• courses - Courses overview
• prerequisites - Prerequisites information
• grades - Grading system
• attendance - Attendance policy
• policies - Academic policies
• withdrawal - Withdrawal policy
• advisor - Academic advisor information
• training - Industrial training
• project - Graduation project
• fees - Fees information
• help - This menu
• exit - End conversation

💡 You can also type a specific course code (e.g., ECE-C101) for course details
`;
        }
    }
    
    getDefaultResponse() {
        /** Get default response when no specific match is found */
        if (this.current_language === "ar") {
            return `
لم أفهم سؤالك. يمكنك استخدام الكلمات المفتاحية التالية:
• برنامج، ساعات، مدة، متطلبات، تسجيل، معدل، فصل، مقررات، درجات، حضور، سياسات، مرشد، تدريب، مشروع، رسوم

أو اكتب "مساعدة" للحصول على قائمة كاملة بالكلمات المفتاحية.
`;
        } else {
            return `
I didn't understand your question. You can use these keywords:
• program, credits, duration, requirements, registration, gpa, semester, courses, grades, attendance, policies, advisor, training, project, fees

Or type "help" for a complete list of keywords.
`;
        }
    }
    
    getExitMessage() {
        /** Get exit message */
        if (this.current_language === "ar") {
            return `
شكراً لك لاستخدام المساعد الآلي لبرنامج الهندسة الكهربية والحاسبات!
نتمنى لك التوفيق في دراستك! 🎓
`;
        } else {
            return `
Thank you for using the Electrical and Computer Engineering Program Assistant!
Good luck with your studies! 🎓
`;
        }
    }
}

async function main() {
    /** Main function to run the chatbot */
    const chatbot = new StudentChatbot();
    
    console.log("=".repeat(60));
    console.log(" مساعد برنامج الهندسة الكهربية والحاسبات");
    console.log(" Electrical and Computer Engineering Program Assistant");
    console.log("=".repeat(60));
    console.log(chatbot.getHelpMessage());
    console.log("=".repeat(60));
    
    const rl = readline.createInterface({
        input: process.stdin,
        output: process.stdout
    });
    
    const askQuestion = () => {
        rl.question("\n أنت / You: ", (userInput) => {
            const input = userInput.trim();
            
            if (!input) {
                askQuestion();
                return;
            }
            
            const response = chatbot.getResponse(input);
            console.log(`\n المساعد / Assistant: ${response}`);
            
            // Check if user wants to exit
            if (chatbot.keywords.exit.some(keyword => input.toLowerCase().includes(keyword))) {
                rl.close();
                return;
            }
            
            askQuestion();
        });
    };
    
    try {
        askQuestion();
    } catch (error) {
        console.log(`\n حدث خطأ / An error occurred: ${error.message}`);
        console.log("يرجى المحاولة مرة أخرى / Please try again.");
        rl.close();
    }
    
    rl.on('close', () => {
        console.log("\n" + chatbot.getExitMessage());
        process.exit(0);
    });
}

// Handle Ctrl+C gracefully
process.on('SIGINT', () => {
    console.log('\n\nThank you for using the chatbot!');
    process.exit(0);
});

if (require.main === module) {
    main().catch(console.error);
}

module.exports = StudentChatbot; 