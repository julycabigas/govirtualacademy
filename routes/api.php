<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([ 'prefix' => 'auth'], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::group([ 'middleware' => 'jwt.auth'], function ($router) {

    Route::get('videos', 'VideosController@all');
    Route::get('videos/{id}', 'VideosController@get');
    Route::post('videos/new', 'VideosController@new');
    Route::post('videos/update/{id}', 'VideosController@update');
    Route::post('videos/delete/{id}', 'VideosController@delete');

    Route::post('courses/new', 'CoursesController@new');
    Route::get('courses/{id}', 'CoursesController@get');
    Route::post('courses/update/{id}', 'CoursesController@update');
    Route::post('courses/delete/{id}', 'CoursesController@delete');
    Route::get('all-courses', 'CoursesController@allList');
    Route::get('all-course-identifiers', 'CourseIdentifierController@all');
    Route::get('all-course-identifiers-list', 'CourseIdentifierController@list');
    Route::get('course-group/{id}', 'CourseIdentifierController@getStudentCourseGroups');
    Route::post('course-identifiers/update/{id}', 'CourseIdentifierController@update');
    Route::post('course-identifiers/create', 'CourseIdentifierController@new');
    Route::post('course-identifiers/new', 'CourseIdentifierController@addCourse');
    Route::post('course-identifiers/delete/{id}', 'CourseIdentifierController@delete');
    Route::post('course-identifiers-group/update/{id}', 'CourseIdentifierController@updateGroup');
    Route::get('course-identifiers/{id}', 'CourseIdentifierController@get');
    Route::get('course-identifiers-group/{id}', 'CourseIdentifierController@getGroup');
    Route::get('course-identifiers-name/{id}', 'CourseIdentifierController@getName');
    Route::get('course-identifiers', 'CourseIdentifierController@allGroups');

    Route::post('free-trial/update/{id}', 'FreeTrialController@update');


    Route::get('task-group-identifiers', 'CourseIdentifierController@allGroupIdentifiers');
    Route::get('group-courses', 'CourseGroupController@all');
    Route::get('group-courses/{id}', 'CourseGroupController@get');
    Route::post('group-courses/update/{id}', 'CourseGroupController@update');
    Route::post('group-courses/delete/{id}', 'CourseGroupController@delete');

    Route::get('modules', 'ModulesController@all');    
    Route::get('all-modules', 'ModulesController@list'); 
    Route::get('modules/{id}', 'ModulesController@get');
    Route::post('modules/new', 'ModulesController@add');
    Route::post('modules/update/{id}', 'ModulesController@update');
    Route::post('modules/delete/{id}', 'ModulesController@delete');
    Route::get('course-modules/{id}', 'ModulesController@getModules');



    Route::post('tasks/create', 'TaskController@new');
    Route::get('tasks', 'TaskController@all');
    Route::get('tasklist', 'TaskController@list');
    Route::get('tasks/{id}', 'TaskController@get');
    Route::post('tasks/update/{id}', 'TaskController@update');
    Route::post('tasks/delete/{id}', 'TaskController@delete');


    Route::post('exercises/create', 'ExercisesController@new');
    Route::get('exercises', 'ExercisesController@all');
    Route::get('exercise-list', 'ExercisesController@list');
    Route::get('exercises/{id}', 'ExercisesController@get');
    Route::post('exercises/update/{id}', 'ExercisesController@update');
    Route::post('exercises/delete/{id}', 'ExercisesController@delete');

    Route::post('exercise-entry/check/{id}', 'ExerciseEntryController@checkCompleted');
    Route::post('student-exercises/new', 'ExerciseEntryController@new');
    Route::put('admin-exercises/update/{id}', 'ExerciseEntryController@update');
    Route::get('exercise-entry', 'ExerciseEntryController@all');
    Route::get('exercise-entry/{id}', 'ExerciseEntryController@get');
    Route::post('exercise-entry/delete/{id}', 'ExerciseEntryController@delete');


    Route::post('resources/create', 'ResourceController@new');
    Route::get('resources', 'ResourceController@all');
    Route::get('resourcelist', 'ResourceController@list');
    Route::get('resources/{id}', 'ResourceController@get');
    Route::post('resources/update/{id}', 'ResourceController@update');
    Route::post('resources/delete/{id}', 'ResourceController@delete');
    

    Route::post('resource-category/create', 'ResourceCategoryController@new');
    Route::get('resource-category', 'ResourceCategoryController@all');
    Route::get('resource-category-list', 'ResourceCategoryController@list');
    Route::get('resource-category/{id}', 'ResourceCategoryController@get');
    Route::post('resource-category/update/{id}', 'ResourceCategoryController@update');
    Route::post('resource-category/delete/{id}', 'ResourceCategoryController@delete');
    Route::get('all-resources', 'ResourceCategoryController@listResources');
    


    Route::post('supports/create', 'SupportController@new');
    Route::get('supports', 'SupportController@all');
    Route::get('supportlist', 'SupportController@list');
    Route::get('support-by-cat/{id}', 'SupportController@getByCategory');
    Route::get('supports/{id}', 'SupportController@get');
    Route::post('supports/update/{id}', 'SupportController@update');
    Route::post('supports/delete/{id}', 'SupportController@delete');
    
  
    Route::post('support-category/create', 'SupportCategoryController@new');
    Route::get('support-category', 'SupportCategoryController@all');
    Route::get('support-category-list', 'SupportCategoryController@list');
    Route::get('support-category/{id}', 'SupportCategoryController@get');
    Route::post('support-category/update/{id}', 'SupportCategoryController@update');
    Route::post('support-category/delete/{id}', 'SupportCategoryController@delete');
    Route::get('all-supports', 'SupportCategoryController@listSupports');


    Route::post('blueprints/create', 'BlueprintController@new');
    Route::get('blueprints', 'BlueprintController@all');
    Route::get('blueprintlist', 'BlueprintController@list');
    Route::get('blueprint-by-cat/{id}', 'BlueprintController@getByCategory');
    Route::get('blueprints/{id}', 'BlueprintController@get');
    Route::post('blueprints/update/{id}', 'BlueprintController@update');
    Route::post('blueprints/delete/{id}', 'BlueprintController@delete');


    Route::post('blueprint-category/create', 'BlueprintCategoryController@new');
    Route::get('blueprint-category', 'BlueprintCategoryController@all');
    Route::get('blueprint-category-list', 'BlueprintCategoryController@list');
    Route::get('blueprint-category/{id}', 'BlueprintCategoryController@get');
    Route::post('blueprint-category/update/{id}', 'BlueprintCategoryController@update');
    Route::post('blueprint-category/delete/{id}', 'BlueprintCategoryController@delete');
    Route::get('all-blueprints', 'BlueprintCategoryController@listBlueprints');


    Route::get('mentors', 'MentorController@all');
    Route::get('mentor-single/{id}', 'MentorController@get');
    Route::post('mentors/update/{id}', 'MentorController@updateByAdmin');

    Route::post('webinars/create', 'WebinarController@new');
    Route::get('webinars', 'WebinarController@all');
    Route::get('webinars-list', 'WebinarController@list');
    Route::get('webinars/{id}', 'WebinarController@get');
    Route::post('webinars/update/{id}', 'WebinarController@update');
    Route::post('webinars/delete/{id}', 'WebinarController@delete');


    Route::post('student-tasks/new', 'TaskEntryController@new');
    Route::post('student-tasks/update/{id}', 'TaskEntryController@update');
    Route::get('task-entry', 'TaskEntryController@all');
    Route::post('task-entry/pending', 'TaskEntryController@pending');
    Route::get('task-entry/all-pending', 'TaskEntryController@getPending');
    Route::get('task-entry/{id}', 'TaskEntryController@get');
    Route::post('task-entry/delete/{id}', 'TaskEntryController@delete');
    Route::post('task-entry/check/{id}', 'TaskEntryController@checkCompleted');

    Route::post('badges/create', 'BadgeController@new');
    Route::get('badges', 'BadgeController@all');
    Route::get('badges-list', 'BadgeController@list');
    Route::get('badges/{id}', 'BadgeController@get');
    Route::post('badges/update/{id}', 'BadgeController@update');
    Route::post('badges/delete/{id}', 'BadgeController@delete');

    Route::get('badge-req/{id}', 'BadgeRequirementController@getBadges');    
    Route::post('badge-req/update/{id}', 'BadgeRequirementController@update');

    Route::post('student-badges/new', 'StudentBadgesController@new');
    Route::get('student-badges', 'StudentBadgesController@all');
    Route::get('student-badges/{id}', 'StudentBadgesController@get');
    Route::post('student-badges/delete/{id}', 'StudentBadgesController@delete');

    Route::post('my-permission/{id}', 'CoursePermissionsController@getPermission');
    Route::get('get-course-roles/{id}', 'CoursePermissionsController@courseRoles');
    Route::post('course-permission/update/{id}', 'CoursePermissionsController@update');
    Route::post('course-permission/new', 'CoursePermissionsController@new');


    Route::get('my-courses/{id}', 'CoursesController@getMyCourses');
    Route::get('my-lessons/{id}', 'VideosController@getMyLessons');
    Route::get('free-courses', 'CoursesController@getFreeCourses');

    Route::post('categories/new', 'CategoriesController@new');
    Route::post('categories/update/{id}', 'CategoriesController@update');

    Route::get('examination', 'ExaminationController@all');
    Route::get('all-examination', 'ExaminationController@listing');
    Route::get('examination/{id}', 'ExaminationController@get');
    Route::get('examination/course/{id}', 'ExaminationController@getByCourse');
    Route::post('examination/new', 'ExaminationController@new');
    Route::post('examination/update/{id}', 'ExaminationController@update');
    Route::post('examination/delete/{id}', 'ExaminationController@delete');

    Route::get('certification', 'CertificationsController@all');
    Route::get('certification-request', 'CertificationsController@allRequest');
    Route::get('certification/{id}', 'CertificationsController@get');
    Route::post('certification/new', 'CertificationsController@new');
    Route::post('certification/update/{id}', 'CertificationsController@update');
    Route::post('certification/delete/{id}', 'CertificationsController@delete');  

    Route::get('stats-training', 'StatController@allTraining');
    Route::get('stats-courses', 'StatController@allCourses');
    Route::get('stats-videos', 'StatController@allVideos');
    Route::get('stats-students', 'StatController@allStudents');
    Route::get('stats-purchased', 'StatController@allPurchased');
    Route::get('stats-pending-purchased', 'StatController@allPendingPurchased');

    Route::get('results', 'ResultsController@all');
    Route::get('results/{id}', 'ResultsController@get');
    Route::post('my-results/{id}', 'ResultsController@checkFailedResults');
    Route::get('results/student-exams/{id}', 'ResultsController@StudentExamResults');
    Route::get('results/student/{id}', 'ResultsController@getUserResults');
    Route::post('results/new', 'ResultsController@new');
    Route::post('results/update/{id}', 'ResultsController@update');
    Route::post('results/delete/{id}', 'ResultsController@delete');

    Route::get('students', 'StudentsController@all');
    Route::get('students-list', 'StudentsController@allList');
    Route::post('students/new', 'StudentsController@new');
    Route::get('students/{id}', 'StudentsController@get');
    Route::post('students/delete/{id}', 'StudentsController@delete');
    Route::post('students/update-privacy/{id}', 'StudentsController@updatePrivacy');

    
    Route::get('mentorships/{id}', 'StudentsController@allMentorship');

    Route::post('students/update-password/{id}', 'StudentsController@updatePassword');
    Route::post('students/add-testimony/{id}', 'StudentsController@addTestimony');

    Route::post('posts/new', 'PostsController@new');
    Route::get('posts/{id}', 'PostsController@get');
    Route::post('posts/update/{id}', 'PostsController@update');
    Route::post('posts/delete/{id}', 'PostsController@delete');


    Route::get('reviews', 'ReviewsController@all');
    Route::get('reviews/{id}', 'ReviewsController@get');
    Route::post('reviews/new', 'ReviewsController@new');
    Route::post('reviews/create', 'ReviewsController@create');
    Route::post('reviews/update/{id}', 'ReviewsController@update');
    Route::post('reviews/approve/{id}', 'ReviewsController@approve');
    Route::post('reviews/delete/{id}', 'ReviewsController@delete');

    Route::get('students/{id}', 'StudentsController@get');
    Route::post('students/update/{id}', 'StudentsController@updateInfo');
    Route::post('student-info/update/{id}', 'StudentsController@updateByAdmin');

    Route::get('settings', 'SettingsController@all');
    Route::post('settings/edit', 'SettingsController@update');


    Route::get('purchases', 'PurchaseController@all');
    Route::get('purchases/{id}', 'PurchaseController@get');
    Route::get('mypurchases/{id}', 'PurchaseController@getMyPurchases');
    Route::post('purchases/new', 'PurchaseController@new');
    Route::post('purchases/update/{id}', 'PurchaseController@update');
    Route::post('approve-payment/update/{id}', 'PurchaseController@approvePayment');
    Route::get('approve-purchases', 'PurchaseController@allApproved');
    Route::get('pending-purchases', 'PurchaseController@allPending');
    Route::post('purchases/delete/{id}', 'PurchaseController@delete');


    Route::get('training', 'TrainingController@all');

    Route::get('access', 'AccessLevelController@all');

    Route::post('access/new', 'AccessLevelController@new');
    Route::get('access/{id}', 'AccessLevelController@get');
    Route::post('access/update/{id}', 'AccessLevelController@update');

    Route::get('course-access/{id}', 'TrainingController@getCourseAccess');
    Route::get('student-access/{id}', 'AccessItemController@get');
    Route::post('student-access/update/{id}', 'AccessItemController@update');

    Route::post('student-purchased/update/{id}', 'AccessItemController@checkUserPurchased');
    Route::post('student-bundle-purchased/update/{id}', 'AccessItemController@checkPurchasedBundle');

    Route::get('check-student-access', 'AccessLevelController@allList');
});

Route::get('access-list', 'AccessLevelController@allList');
Route::get('bundle-courses-list', 'AccessLevelController@allList');
Route::get('single-bundle/{id}', 'TrainingController@getBundleCourse');
Route::get('roles', 'RolesController@all');
Route::get('posts', 'PostsController@all');
Route::get('categories', 'CategoriesController@all');
Route::get('categories/{id}', 'CategoriesController@get');
Route::get('courses-by-category/{id}', 'CoursesController@getCoursesById');
Route::post('search', 'CoursesController@searchCourses');
Route::get('featured-course', 'CoursesController@getFeaturedCourses');
Route::get('virtual-assistant-course', 'CoursesController@getVACourses');
Route::get('courses', 'CoursesController@all');
Route::get('courses-public', 'CoursesController@allVisible');
Route::get('courses/{id}', 'CoursesController@get');
Route::get('video-by-course/{id}', 'VideosController@getVideosByCourse');
Route::get('approved-reviews', 'ReviewsController@allApprove');
Route::post('users/new', 'UsersController@new');
Route::post('users/create-from-purchase', 'UsersController@createInPurchase');
Route::get('mentors', 'MentorController@all');
Route::get('mentors/profile/{id}', 'MentorController@get');
Route::get('mentors/total_students/{id}', 'MentorController@getAllStudents');

Route::get('all-students', 'StudentsController@allVisibleProfile');
Route::get('all-students/{id}', 'StudentsController@getVisibleStudent');

Route::post('forgot-password', 'UsersController@forgotPassword');
Route::post('reset-password', 'UsersController@resetPassword');