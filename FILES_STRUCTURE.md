# File Tree: CodeZone

```
├── 📁 app/
│   ├── 📁 Http/
│   │   ├── 📁 Controllers/
│   │   │   ├── 📁 Admin/
│   │   │   │   ├── 🐘 CategoryController.php
│   │   │   │   └── 🐘 CourseController.php
│   │   │   ├── 📁 Auth/
│   │   │   │   ├── 📁 Socialite/
│   │   │   │   │   └── 🐘 SocialiteController.php
│   │   │   │   └── 📁 Traditional/
│   │   │   │       └── 🐘 AuthenticationController.php
│   │   │   ├── 📁 Client/
│   │   │   │   ├── 📁 Instructor/
│   │   │   │   │   └── 🐘 CourseController.php
│   │   │   │   ├── 📁 Student/
│   │   │   │   │   └── 🐘 ReviewController.php
│   │   │   │   └── 🐘 PageController.php
│   │   │   ├── 📁 Transaction/
│   │   │   │   └── 🐘 PaymentController.php
│   │   │   └── 🐘 Controller.php
│   │   ├── 📁 Middleware/
│   │   │   ├── 🐘 EnsureUserIsInstructor.php
│   │   │   ├── 🐘 EnsureUserIsOrganization.php
│   │   │   └── 🐘 EnsureUserIsStudent.php
│   │   └── 📁 Requests/
│   │       └── 🐘 StudentRequest.php
│   ├── 📁 Imports/
│   │   ├── 🐘 MemberImport.php
│   │   └── 🐘 QuizzesImport.php
│   ├── 📁 Livewire/
│   │   └── 📁 Client/
│   │       ├── 📁 CourseCreation/
│   │       │   ├── 📁 Components/
│   │       │   │   └── 📁 Builders/
│   │       │   │       ├── 📁 AssessmentTypes/
│   │       │   │       │   ├── 🐘 Assignment.php
│   │       │   │       │   ├── 🐘 Programming.php
│   │       │   │       │   └── 🐘 Quiz.php
│   │       │   │       ├── 📁 LessonTypes/
│   │       │   │       │   ├── 🐘 Document.php
│   │       │   │       │   └── 🐘 Video.php
│   │       │   │       └── 🐘 Course.php
│   │       │   └── 🐘 Index.php
│   │       ├── 📁 Instructor/
│   │       │   └── 📁 Dashboard/
│   │       │       ├── 🐘 Courses.php
│   │       │       ├── 🐘 Overview.php
│   │       │       ├── 🐘 Profile.php
│   │       │       ├── 🐘 Reviews.php
│   │       │       └── 🐘 Settings.php
│   │       ├── 📁 Lesson/
│   │       │   ├── 📁 Components/
│   │       │   │   ├── 📁 AssessmentTypes/
│   │       │   │   │   ├── 🐘 Assignment.php
│   │       │   │   │   ├── 🐘 ProgrammingPractice.php
│   │       │   │   │   └── 🐘 Quiz.php
│   │       │   │   ├── 📁 LessonTypes/
│   │       │   │   │   ├── 🐘 Assessment.php
│   │       │   │   │   ├── 🐘 Document.php
│   │       │   │   │   └── 🐘 Video.php
│   │       │   │   └── 🐘 Sidebar.php
│   │       │   └── 🐘 Index.php
│   │       ├── 📁 Organization/
│   │       │   ├── 📁 Components/
│   │       │   │   └── 🐘 AddLearnersBuilder.php
│   │       │   └── 📁 Dashboard/
│   │       │       ├── 🐘 Courses.php
│   │       │       ├── 🐘 Members.php
│   │       │       ├── 🐘 OverView.php
│   │       │       └── 🐘 Settings.php
│   │       ├── 📁 Shared/
│   │       │   └── 🐘 SettingsBase.php
│   │       └── 📁 Student/
│   │           └── 📁 Dashboard/
│   │               ├── 🐘 Courses.php
│   │               ├── 🐘 Overview.php
│   │               ├── 🐘 Purchases.php
│   │               ├── 🐘 Reviews.php
│   │               └── 🐘 Settings.php
│   ├── 📁 Models/
│   │   ├── 🐘 Assessment.php
│   │   ├── 🐘 AssessmentAttempt.php
│   │   ├── 🐘 AssessmentQuestion.php
│   │   ├── 🐘 AssessmentQuestionOptions.php
│   │   ├── 🐘 AttemptProgramming.php
│   │   ├── 🐘 AttemptQuiz.php
│   │   ├── 🐘 Batch.php
│   │   ├── 🐘 BatchEnrollments.php
│   │   ├── 🐘 Blog.php
│   │   ├── 🐘 Category.php
│   │   ├── 🐘 Certifications.php
│   │   ├── 🐘 Comment.php
│   │   ├── 🐘 Course.php
│   │   ├── 🐘 Enrollment.php
│   │   ├── 🐘 InstructorProfile.php
│   │   ├── 🐘 Lesson.php
│   │   ├── 🐘 Module.php
│   │   ├── 🐘 Order.php
│   │   ├── 🐘 OrganizationProfile.php
│   │   ├── 🐘 OrganizationUser.php
│   │   ├── 🐘 ProgrammingAssignmentDetails.php
│   │   ├── 🐘 Reaction.php
│   │   ├── 🐘 Review.php
│   │   ├── 🐘 StudentProfile.php
│   │   ├── 🐘 TrackingProgress.php
│   │   └── 🐘 User.php
│   ├── 📁 Providers/
│   │   └── 🐘 AppServiceProvider.php
│   ├── 📁 Services/
│   │   ├── 📁 Business/
│   │   │   └── 🐘 MemberImportService.php
│   │   ├── 📁 CourseCreation/
│   │   │   └── 📁 Builders/
│   │   │       └── 📁 AssessmentTypes/
│   │   │           └── 🐘 QuizImportService.php
│   │   ├── 📁 Instructor/
│   │   ├── 📁 Payment/
│   │   │   ├── 📁 Context/
│   │   │   │   └── 🐘 PaymentContext.php
│   │   │   ├── 📁 Contracts/
│   │   │   │   └── 🐘 PaymentGateWayInterface.php
│   │   │   └── 📁 Strategies/
│   │   │       └── 🐘 VNPayStrategies.php
│   │   ├── 📁 SocialLogin/
│   │   │   ├── 📁 Context/
│   │   │   │   └── 🐘 SocialLoginContext.php
│   │   │   ├── 📁 Contracts/
│   │   │   │   └── 🐘 SocialLoginStrategyInterface.php
│   │   │   └── 📁 Strategies/
│   │   │       ├── 🐘 FacebookLoginStrategy.php
│   │   │       ├── 🐘 GoogleLoginStrategy.php
│   │   │       └── 🐘 SocialLoginService.php
│   │   ├── 📁 Student/
│   │   └── 📁 TraditionalLogin/
│   │       └── 🐘 AuthenticationService.php
│   ├── 📁 Traits/
│   │   ├── 🐘 HasDuration.php
│   │   ├── 🐘 HasSlug.php
│   │   └── 🐘 HasUUID.php
│   └── 📁 View/
│       └── 📁 Components/
│           └── 📁 Client/
│               ├── 📁 Dashboard/
│               │   ├── 📁 CourseCreation/
│               │   │   └── 🐘 ThumbnailUpload.php
│               │   ├── 📁 Inputs/
│               │   │   ├── 🐘 Select.php
│               │   │   ├── 🐘 Text.php
│               │   │   └── 🐘 TextArea.php
│               │   └── 🐘 BannerTop.php
│               └── 📁 Header/
│                   └── 🐘 Index.php
├── 📁 bootstrap/
│   ├── 🐘 app.php
│   └── 🐘 providers.php
├── 📁 config/
│   ├── 🐘 app.php
│   ├── 🐘 auth.php
│   ├── 🐘 cache.php
│   ├── 🐘 database.php
│   ├── 🐘 filesystems.php
│   ├── 🐘 livewire.php
│   ├── 🐘 logging.php
│   ├── 🐘 mail.php
│   ├── 🐘 menus.php
│   ├── 🐘 queue.php
│   ├── 🐘 services.php
│   └── 🐘 session.php
├── 📁 database/
│   ├── 📁 factories/
│   │   ├── 🐘 CategoryFactory.php
│   │   ├── 🐘 CourseFactory.php
│   │   ├── 🐘 ModuleFactory.php
│   │   └── 🐘 UserFactory.php
│   ├── 📁 migrations/
│   │   ├── 🐘 0001_01_01_000000_create_users_table.php
│   │   ├── 🐘 0001_01_01_000001_create_cache_table.php
│   │   ├── 🐘 0001_01_01_000002_create_jobs_table.php
│   │   ├── 🐘 2025_06_06_062420_create_instructor_profiles_table.php
│   │   ├── 🐘 2025_06_06_065000_create_categories_table.php
│   │   ├── 🐘 2025_06_06_081553_create_courses_table.php
│   │   ├── 🐘 2025_06_06_081554_create_modules_table.php
│   │   ├── 🐘 2025_06_06_081938_create_lessons_table.php
│   │   ├── 🐘 2025_06_06_085239_create_assessments_table.php
│   │   ├── 🐘 2025_06_06_085705_create_assessment_questions_table.php
│   │   ├── 🐘 2025_06_06_090503_create_assessment_question_options_table.php
│   │   ├── 🐘 2025_06_06_154804_create_assessment_attempts_table.php
│   │   ├── 🐘 2025_06_06_155201_create_attempt_assignments_table.php
│   │   ├── 🐘 2025_06_06_160037_create_attempt_quizzes_table.php
│   │   ├── 🐘 2025_06_06_160301_create_tracking_progress_table.php
│   │   ├── 🐘 2025_06_06_162113_create_reactions_table.php
│   │   ├── 🐘 2025_06_06_163333_create_comments_table.php
│   │   ├── 🐘 2025_06_06_164228_create_reviews_table.php
│   │   ├── 🐘 2025_06_06_164404_create_blogs_table.php
│   │   ├── 🐘 2025_06_06_164919_create_orders_table.php
│   │   ├── 🐘 2025_06_06_164948_create_order_items_table.php
│   │   ├── 🐘 2025_07_10_024657_create_organization_profiles_table.php
│   │   ├── 🐘 2025_07_10_024725_create_organization_users_table.php
│   │   ├── 🐘 2025_07_10_024746_create_batches_table.php
│   │   ├── 🐘 2025_07_10_024808_create_batch_enrollments_table.php
│   │   ├── 🐘 2025_07_10_024825_create_certifications_table.php
│   │   ├── 🐘 2025_07_20_031104_create_programming_assigment_details_table.php
│   │   ├── 🐘 2025_07_20_031303_create_attempt_programmings_table.php
│   │   └── 🐘 2025_08_11_084501_create_student_profiles_table.php
│   ├── 📁 seeders/
│   │   ├── 🐘 CategorySeeder.php
│   │   └── 🐘 DatabaseSeeder.php
│   └── 🗄️ codezone.sql
├── 📁 node_modules/ 🚫 (auto-hidden)
├── 📁 public/
│   ├── 📁 excel_file/
│   │   ├── 📊 SampleImportMember.xlsx
│   │   └── 📊 SampleImportQuiz.xlsx
│   ├── 📁 images/
│   ├── 📁 js/ 
│   ├── 📄 .htaccess
│   ├── 🖼️ favicon.ico
│   ├── 📄 hot 🚫 (auto-hidden)
│   ├── 🐘 index.php
│   ├── 📄 robots.txt
│   └── 📄 storage 🚫 (auto-hidden)
├── 📁 resources/
│   ├── 📁 assets/
│   │   ├── 📁 css/
│   │   │   ├── 📁 plugins/
│   │   │   │   ├── 🎨 animation.css
│   │   │   │   ├── 🎨 bootstrap-select.min.css 🚫 (auto-hidden)
│   │   │   │   ├── 🎨 feather.css
│   │   │   │   ├── 🎨 fontawesome.min.css 🚫 (auto-hidden)
│   │   │   │   ├── 🎨 fonts.css
│   │   │   │   ├── 🎨 jodit.min.css 🚫 (auto-hidden)
│   │   │   │   ├── 🎨 jquery-ui.css
│   │   │   │   ├── 🎨 magnigy-popup.min.css 🚫 (auto-hidden)
│   │   │   │   ├── 🎨 odometer.css
│   │   │   │   ├── 🎨 plyr.css
│   │   │   │   ├── 🎨 sal.css
│   │   │   │   └── 🎨 swiper.css
│   │   │   ├── 📁 vendor/ 🚫 (auto-hidden)
│   │   │   └── 🎨 styles.css
│   │   ├── 📁 fonts/
│   │   ├── 📁 js/
│   │   │   └── 📄 main.js
│   ├── 📁 css/
│   │   └── 🎨 app.css
│   ├── 📁 js/
│   │   ├── 📄 app.js
│   │   └── 📄 bootstrap.js
│   ├── 📁 views/
│   │   ├── 📁 admin/
│   │   ├── 📁 client/
│   │   │   ├── 📁 auth/
│   │   │   │   ├── 🐘 login.blade.php
│   │   │   │   └── 🐘 register.blade.php
│   │   │   ├── 📁 errors/
│   │   │   │   ├── 🐘 403.blade.php
│   │   │   │   ├── 🐘 404.blade.php
│   │   │   │   └── 🐘 maintenance.blade.php
│   │   │   └── 📁 pages/
│   │   │       ├── 🐘 course-details.blade.php
│   │   │       └── 🐘 homepage.blade.php
│   │   ├── 📁 components/
│   │   │   ├── 📁 client/
│   │   │   │   ├── 📁 dashboard/
│   │   │   │   │   ├── 📁 course-creation/
│   │   │   │   │   │   └── 🐘 thumbnail-upload.blade.php
│   │   │   │   │   ├── 📁 inputs/
│   │   │   │   │   │   ├── 🐘 select.blade.php
│   │   │   │   │   │   ├── 🐘 text-area.blade.php
│   │   │   │   │   │   └── 🐘 text.blade.php
│   │   │   │   │   ├── 🐘 banner-top.blade.php
│   │   │   │   │   └── 🐘 sidebar.blade.php
│   │   │   │   ├── 📁 header/
│   │   │   │   │   ├── 🐘 index.blade.php
│   │   │   │   │   └── 🐘 menu.blade.php
│   │   │   │   ├── 🐘 banner-area.blade.php
│   │   │   │   ├── 🐘 blogs-area.blade.php
│   │   │   │   ├── 🐘 cart-side-menu.blade.php
│   │   │   │   ├── 🐘 categories-area.blade.php
│   │   │   │   ├── 🐘 courses-area.blade.php
│   │   │   │   ├── 🐘 footer.blade.php
│   │   │   │   └── 🐘 popup-mobile-menu.blade.php
│   │   │   └── 📁 layouts/
│   │   │       ├── 🐘 app.blade.php
│   │   │       └── 🐘 dashboard.blade.php
│   │   ├── 📁 layouts/
│   │   │   ├── 🐘 admin.blade.php
│   │   │   └── 🐘 client.blade.php
│   │   └── 📁 livewire/
│   │       └── 📁 client/
│   │           ├── 📁 course-creation/
│   │           │   ├── 📁 components/
│   │           │   │   └── 📁 builders/
│   │           │   │       ├── 📁 assessment-types/
│   │           │   │       │   ├── 🐘 assignment.blade.php
│   │           │   │       │   ├── 🐘 programming.blade.php
│   │           │   │       │   └── 🐘 quiz.blade.php
│   │           │   │       ├── 📁 lesson-types/
│   │           │   │       │   ├── 🐘 document.blade.php
│   │           │   │       │   └── 🐘 video.blade.php
│   │           │   │       └── 🐘 course.blade.php
│   │           │   └── 🐘 index.blade.php
│   │           ├── 📁 instructor/
│   │           │   ├── 📁 components/
│   │           │   └── 📁 dashboard/
│   │           │       ├── 🐘 courses.blade.php
│   │           │       ├── 🐘 overview.blade.php
│   │           │       ├── 🐘 profile.blade.php
│   │           │       ├── 🐘 reviews.blade.php
│   │           │       └── 🐘 settings.blade.php
│   │           ├── 📁 lesson/
│   │           │   ├── 📁 components/
│   │           │   │   ├── 📁 assessment-types/
│   │           │   │   │   ├── 🐘 assignment.blade.php
│   │           │   │   │   ├── 🐘 programming-practice.blade.php
│   │           │   │   │   └── 🐘 quiz.blade.php
│   │           │   │   ├── 📁 lesson-types/
│   │           │   │   │   ├── 🐘 document.blade.php
│   │           │   │   │   └── 🐘 video.blade.php
│   │           │   │   └── 🐘 sidebar.blade.php
│   │           │   └── 🐘 index.blade.php
│   │           ├── 📁 organization/
│   │           │   ├── 📁 components/
│   │           │   │   └── 🐘 add-learners-builder.blade.php
│   │           │   └── 📁 dashboard/
│   │           │       ├── 🐘 courses.blade.php
│   │           │       ├── 🐘 members.blade.php
│   │           │       ├── 🐘 overview.blade.php
│   │           │       └── 🐘 settings.blade.php
│   │           └── 📁 student/
│   │               ├── 📁 components/
│   │               └── 📁 dashboard/
│   │                   ├── 🐘 courses.blade.php
│   │                   ├── 🐘 overview.blade.php
│   │                   ├── 🐘 purchases.blade.php
│   │                   ├── 🐘 reviews.blade.php
│   │                   └── 🐘 settings.blade.php
├── 📁 routes/
│   ├── 📁 client/
│   │   ├── 🐘 auth.php
│   │   ├── 🐘 course.php
│   │   ├── 🐘 instructor.php
│   │   ├── 🐘 organization.php
│   │   └── 🐘 student.php
│   ├── 🐘 console.php
│   └── 🐘 web.php
├── 📁 storage/
│   ├── 📁 app/
│   │   ├── 📁 private/
│   │   │   └── 📁 livewire-tmp/
│   │   ├── 📁 public/
│   │   │   ├── 📁 course/
│   │   │   │   └── 📁 videos/
│   ├── 📁 logs/
│   ├── 📁 pail/
├── 📁 tests/
│   ├── 📁 Feature/
│   │   └── 🐘 ExampleTest.php
│   ├── 📁 Unit/
│   │   └── 🐘 ExampleTest.php
│   ├── 🐘 Pest.php
│   └── 🐘 TestCase.php
├── 📁 vendor/ 🚫 (auto-hidden)
├── 📄 .editorconfig
├── 🔒 .env 🚫 (auto-hidden)
├── 📄 .env.example
├── 📄 .gitattributes
├── 📝 CODE_OF_CONDUCT.md
├── 📄 CodeZoneDatabase.drawio
├── 📜 LICENSE
├── 📖 README.md
├── 📄 artisan
├── 📄 composer.json
├── 🔒 composer.lock 🚫 (auto-hidden)
├── 📄 package-lock.json
├── 📄 package.json
├── 📄 phpunit.xml
└── 📄 vite.config.js
```

---
