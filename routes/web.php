<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestEmailController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Project\ChatController;
use App\Http\Controllers\Project\DocumentController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Administration\Access\Menu\MenuController;
use App\Http\Controllers\Administration\Access\Role\RoleController;
use App\Http\Controllers\Administration\Organization\UnitController;
use App\Http\Controllers\Administration\Organization\BranchController;
use App\Http\Controllers\Administration\Organization\CompanyController;
use App\Http\Controllers\Administration\Organization\JobGradeController;
use App\Http\Controllers\Administration\Access\Role\SwitchRoleController;
use App\Http\Controllers\Administration\Orgnization\DepartmentController;
use App\Http\Controllers\Administration\Organization\DesignationController;
use App\Http\Controllers\Administration\UserManagement\User\UserController;
use App\Http\Controllers\Administration\Access\Permission\PermissionController;

Route::get('/', function () {

    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth/login');
    
})->name('home');

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'index'])->name('login.form'); 
    Route::post('/login', [LoginController::class, 'store'])->name('login');

    Route::get('/register', [RegistrationController::class, 'index'])->name('sign-up.form'); 
    Route::post('/register', [RegistrationController::class, 'store'])->name('register'); 

    Route::get('/forgot', [ForgotPasswordController::class, 'index'])->name('forgot.form'); 
    Route::post('/forgot', [ForgotPasswordController::class, 'store'])->name('forgot'); 

});

Route::get('/dashboard', function () {

    return view('pages.dashboard/dashboard');

})->middleware(['auth', 'verified', 'prevent-back-history'])->name('dashboard');

Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    Route::get('/logout', [LogoutController::class, 'Logout'])->name('page.logout');

    Route::post('/switch-role', [SwitchRoleController::class, 'switch'])->name('switch.role');

    Route::prefix('administration')->group(function () {

        Route::prefix('user-management')->group(function () {
            Route::prefix('user')->controller(UserController::class)->group(function () {
                Route::get('/', 'index')->name('user-management.user.index');
                Route::get('/ajax', 'getUserAjax')->name('user-management.user.ajax');
            });
        });

        Route::prefix('access-management')->group(function () {

            Route::prefix('menu')->controller(MenuController::class)->group(function () {
                Route::get('/', 'index')->name('access-management.menu.index');
                Route::get('/ajax', 'getMenuAjax')->name('access-management.menu.ajax');
            });

            Route::prefix('role')->controller(RoleController::class)->group(function () {
                Route::get('/', 'index')->name('access-management.role.index');
                Route::get('/ajax', 'getRoleAjax')->name('access-management.role.ajax');
            });

            Route::prefix('permission')->controller(PermissionController::class)->group(function () {
                Route::get('/', 'index')->name('access-management.permission.index');
                Route::get('/ajax', 'getPermissionAjax')->name('access-management.permission.ajax');
            });

        });

        Route::prefix('organization-management')->group(function () {

            Route::prefix('company')->controller(CompanyController::class)->group(function () {
                Route::get('/', 'index')->name('organization-management.company.index');
                Route::get('/ajax', 'getCompanyAjax')->name('organization-management.company.ajax');
            });

            Route::prefix('branch')->controller(BranchController::class)->group(function () {
                Route::get('/', 'index')->name('organization-management.branch.index');
                Route::get('/ajax', 'getBranchAjax')->name('organization-management.branch.ajax');
            });

            Route::prefix('department')->controller(DepartmentController::class)->group(function () {
                Route::get('/', 'index')->name('organization-management.department.index');
                Route::get('/ajax', 'getDepartmentAjax')->name('organization-management.department.ajax');
            });

            Route::prefix('unit')->controller(UnitController::class)->group(function () {
                Route::get('/', 'index')->name('organization-management.unit.index');
                Route::get('/ajax', 'getUnitAjax')->name('organization-management.unit.ajax');
            });

            Route::prefix('job-grade')->controller(JobGradeController::class)->group(function () {
                Route::get('/', 'index')->name('organization-management.job-grade.index');
                Route::get('/ajax', 'getJobGradeAjax')->name('organization-management.job-grade.ajax');
            });

            Route::prefix('designation')->controller(DesignationController::class)->group(function () {
                Route::get('/', 'index')->name('organization-management.designation.index');
                Route::get('/ajax', 'getDesignationAjax')->name('organization-management.designation.ajax');
            });


        });

    });

});





Route::prefix('zara')->group(function () {

    Route::controller(ChatController::class)->group(function () {
        Route::get('/', 'index')->name('zara.chat.index');
        Route::post('/ask', 'ask')->name('zara.chat.ask');
    });

    Route::prefix('pdf')->controller(DocumentController::class)->group(function () {
        Route::get('/', 'index')->name('zara.pdf.index');
        Route::post('/upload', 'upload')->name('zara.pdf.upload');
    });

});

Route::get('/documents/list', function () {
    return \App\Models\Document::select('id', 'title')->get();
})->name('documents.list');


Route::get('/test-email', [TestEmailController::class, 'send']);