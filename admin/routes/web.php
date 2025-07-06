<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListBookController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DetailBooksController;
use App\Http\Controllers\AllReportController;
use App\Http\Controllers\ReportedCommentController;
use App\Http\Controllers\ReportReviewController;
use App\Http\Controllers\DetailUsersController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AdminPasswordController;
use App\Http\Controllers\ReportedCmtDetailController;
use App\Http\Controllers\ReportedReviewController;
use App\Http\Controllers\ReportedReviewDetailController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Admin login routes
Route::get('/', [AdminLoginController::class, 'showLoginForm'])->name('adminlogin');
Route::post('/', [AdminLoginController::class, 'login'])->name('adminlogin');
Route::post('/adminlogout', [AdminLoginController::class, 'logout'])->name('adminlogout')->middleware('auth:admin');
Route::middleware(['auth:admin','verified'])->group(function () {
    //dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard']);
    //listbooks
    Route::get('/book/listbooks', [ListBookController::class, 'listbooks'])->name('book.listbooks');
    Route::get('/book/listbooks/{id}', [ListBookController::class, 'show'])->name('book.listbooks.show');
    Route::post('/book/listbooks/{id}/approve', [ListBookController::class, 'approve'])->name('book.listbooks.approve');
    Route::delete('/book/listbooks/{id}', [ListBookController::class, 'destroy'])->name('book.listbooks.destroy');
    //detailbooks
    Route::get('/book/details/{id}', [DetailBooksController::class, 'detailbook'])->name('book.detailbooks');
    Route::post('/book/details', [DetailBooksController::class, 'store'])->name('book.detailbooks.store');
    Route::put('/books/{id}/upload-cover', [DetailBooksController::class, 'uploadCover'])->name('book.uploadCover');
    //registers
    Route::get('/user/registers', [RegisterUserController::class, 'registers'])->name('user.registers');
    Route::get('/user/registers/{id}', [RegisterUserController::class, 'show'])->name('user.registers.show');
    Route::delete('/user/registers/{id}', [RegisterUserController::class, 'destroy'])->name('user.registers.destroy');
    Route::post('/user/registers/{id}/toggle-status', [RegisterUserController::class, 'updateStatus'])->name('user.registers.toggleStatus');
    //admin
    Route::get('/admin', [AdminController::class, 'admin'])->name('admin');
    Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::patch('/admin/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.toggleStatus');
    //profile
    Route::get('/adminprofile/profile', [AdminProfileController::class, 'showProfile'])->name('adminprofile.profile');
    Route::post('/adminprofile/profile', [AdminProfileController::class, 'updateProfile'])->name('adminprofile.profile.update');
    //password
    Route::get('/adminprofile/password', [AdminPasswordController::class, 'password'])->name('adminprofile.password');
    Route::put('/adminprofile/password', [AdminPasswordController::class, 'updatePassword'])->name('adminprofile.password.update');
   //detailuser
    Route::get('/user/detailuser/{id}/detail', [DetailUsersController::class, 'show'])->name('user.detailuser');
    Route::get('/user/detailuser/{id}/addbook', [DetailUsersController::class, 'addBook'])->name('user.addbook');
    //report
    Route::get('/report/allreport', [AllReportController::class, 'allreport'])->name('report.allreport');

    //reportcomment
    Route::get('/report/reportcomment', [ReportedCommentController::class, 'reportcomment'])->name('report.reportcomment');
    Route::post('/report/reportcomment/{id}/approve', [ReportedCommentController::class, 'approve'])->name('report.reportcomment.approve');
    Route::post('/report/reportcomment/{id}/reject', [ReportedCommentController::class, 'reject'])->name('report.reportcomment.reject');
    //reportreview
    Route::get('/report/reportreview', [ReportedReviewController::class, 'reportreview'])->name('report.reportreview');
    Route::post('/report/reportreview/{id}/approve', [ReportedReviewController::class, 'approve'])->name('report.reportreview.approve');
    Route::post('/report/reportreview/{id}/reject', [ReportedReviewController::class, 'reject'])->name('report.reportreview.reject');
    //adminprofile
    //Route::get('/adminprofile/profile', [AdminProfileController::class, 'profile'])->name('adminprofile.profile');
    //reportcomment detail
    Route::get('/report/reportcommentdetail/{id}', [ReportedCmtDetailController::class, 'show'])->name('report.reportcommentdetail');
    Route::post('/report/reportcommentdetail/{id}/approve', [ReportedCmtDetailController::class, 'approve'])->name('report.reportcommentdetail.approve');
    Route::get('/report/reportcommentdetail/{id}/reject', [ReportedCmtDetailController::class, 'reject'])->name('report.reportcomment.reject');
    //reportreview detail
    Route::get('/report/reportreviewdetail/{id}', [ReportedReviewDetailController::class, 'show'])->name('report.reportreviewdetail');
    Route::post('/report/reportreviewdetail/{id}/approve', [ReportedReviewDetailController::class, 'approve'])->name('report.reportreviewdetail.approve');
    Route::get('/report/reportreviewdetail/{id}/reject', [ReportedReviewDetailController::class, 'reject'])->name('report.reportreview.reject');
    //contact us
    Route::get('/contact/contact_us', [ContactController::class, 'index'])->name('contact.messages');
    Route::get('/contact/reply/{id}', [ContactController::class, 'reply'])->name('contact.reply');
    Route::post('/contact/reply/{id}', [ContactController::class, 'sendReply'])->name('contact.sendReply'); 
});