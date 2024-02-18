<?php

use Illuminate\Support\Facades\{
    Route, Auth, Cache, Log, Gate
};
use App\Http\Controllers\{
    Auth\RegisterController, Auth\LoginController,
    DashboardHomeController, UserController, ProfileController,
    DashboardRepresentativeController, DashboardMaterialController,
    DashboardPatientController, DashboardLastVisitController,
    DashboardXRayController, DashboardAppointmentController,
    DashboardAnalysisController, DashboardPrescriptionController,
    DashboardMaterialTreatmentController, DashboardTreatmentController,
    DashboardPrescriptionTreatmentController, PDF\PatientPDFController,
    PDF\PrescriptionPDFController, PDF\PrescriptionTreatmentPDFController,
    PDF\AppointmentPDFController, PDF\TreatmentPDFController, PDF\ReceiptController,
    DashboardMedicalHistoryController,/* PDF\MedicalHistoryPDFController, */
    DashboardPaymentController, DashboardContactController
};

// use GuzzleHttp\Middleware;
// use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
// use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

// If any route is non-existing in the project, then 404 page will appear
Route::fallback(function(){
    return abort(404);
});

Route::middleware(['web', 'guest'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        // Change the register route form "register" to "/dashboard/register"
        Route::middleware(['redirectTo404'])->group(function () { // Redirect the route or url of the register "http://localhost:8000/dashboard/register" to "404"
            Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('dashboard.register');
            Route::post('/register', [RegisterController::class, 'register']);
        });
        // Change the login route form "login" to "/dashboard/login"
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('dashboard.login');
        Route::post('/login', [LoginController::class, 'login']);
    });

    // Redirect "/register" to "/dashboard/register" for unauthenticated users (guests)
    Route::get('register', function () {
        return redirect()->route('dashboard.register');
    });

    // Redirect "/login" to "/dashboard/login" for unauthenticated users (guests)
    Route::get('login', function () {
        return redirect()->route('dashboard.login');
    });
});

// Redirect the standard route or url "http://localhost:8000/" (www.example.com) to "http://localhost:8000/dashboard" (www.example.com/dashboard)
Route::get('/')->middleware('redirectToDashboard');

/************************************* Start - Dashboard Routes *************************************/
Route::group([
    'middleware' => ['auth', 'dashboard']
], function(){
    Route::prefix('dashboard')->group(function(){
        Route::get('/', [DashboardHomeController::class, 'index'])->name('dashboard');
        // Users routes
        Route::resource('/users', UserController::class)->except(['index', 'show']);
        Route::get('/users' , [UserController::class, 'AllUsers'])->name('users.UsersIndex');
        Route::get('/user/doctors' , [UserController::class, 'AllDoctors'])->name('users.DoctorsIndex');
        Route::get('/user/employees' , [UserController::class, 'AllEmployees'])->name('users.EmployeesIndex');
        Route::get('/user/developers' , [UserController::class, 'AllDevelopers'])->name('users.DevelopersIndex');

        // Profiles routes
        Route::get('/users/profile/{username}' , [ProfileController::class, 'showProfile'])->name('authUserProfileView');
        Route::post('/users/profile', [ProfileController::class, 'storeOrUpdate'])->name('profile.storeOrUpdate');

        // Change Password routes => For auth()->user() users only! Which are the logged in users themselves not anyone else even the system creators (developers)
        Route::middleware(['checkUserActivity.logOut'])->group(function () { // Log out the authenticated user (logged in user) and redirect him/her to the login page with a message (for AFK reason)
            Route::get('/user/change-password/{username}', [UserController::class, 'changePassword'])->name('users.changePassword');
            Route::patch('/user/change-password/{id}', [UserController::class, 'updatePassword'])->name('users.updatePassword');
        });

        // Patients routes
        Route::resource('/patients',DashboardPatientController::class)->except(['show']);
        Route::get('/patients/{id}/{first_name?}' , [DashboardPatientController::class, 'show'])->name('patients.show');
        Route::get('/pdf/patients', [PatientPDFController::class, 'index'])->name('patients.pdf'); // PDF Patient

        // Last Visits routes (for Patients!)
        Route::get('/patient/last-visits', [DashboardLastVisitController::class, 'index'])->name('patients.lastVisitsIndex');
        Route::get('/patient/last-visits/slug/{id}/{first_name?}', [DashboardLastVisitController::class, 'show'])->name('patients.lastVisitsShow');
        Route::get('/patient/last-visits/{id}/create', [DashboardLastVisitController::class, 'create'])->name('patients.lastVisitsCreate');
        Route::post('/patient/last-visits', [DashboardLastVisitController::class, 'store'])->name('patients.lastVisitsStore');
        Route::delete('/patient/last-visits/{id}', [DashboardLastVisitController::class, 'destroy'])->name('patients.lastVisitsDestroy');

        // XRays routes
        Route::resource('/x-rays', DashboardXRayController::class);
        Route::delete('/all-x-rays/clear', [DashboardXRayController::class, 'clearAll'])->name('x-rays.clear');
        Route::delete('/patient/{id}/x-rays/clear', [DashboardXRayController::class, 'clearAllForPatient'])->name('patient.x-rays.clear');
        Route::get('/patient/{id}/x-rays', [DashboardXRayController::class, 'indexSingle'])->name('patient.x-rays.index');
        Route::get('/patient/{id}/x-rays/create', [DashboardXRayController::class, 'createSingle'])->name('patient.x-rays.create');
        Route::get('/patient/{id}/x-rays/edit', [DashboardXRayController::class, 'editSingle'])->name('patient.x-rays.edit');
        Route::get('/patient/{id}/x-rays/gallery', [DashboardXRayController::class, 'patientGallery'])->name('patient.x-rays.gallery');

        // Representatives routes
        Route::resource('/representatives', DashboardRepresentativeController::class)->except(['show']);

        // Appointments routes
        Route::resource('/appointments', DashboardAppointmentController::class);
        Route::get('/patient/{id}/appointments' , [DashboardAppointmentController::class, 'showIndex'])->name('appointmentsOfPatient.showIndex');
        Route::get('/appointment/trash', [DashboardAppointmentController::class,'trash'])->name('appointments.trash');
        Route::get('/appointment/restore/{id}', [DashboardAppointmentController::class, 'restore'])->name('appointments.restore');
        Route::delete('/appointment/forceDelete/{id}', [DashboardAppointmentController::class, 'forceDelete'])->name('appointments.forceDelete');
        Route::get('/pdf/appointments', [AppointmentPDFController::class, 'index'])->name('appointments.index.pdf'); // for the "index" of appointments
        Route::get('/patient/{id}/pdf/appointments', [AppointmentPDFController::class, 'showIndex'])->name('appointments.show-index.pdf'); // for the "show-index" of appointments
        Route::get('/pdf/appointment/{id}', [AppointmentPDFController::class, 'show'])->name('appointments.show.pdf'); // for the "show" of appointments

        // Analyses routes
        Route::resource('/analyses', DashboardAnalysisController::class)->except(['show']);

        // Prescriptions routes
        Route::resource('/prescriptions', DashboardPrescriptionController::class);
        Route::get('/pdf/appointments/prescriptions', [PrescriptionPDFController::class, 'index'])->name('prescriptions.index.pdf');
        Route::get('/patient/pdf/appointment/prescription/{id}', [PrescriptionPDFController::class, 'show'])->name('prescriptions.show.pdf');

        // Materials routes
        Route::resource('/materials', DashboardMaterialController::class)->except(['show']);

        // Treatments routes
        Route::resource('/treatments', DashboardTreatmentController::class);
        Route::get('/patient/{id}/treatments' , [DashboardTreatmentController::class, 'showIndex'])->name('treatmentsOfPatient.showIndex');
        Route::get('/pdf/treatments', [TreatmentPDFController::class, 'index'])->name('treatments.index.pdf'); // for the "index" of treatments
        Route::get('/patient/{id}/pdf/treatments', [TreatmentPDFController::class, 'showIndex'])->name('treatments.show-index.pdf'); // for the "show-index" of treatments
        Route::get('/pdf/treatment/{id}', [TreatmentPDFController::class, 'show'])->name('treatments.show.pdf'); // for the "show" of treatments

        // Materials Treatments routes
        Route::get('/materials-treatments', [DashboardMaterialTreatmentController::class, 'index'])->name('materials-treatments.index');

        // Prescriptions Treatments routes
        Route::resource('/prescriptions-treatments', DashboardPrescriptionTreatmentController::class);
        Route::get('/patient/pdf/prescriptions-treatments', [PrescriptionTreatmentPDFController::class, 'index'])->name('prescriptions-treatments.index.pdf');
        Route::get('/patient/pdf/treatment-prescription/{id}', [PrescriptionTreatmentPDFController::class, 'show'])->name('prescriptions-treatments.show.pdf');

        // Medical Histories routes
        Route::resource('/medical-histories', DashboardMedicalHistoryController::class);
        Route::get('/medical-history/trash', [DashboardMedicalHistoryController::class,'trash'])->name('medical-histories.trash');
        // Route::get('/pdf/medical-histories', [MedicalHistoryPDFController::class, 'index'])->name('medical-histories.pdf'); // PDF Medical History

        // Payments routes
        Route::resource('/payments', DashboardPaymentController::class);
        Route::get('/patient/{id}/payments', [DashboardPaymentController::class, 'indexSingle'])->name('patient.payments.index');
        Route::get('/patient/{id}/payments/create', [DashboardPaymentController::class, 'createSingle'])->name('patient.payments.create');
        Route::get('/patient/{patientId}/payment/{paymentId}/edit', [DashboardPaymentController::class, 'editSingle'])->name('patient.payments.edit');

        // Receipts routes
        Route::get('/pdf/receipts', [ReceiptController::class, 'index'])->name('receipts.index.pdf');
        Route::get('/receipts/{id}', [ReceiptController::class, 'show'])->name('receipts.show.pdf');
        Route::get('/patient/{id}/pdf/receipts', [ReceiptController::class, 'showIndex'])->name('receipts.show-index.pdf');

        // Contacts routes
        Route::resource('/contacts', DashboardContactController::class);
    });
});
/************************************* End - Dashboard Routes *************************************/

/************************************* Start - Telescope Routes *************************************/
Route::get('codex-clinic-debug-assistant')->name('dashboard.debugging');

// Route::get('/cache', function () {
//     if(Cache::has('testCache')){ // Cache::has('key')
//         return Cache::get('testCache'); // Cache::get('key');
//     }
//     Cache::add('testCache', 'myCache'); // Cache::add('key', 'value');
//     return Cache::get('testCache'); // Cache::get('key');
// });

// Route::get('/dumps', function () {
//     return dump('dumps!!!');
// });

// Route::get('/gates', function () {
//     if (Gate::forUser(Auth::user())->allows('testGate')) {
//         return 'you are allowed to take this action';
//     }
//     abort(403);
// });
/************************************* End - Telescope Routes *************************************/
