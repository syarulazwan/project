<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestEmailController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Project\DIDController;
use App\Http\Controllers\Project\ChatController;
use App\Http\Controllers\Project\DocumentController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Project\MyProjectController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Project\ListProjectController;
use App\Http\Controllers\Profile\RequestAccessController;
use App\Http\Controllers\Profile\ExistingAccessController;
use App\Http\Controllers\Profile\RequestAccessApproverController;
use App\Http\Controllers\Administration\Access\Menu\MenuController;
use App\Http\Controllers\Administration\Access\Role\RoleController;
use App\Http\Controllers\Administration\Organization\UnitController;
use App\Http\Controllers\Administration\Profile\MyProfileController;
use App\Http\Controllers\Administration\Organization\BranchController;
use App\Http\Controllers\Administration\Organization\CompanyController;
use App\Http\Controllers\Administration\Organization\JobGradeController;
use App\Http\Controllers\Administration\Access\Role\SwitchRoleController;
use App\Http\Controllers\Administration\Organization\DepartmentController;
use App\Http\Controllers\Administration\Organization\DesignationController;
use App\Http\Controllers\Administration\UserManagement\User\UserController;
use App\Http\Controllers\Administration\AuditManagement\AccessLogController;
use App\Http\Controllers\Administration\AuditManagement\GeneralLogController;
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

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'prevent-back-history'])
    ->name('dashboard');

Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    Route::get('/logout', [LogoutController::class, 'Logout'])->name('page.logout');

    Route::post('/switch-role', [SwitchRoleController::class, 'switch'])->name('switch.role');

    Route::prefix('administration')->group(function () {

        Route::prefix('user-management')->group(function () {
            Route::prefix('user')->controller(UserController::class)->group(function () {
                Route::get('/', 'index')->name('user-management.user.index');
                Route::get('/ajax', 'getUserAjax')->name('user-management.user.ajax');
                Route::get('/getRole', 'getRoleUserAjax')->name('user-management.getRole.ajax');
                Route::get('/getUserRoles/{userId}', 'getUserRoles')->name('user-management.getUserRoles.ajax');
                Route::post('/assignRoles', 'assignRoles')->name('user-management.assignRoles.ajax');
                Route::post('/store', 'store')->name('user-management.store.ajax');
                Route::post('/updateUser/{userId}', 'updateUser')->name('user-management.updateUser.ajax');
                Route::delete('/deleteUser/{userId}', 'deleteUser')->name('user-management.deleteUser.ajax');
            });
        });

        Route::prefix('access-management')->group(function () {

            Route::prefix('menu')->controller(MenuController::class)->group(function () {
                Route::get('/', 'index')->name('access-management.menu.index');
                Route::get('/ajax', 'getMenuAjax')->name('access-management.menu.ajax');
                Route::post('/store', 'store')->name('access-management.menu.store');
                Route::post('/updateMenu/{userId}', 'updateMenu')->name('access-management.updateMenu.ajax');
                Route::delete('/deleteMenu/{userId}', 'deleteMenu')->name('access-management.deleteMenu.ajax');
            });

            Route::prefix('role')->controller(RoleController::class)->group(function () {
                Route::get('/', 'index')->name('access-management.role.index');
                Route::get('/ajax', 'getRoleAjax')->name('access-management.role.ajax');
                Route::post('/store', 'store')->name('access-management.role.store');
                Route::post('/updateRole/{userId}', 'updateRole')->name('access-management.updateRole.ajax');
                Route::delete('/deleteRole/{userId}', 'deleteRole')->name('access-management.deleteRole.ajax');
            });

            Route::prefix('permission')->controller(PermissionController::class)->group(function () {
                Route::get('/', 'index')->name('access-management.permission.index');
                Route::get('/ajax', 'getPermissionAjax')->name('access-management.permission.ajax');
                Route::post('/updatePermission', 'updatePermission')->name('access-management.updatePermission.ajax');
                Route::post('/updatePermissionBulk', 'updatePermissionBulk')->name('access-management.updatePermissionBulk.ajax');
            });

        });

        Route::prefix('organization-management')->group(function () {

            Route::prefix('company')->controller(CompanyController::class)->group(function () {
                Route::get('/', 'index')->name('organization-management.company.index');
                Route::get('/ajax', 'getCompanyAjax')->name('organization-management.company.ajax');
                Route::post('/store', 'store')->name('organization-management.company.store');
                Route::post('/updateCompany/{userId}', 'updateCompany')->name('organization-management.updateCompany.ajax');
                Route::delete('/deleteCompany/{userId}', 'deleteCompany')->name('organization-management.deleteCompany.ajax');
            });

            Route::prefix('branch')->controller(BranchController::class)->group(function () {
                Route::get('/', 'index')->name('organization-management.branch.index');
                Route::get('/ajax', 'getBranchAjax')->name('organization-management.branch.ajax');
                Route::post('/store', 'store')->name('organization-management.branch.store');
                Route::post('/updatebranch/{userId}', 'updateBranch')->name('organization-management.updatebranch.ajax');
                Route::delete('/deletebranch/{userId}', 'deleteBranch')->name('organization-management.deletebranch.ajax');
            });

            Route::prefix('department')->controller(DepartmentController::class)->group(function () {
                Route::get('/', 'index')->name('organization-management.department.index');
                Route::get('/ajax', 'getDepartmentAjax')->name('organization-management.department.ajax');
                Route::post('/store', 'store')->name('organization-management.department.store');
                Route::post('/updatedepartment/{userId}', 'updateDepartment')->name('organization-management.updatedepartment.ajax');
                Route::delete('/deletedepartment/{userId}', 'deleteDepartment')->name('organization-management.deletedepartment.ajax');
            });

            Route::prefix('unit')->controller(UnitController::class)->group(function () {
                Route::get('/', 'index')->name('organization-management.unit.index');
                Route::get('/ajax', 'getUnitAjax')->name('organization-management.unit.ajax');
                Route::post('/store', 'store')->name('organization-management.unit.store');
                Route::post('/updateunit/{userId}', 'updateUnit')->name('organization-management.updateunit.ajax');
                Route::delete('/deleteunit/{userId}', 'deleteUnit')->name('organization-management.deleteunit.ajax');
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

        Route::prefix('audit-management')->group(function () {

            Route::prefix('access-log')->controller(AccessLogController::class)->group(function () {
                Route::get('/', 'index')->name('audit-management.access-log.index');
                Route::get('/ajax', 'getAccessLogAjax')->name('audit-management.access-log.ajax');
            });

            Route::prefix('general-log')->controller(GeneralLogController::class)->group(function () {
                Route::get('/', 'index')->name('audit-management.general-log.index');
                Route::get('/ajax', 'getGeneralLogAjax')->name('audit-management.general-log.ajax');
            });


        });

    });

    Route::prefix('profile')->group(function () {

        Route::prefix('my-profile')->controller(MyProfileController::class)->group(function () {
            Route::get('/', 'index')->name('profile.my-profile.index');
            Route::get('/ajax', 'getUserAjax')->name('profile.my-profile.ajax');
        });

        Route::prefix('request-access-to-document')->group(function () {
            Route::prefix('user')->controller(RequestAccessController::class)->group(function () {
                Route::get('/', 'index')->name('profile.request-access-to-document.index');
                Route::get('/ajax', 'getUserAjax')->name('profile.request-access-to-document.ajax');
            });

            Route::prefix('approver')->controller(RequestAccessApproverController::class)->group(function () {
                Route::get('/', 'index')->name('profile.approver.index');
                Route::get('/ajax', 'getUserAjax')->name('profile.approver.ajax');
            });

        });

        Route::prefix('existing-access')->group(function () {

            Route::prefix('list-of-documents')->controller(ExistingAccessController::class)->group(function () {
                Route::get('/', 'index')->name('existing-access.list-of-documents.index');
                Route::get('/ajax', 'getMenuAjax')->name('existing-access.list-of-documents.ajax');
            });

        });

    });

    Route::prefix('project')->group(function () {

        Route::prefix('my-project')->controller(MyProjectController::class)->group(function () {
            Route::get('/', 'index')->name('project.my-project.index');
            Route::get('/ajax', 'getUserAjax')->name('project.my-project.ajax');
        });

        Route::prefix('list-of-project')->controller(ListProjectController::class)->group(function () {
            Route::get('/', 'index')->name('project.list-project.index');
            Route::get('/ajax', 'getUserAjax')->name('project.list-project.ajax');
        });

        Route::prefix('zara')->group(function () {

            // Chat routes
            Route::controller(ChatController::class)->group(function () {
                Route::get('/chat', 'main')->name('chatai.chat.index');
                Route::post('/chat/ask', 'ask')->name('chatai.chat.ask');
            });

            // PDF upload routes
            Route::prefix('pdf')->controller(DocumentController::class)->group(function () {
                Route::get('/', 'uploadPage')->name('chatai.pdf.index');
                Route::post('/upload', 'upload')->name('chatai.pdf.upload');
                Route::delete('/{document}', 'destroy')->name('chatai.pdf.delete');
            });

            // D-ID video route
            Route::get('/api/did/video/{id}', [DIDController::class, 'getVideo'])->name('chatai.did.video');
        });

      

    });



});



