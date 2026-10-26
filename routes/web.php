<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DafacController;
use App\Http\Controllers\VawcController;
use App\Http\Controllers\SoloParentController;
use App\Http\Controllers\PwdController;
use App\Http\Controllers\DayCareWorkerController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Every app route sits behind `login_auth`. Each module group also requires
| its access flag via `module:<name>` (see App\Models\User::MODULES).
|
*/

Route::get('/', function () {
    return view('login');
});

//Login
Route::get('/login',[LoginController::class,'getLogin'])->name('getLogin');
Route::post('/login',[LoginController::class,'postLogin'])->name('postLogin');

//Middleware
Route::group(['middleware'=>['login_auth']],function(){
    Route::get('/dashboard',[MasterController::class,'dashboard'])->name('dashboard');
    Route::get('/dashboard/{id}',[MasterController::class,'dashboardFaced'])->name('dashboardFaced');

    //Users
    Route::prefix('user')->middleware('module:admin')->group(function() {
        Route::get('/', [UserController::class, 'userRead'])->name('userRead');
        Route::post('/create', [UserController::class, 'userCreate'])->name('userCreate');
        Route::get('/edit/{id}', [UserController::class, 'userEdit'])->name('userEdit');
        Route::post('/update', [UserController::class, 'userUpdate'])->name('userUpdate');
        Route::delete('/delete/{id}', [UserController::class, 'userDelete'])->name('userDelete');
    });

    //Senior
    Route::prefix('/senior')->middleware('module:senior')->group(function () {
        Route::get('/',[CitizenController::class,'citizenRead'])->name('citizenRead');
        Route::post('/create',[CitizenController::class,'citizenCreate'])->name('citizenCreate');
        Route::get('/moreinfo/{encryptedId}',[CitizenController::class,'citizenMoreInfo'])->name('citizenMoreInfo');
        Route::post('/upmoreinfo',[CitizenController::class,'MoreInfoUpdate'])->name('MoreInfoUpdate');
        Route::get('/list/pdf/{id}', [CitizenController::class, 'citizenReadPdf'])->name('citizenReadPdf');
        Route::post('/list/idcards', [CitizenController::class, 'citizenIdCards'])->name('citizenIdCards');
        Route::delete('/delete/{id}', [CitizenController::class,'citizenDelete'])->name('citizenDelete');
        Route::post('/update-profile-image/{id}', [CitizenController::class, 'updateProfileImage'])->name('update-profile-image');
        Route::post('/update-citizen-files/{id}', [CitizenController::class, 'updateCitizenFiles'])->name('updateCitizenFiles');
        Route::post('/citizens/update-status/{id}', [CitizenController::class, 'updateStatus'])->name('updateCitizenStatus');
        Route::delete('/delete-file/{id}/{fileName}', [CitizenController::class, 'deleteFile'])->name('deleteFile');
        Route::post('/address/update', [AddressController::class, 'addressUpdate'])->name('addressUpdate');
    });

    //Dafac
    Route::prefix('/faced')->middleware('module:dafac')->group(function () {
        Route::get('/',[DafacController::class,'dafacRead'])->name('dafacRead');
        Route::get('/form',[DafacController::class,'dafacForm'])->name('dafacForm');
        Route::post('/create',[DafacController::class,'dafacCreate'])->name('dafacCreate');
        Route::get('/edit/{id}',[DafacController::class,'dafacEdit'])->name('dafacEdit');
        Route::post('/update',[DafacController::class,'dafacUpdate'])->name('dafacUpdate');
        Route::get('/pdf/{id}/{f}', [DafacController::class, 'dafacPdf'])->name('dafacPdf');
        Route::delete('/delete/{id}', [DafacController::class,'dafacDelete'])->name('dafacDelete');
        Route::delete('/delete-ass/{id}', [DafacController::class,'assDelete'])->name('assDelete');

        Route::prefix('/assistance')->group(function () {
            Route::get('/',[DafacController::class,'assRead'])->name('assRead');
            Route::post('/create',[DafacController::class,'assCreate'])->name('assCreate');
        });
    });

    //VAWC
    Route::prefix('/vawc')->middleware('module:vawc')->group(function () {
        Route::get('/vac',[VawcController::class,'vawcRead'])->name('vawcRead');
        Route::get('/vac/form',[VawcController::class,'vawcForm'])->name('vawcForm');
        Route::post('/create',[VawcController::class,'vawcCreate'])->name('vawcCreate');
    });

    //Solo-Parent
    Route::prefix('/soloparent')->middleware('module:soloparent')->group(function () {
        Route::get('/record',[SoloParentController::class,'soloparentRead'])->name('soloparentRead');
        Route::get('/form',[SoloParentController::class,'soloparentForm'])->name('soloparentForm');
        Route::post('/create',[SoloParentController::class,'soloparentCreate'])->name('soloparentCreate');
    });

    //PWD
    Route::prefix('/pwd')->middleware('module:pwd')->group(function () {
        Route::get('/record',[PwdController::class,'pwdRead'])->name('pwdRead');
        Route::get('/form',[PwdController::class,'pwdForm'])->name('pwdForm');
        Route::post('/create',[PwdController::class,'pwdCreate'])->name('pwdCreate');
    });

    //Day Care (Child Development) Workers
    Route::prefix('/daycare')->middleware('module:daycare')->group(function () {
        Route::get('/workers',[DayCareWorkerController::class,'daycareRead'])->name('daycareRead');
        Route::get('/form',[DayCareWorkerController::class,'daycareForm'])->name('daycareForm');
        Route::post('/create',[DayCareWorkerController::class,'daycareCreate'])->name('daycareCreate');
        Route::get('/edit/{id}',[DayCareWorkerController::class,'daycareEdit'])->name('daycareEdit');
        Route::post('/update/{id}',[DayCareWorkerController::class,'daycareUpdate'])->name('daycareUpdate');
        Route::get('/form-6/blank',[DayCareWorkerController::class,'daycareBlankPdf'])->name('daycareBlankPdf');
        Route::get('/form-6/{id}',[DayCareWorkerController::class,'daycarePdf'])->name('daycarePdf');
        Route::delete('/delete/{id}',[DayCareWorkerController::class,'daycareDelete'])->name('daycareDelete');
    });

    //Reports (senior citizen data)
    Route::prefix('/generate')->middleware('module:senior')->group(function () {
        Route::get('/reports',[ReportsController::class,'reportsRead'])->name('reportsRead');
        Route::get('/seniorCitizenReports',[ReportsController::class,'generateReports'])->name('generateReports');
    });

    //Settings
    Route::prefix('/settings')->group(function () {
        Route::get('/account-settings',[SettingsController::class,'user_settings'])->name('user_settings');
        Route::middleware('module:admin')->group(function () {
            Route::get('/system-name',[SettingsController::class,'setting_list'])->name('setting_list');
            Route::post('/system-name',[SettingsController::class,'upload'])->name('upload');
        });
    });

    //account
    Route::prefix('/acccount')->group(function () {
        Route::get('/information',[ProfileController::class,'profileRead'])->name('profileRead');
        Route::post('/information/update',[ProfileController::class,'profileUpdate'])->name('profileUpdate');
        Route::post('/information/updatePass',[ProfileController::class,'profilePassUpdate'])->name('profilePassUpdate');
    });

    //Address lookups (used by the senior and DAFAC forms)
    Route::prefix('/address')->group(function() {
        Route::get('/provinces/{regionId}', [AddressController::class, 'getProvinces'])->name('getProvinces');
        Route::get('/cities/{provinceId}', [AddressController::class, 'getCities'])->name('getCities');
        Route::get('/barangays/{cityId}', [AddressController::class, 'getBarangays'])->name('getBarangays');
    });

    //Logout
    Route::get('/logout',[MasterController::class,'logout'])->name('logout');
});
