<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Group\GroupController;
use App\Http\Controllers\Intern\InternController;
use App\Http\Controllers\Mentor\MentorController;
use App\Http\Controllers\Review\ReviewController;
use App\Http\Controllers\Group\GroupInternController;
use App\Http\Controllers\Group\GroupMentorController;
use App\Http\Controllers\Intern\InternGroupController;
use App\Http\Controllers\Mentor\MentorGroupController;
use App\Http\Controllers\Intern\InternMentorController;
use App\Http\Controllers\Intern\InternReviewController;
use App\Http\Controllers\Mentor\MentorInternController;
use App\Http\Controllers\Mentor\MentorReviewController;
use App\Http\Controllers\Review\ReviewInternController;
use App\Http\Controllers\Review\ReviewMentorController;
use App\Http\Controllers\Assignment\AssignmentController;
use App\Http\Controllers\Group\GroupAssignmentController;
use App\Http\Controllers\Intern\InternAssignmentController;
use App\Http\Controllers\Mentor\MentorAssignmentController;
use App\Http\Controllers\Review\ReviewAssignmentController;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use App\Http\Controllers\Mentor\MentorInternReviewController;
use App\Http\Controllers\Assignment\AssignmentGroupController;
use App\Http\Controllers\Assignment\AssignmentInternController;
use App\Http\Controllers\Assignment\AssignmentMentorController;
use App\Http\Controllers\Assignment\AssignmentReviewController;

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

//Users
Route::name('me')->get('users/me', [UserController::class, 'me']);
Route::resource('users', UserController::class, ['except' => ['edit', 'create']]);
Route::name('changeRole')->put('users/{user}/changerole', [UserController::class, 'changeRole']);
Route::name('verify')->get('users/verify/{token}',[UserController::class,'verify']);
Route::name('resend')->get('users/{user}/resend', [UserController::class, 'resend']);

Route::post('oauth/token', [AccessTokenController::class, 'issueToken']);

//Mentors
Route::resource('mentors', MentorController::class, ['only' => ['index', 'show', 'update']]);
Route::resource('mentors.groups', MentorGroupController::class, ['only' => ['index']]);
Route::resource('mentors.interns', MentorInternController::class, ['only' => ['index']]);
Route::resource('mentors.assignments', MentorAssignmentController::class, ['except' => ['edit', 'create', 'show']]);
Route::resource('mentors.reviews', MentorReviewController::class, ['only' => ['index']]);
Route::resource('mentors.interns.reviews', MentorInternReviewController::class, ['only' => ['store', 'update', 'destroy']]);
Route::name('clone')->get('mentors/{mentor_id}/assignments/{assignment_id}/groups/{groups_id}/clone', [MentorAssignmentController::class, 'clone']);

//Interns
Route::resource('interns', InternController::class, ['except' => ['edit', 'create']]);
Route::resource('interns.groups', InternGroupController::class, ['only' => ['index']]);
Route::resource('interns.mentors', InternMentorController::class, ['only' => ['index']]);
Route::resource('interns.assignments', InternAssignmentController::class, ['only' => ['index']]);
Route::resource('interns.reviews', InternReviewController::class, ['only' => ['index']]);

//Groups
Route::resource('groups', GroupController::class,['except' => ['edit', 'create']]);
Route::resource('groups.mentors', GroupMentorController::class, ['only' => ['index']]);
Route::resource('groups.interns', GroupInternController::class, ['only' => ['index']]);
Route::resource('groups.assignments', GroupAssignmentController::class, ['only' => ['index']]);
Route::name('activate')->put('groups/{group}/assignments/{assignment}/activate', [GroupAssignmentController::class, 'activate']);
Route::name('addMentor')->put('groups/{group_id}/addmentor', [GroupController::class, 'addMentor']);
Route::name('deleteMentor')->put('groups/{group_id}/deletementor', [GroupController::class, 'deleteMentor']);

//Assignments
Route::resource('assignments', AssignmentController::class, ['only' => ['index', 'show']]);
Route::resource('assignments.groups', AssignmentGroupController::class, ['only' => ['index']]);
Route::resource('assignments.mentors', AssignmentMentorController::class, ['only' => ['index']]);
Route::resource('assignments.interns', AssignmentInternController::class, ['only' => ['index']]);
Route::resource('assignments.reviews', AssignmentReviewController::class, ['only' => ['index']]);

//Reviews
Route::resource('reviews', ReviewController::class, ['only' => ['index', 'show']]);
Route::resource('reviews.mentors', ReviewMentorController::class, ['only' => ['index']]);
Route::resource('reviews.interns', ReviewInternController::class, ['only' => ['index']]);
Route::resource('reviews.assignments', ReviewAssignmentController::class, ['only' => ['index']]);



