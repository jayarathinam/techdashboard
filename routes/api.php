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

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group([], function ($router) {
    Route::get('users/requests', 'UsersController@requests');
    Route::get('users/blockedusers', 'UsersController@blockedusers');
    Route::get('users/getuser/{id}', 'UsersController@getUser');
    Route::post('users/activate/{id}', 'UsersController@activate');
    Route::post('users/block/{id}', 'UsersController@block');
    Route::post('users/bulkupload', 'UsersController@bulkupload');
    Route::post('users/process', 'UsersController@processCSV');
    Route::resource('users','UsersController');
});

Route::group([], function ($router) {
    Route::get('projects/{userid}', 'ProjectController@getbyUser');
    Route::get('projects/getproj/{id}', 'ProjectController@getProject');
    Route::get('projects/getocm/{id}', 'ProjectController@getOcm');
    Route::get('projects/getreg/{id}', 'ProjectController@getReg');
    Route::put('projects/bconfdetails/{tid}', 'ProjectController@updateBConfdetails');
    Route::put('projects/idmenuname/{tid}/{idmenuid}', 'ProjectController@updateCDname');
    Route::put('projects/idate/{tid}/{idateid}', 'ProjectController@updateCdate');
    Route::put('projects/idorder/{tid}/{idateid}', 'ProjectController@updateCDorder');
    Route::put('projects/downorder/{tid}/{did}', 'ProjectController@updateCDownorder');
    Route::put('projects/qlorder/{tid}/{qlid}', 'ProjectController@updateQLOrder');
    Route::put('projects/confdate/{tid}', 'ProjectController@updateConfDate');
    Route::put('projects/cfpaper/{tid}/{cpid}', 'ProjectController@updateCFPaper');
    Route::put('projects/qlinks/{tid}/{qlid}', 'ProjectController@updateQLinks');
    Route::put('projects/download/{tid}/{did}', 'ProjectController@updateDownload');
    Route::put('projects/acontent/{tid}/{acid}', 'ProjectController@updateAContent');
    Route::put('projects/acpriority/{tid}/{acid}', 'ProjectController@updateACPriority');
    Route::post('projects/ircategory/{tid}/{regmenuid}/{regsmenuid}', 'ProjectController@addRCategory');
    Route::post('projects/ircurtype/{tid}/{regmenuid}', 'ProjectController@addRCurtype');
    Route::post('projects/iregtype/{tid}/{regmenuid}', 'ProjectController@addRegtype');
    Route::post('projects/iregsmenu/{tid}/{regmenuid}', 'ProjectController@addRSubmenu');
    Route::post('projects/iregmenu/{tid}', 'ProjectController@addRMenu');
    Route::post('projects/iimpdate/{tid}', 'ProjectController@addImpDate');
    Route::post('projects/icfpaper/{tid}', 'ProjectController@addCFpaper');
    Route::post('projects/iqlinks/{tid}', 'ProjectController@addQLinks');
    Route::post('projects/idownload/{tid}', 'ProjectController@addDownload');
    Route::post('projects/iacontent/{tid}', 'ProjectController@addAcontent');
    Route::post('projects/icgallery/{tid}', 'ProjectController@addCGallery');
    Route::post('projects/icimages/{tid}/{gid}', 'ProjectController@addCImages');
    Route::delete('projects/drcategory/{catid}', 'ProjectController@deleteRCategory');
    Route::delete('projects/dcrtype/{regtypeid}', 'ProjectController@deleteCRtype');
    Route::delete('projects/drsmenu/{regsmenuid}', 'ProjectController@deleteRsmenu');
    Route::delete('projects/drmenu/{regmenuid}', 'ProjectController@deleteRmenu');
    Route::delete('projects/didate/{idmenuid}', 'ProjectController@deleteIdate');
    Route::delete('projects/dcfpaper/{cfpid}', 'ProjectController@deleteCFPaper');
    Route::delete('projects/dqlinks/{qlid}', 'ProjectController@deleteQlinks');
    Route::delete('projects/ddownload/{did}', 'ProjectController@deleteDownload');
    Route::delete('projects/dacontent/{did}', 'ProjectController@deleteAContent');
    Route::delete('projects/dgallery/{did}', 'ProjectController@deleteGallery');
    Route::delete('projects/dgimage/{gid}/{gname}', 'ProjectController@deleteGImage');
    Route::post('projects/iocm/{tid}/{ocmsubid}', 'ProjectController@insertOcm');
    Route::put('projects/ramount/{tid}/{regid}', 'ProjectController@updateRamount');
    Route::put('projects/rcategory/{tid}/{catid}', 'ProjectController@updateRcategory');
    Route::put('projects/regtype/{tid}/{regtypeid}', 'ProjectController@updateRegtype');
    Route::put('projects/regsubmenu/{tid}/{regsmenuid}', 'ProjectController@updateRegsubmenu');
    Route::put('projects/regmenu/{tid}/{regmenuid}', 'ProjectController@updateRegmenu');
    Route::post('projects/iocmtitle/{tid}', 'ProjectController@insertOcmtitle');
    Route::post('projects/iocmsub/{tid}/{ocmtid}', 'ProjectController@insertOcmsub');
    Route::put('projects/uocm/{tid}/{ocmid}', 'ProjectController@updateOcm');
    Route::put('projects/uocmtitle/{tid}/{ocmtid}', 'ProjectController@updateOcmtitle');
    Route::put('projects/uocmsub/{tid}/{ocmsid}', 'ProjectController@updateOcmsub');
    Route::put('projects/pocm/{tid}/{ocmid}', 'ProjectController@updateOcmPriority');
    Route::put('projects/ocmimage/{tid}/{ocmid}', 'ProjectController@updateOcmImage');
    Route::put('projects/psocm/{tid}/{ocmsubid}', 'ProjectController@updateOcmsubPriority');
    Route::put('projects/ptocm/{tid}/{ocmtid}', 'ProjectController@updateOcmtitlePriority');
    Route::delete('projects/docm/{ocmid}', 'ProjectController@deleteOcm');
    Route::delete('projects/docmtitle/{ocmtitleid}', 'ProjectController@deleteOcmtitle');
    Route::delete('projects/docmsubtitle/{ocmtitleid}', 'ProjectController@deleteOcmsubtitle');
});
