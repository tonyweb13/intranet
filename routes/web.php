<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('index');
})->middleware('auth');

Route::group(['middleware' => ['web']], function() {

    Route::get('login',  'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

    // // Registration Routes...
    //     Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
    //     Route::post('register', ['as' => 'register.post', 'uses' => 'Auth\RegisterController@register']);

    // // Password Reset Routes...
    //     Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
    //     Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
    //     Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
    //     Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Auth\ResetPasswordController@reset']);

});
/*Start API Route*/
Route::group([
    'prefix' => 'api', 'middleware' => ['auth']
], function () {

    Route::get('/user/getLoginUser', 'UserController@getLoginUser');
    Route::resource('/dashboard/scripts', 'ScriptsController');
    Route::get('/dashboard/dropdown', 'ScriptsController@dropdown');
    Route::post('/dashboard/script_tag/upload', 'ScriptsController@scriptTags');
    Route::get('/dashboard/view/{any}', 'ScriptsController@getScripts');
    Route::get('/dashboard/script/user', 'ScriptsController@getUserScripts');
    Route::get('/countries', 'CountriesController@index');

    Route::group([
        'prefix' => 'admin', 'middleware' => ['auth']
    ], function () {
        Route::get('/dropdown/requestedby', 'Api\Admin\DropdownController@requestedBy');
        Route::get('/dropdown/supervisor', 'Api\Admin\DropdownController@supervisor');
        Route::get('/dropdown/assistant', 'Api\Admin\DropdownController@assistant');
        // Route::resource('/request_payment', 'Api\Admin\RequestPaymentController');
        Route::get('/request_payment', 'Api\Admin\RequestPaymentController@index');
        Route::get('/request_payment/create', 'Api\Admin\RequestPaymentController@create');
        Route::get('/request_payment/requestor', 'Api\Admin\RequestPaymentController@requestor');
        Route::put('/request_payment/approval', 'Api\Admin\RequestPaymentController@approval');
        // Route::resource('/purchasing_supplies', 'Api\Admin\PurchasingSuppliesController');
        Route::get('/purchasing_supplies', 'Api\Admin\PurchasingSuppliesController@index');
        Route::get('/purchasing_supplies/create', 'Api\Admin\PurchasingSuppliesController@create');
        Route::get('/purchasing_supplies/requestor', 'Api\Admin\PurchasingSuppliesController@requestor');
        Route::put('/purchasing_supplies/approval', 'Api\Admin\PurchasingSuppliesController@approval');

    });

    Route::group([
        'prefix' => 'action', 'middleware' => ['auth']
    ], function () {
        //survey
        Route::resource('/survey', 'Api\Action\SurveyController');
        Route::resource('/surveyresult', 'Api\Action\SurveyResultController');
        Route::get('/survey/edit/{id}', 'Api\Action\SurveyController@getSurvey');
        Route::resource('/question', 'Api\Action\QuestionController');
        Route::get('/getquestion/{id}', 'Api\Action\QuestionController@getQuestion');
        Route::post('/upload/question', 'Api\Action\QuestionController@imageUpload');
        Route::post('/upload/post_upload', 'Api\Action\QuestionController@post_upload');
        Route::post('/vote/cast', 'Api\Action\QuestionController@castVote');
        Route::get('/vote/count/{id}', 'Api\Action\QuestionController@voteCount');

    });
    
    Route::group([
        'prefix' => 'hr', 'middleware' => ['auth']
    ], function () {
        //issuance of nte
        Route::get('/dropdown/category', 'Api\HR\NteCategoryController@dropdown');
        Route::get('/dropdown/provision/{catid}', 'Api\HR\ProvisionController@dropdown');
        Route::get('/dropdown/gravity', 'Api\HR\GravityController@dropdown');
        Route::get('/dropdown/corrective', 'Api\HR\CorrectiveActionController@dropdown');

        Route::resource('/correctiveaction', 'Api\HR\CorrectiveActionController');
        Route::resource('/provision', 'Api\HR\ProvisionController');
        Route::resource('/gravity', 'Api\HR\GravityController');
        Route::resource('/nte/category', 'Api\HR\NteCategoryController');
        Route::resource('/nte', 'Api\HR\NteController');
        Route::resource('/ntelistform', 'Api\HR\NteFormController');
        Route::resource('/offense', 'Api\HR\OffenseController');
        
        Route::get('/offense/category/{catid}', 'Api\HR\OffenseController@category');
        Route::get('/ntelist/{id}', 'Api\HR\NteFormController@getInfo');
        Route::get('/nte/form/{any}', 'Api\HR\NteController@getNte');
        Route::get('/nte/dropdown/nteform', 'Api\HR\NteFormController@dropdown');
        Route::get('/nte/getuser/{empno}', 'Api\HR\NteController@getUser');
    });

    //payment manager
    Route::group([
        'prefix' => 'paymentmanager', 'middleware' => ['auth']
    ], function () {
        Route::resource('/paymentmanager', 'Api\LoanApproval\PaymentManagerController');
        Route::resource('/paymentchanges', 'Api\LoanApproval\PaymentChangeController');
        Route::get('/paymenttype/dropdown', 'Api\LoanApproval\PaymentChangeController@paymentType');
        Route::get('/search', 'Api\LoanApproval\PaymentManagerController@searchApp');
    });

    Route::group([
        'prefix' => 'loanapproval', 'middleware' => ['auth']
    ], function () {

        Route::resource('/application', 'Api\LoanApproval\ApplicationController');

        Route::get('/application/grab/{apps}', 'Api\LoanApproval\ApplicationController@grabApplication');
        Route::get('/application/status/{status_id}', 'Api\LoanApproval\ApplicationController@status');
        Route::resource('/notes', 'Api\LoanApproval\NotesController');
        Route::get('/notes/status/{status_id}/{loan_id}', 'Api\LoanApproval\NotesController@status');
        Route::resource('/badaba', 'Api\LoanApproval\BadABAController');
        Route::resource('/adjustmentfinancefee', 'Api\LoanApproval\AdjFeesController');
        Route::resource('/states', 'Api\LoanApproval\StatesController');
        Route::resource('/correction', 'Api\LoanApproval\CorrectionController');
        Route::get('/correction_parent/dropdown', 'Api\LoanApproval\CorrectionController@dropdown');
        Route::get('/deplicate-check', 'Api\LoanApproval\NotesController@status');
        Route::get('/getLoanStates/{state}', 'Api\LoanApproval\StatesController@getLoanStates');
        Route::get('/corrections', 'Api\LoanApproval\Corrections@getCorrections');
        Route::put('/corrections/appToCorrection', 'Api\LoanApproval\Corrections@appToCorrection');


//        Route::resource('/reassignapp', 'Api\LoanApproval\ReAssignController');
        Route::patch('/reassignapp/underwriters/{appid}/{underwriter_id}', 'Api\LoanApproval\ReAssignController@assignUnderwriter');
        Route::get('/reassignapp/underwriters', 'Api\LoanApproval\ReAssignController@getUnderwriters');
        Route::get('/reassignapp/applications', 'Api\LoanApproval\ReAssignController@getAvailableAppForReassignment');

        Route::patch('/reApproved', 'Api\LoanApproval\ApplicationController@reApproved');
        Route::patch('/approved', 'Api\LoanApproval\ApplicationController@approved');
        Route::patch('/deny', 'Api\LoanApproval\ApplicationController@deny');

        /* Duplicate Checker */
        Route::get('/duplicate_checker', 'Api\LoanApproval\DuplicateCheck@index');
        Route::get('/check_portfolios', 'Api\LoanApproval\DuplicateCheck@checkPortfolios');

        Route::resource('/dcinfo', 'Api\LoanApproval\DCInfoController');
    });

    Route::group([
        'prefix' => 'tk', 'middleware' => ['auth']
    ], function () {
        Route::resource('/shiftactivities', 'Api\Tk\ShiftActivitiesController');
        Route::resource('/shift', 'Api\Tk\ShiftController');
        Route::resource('/schedules', 'Api\Tk\SchedulesController');
    });

    Route::group([
        'prefix' => 'tickets', 'middleware' => ['auth']
    ], function () {
        Route::resource('/ticket', 'Api\Ticket\TicketController');
        Route::post('/ticket/upload', 'Api\Ticket\TicketController@upload');
    });

    // Route::group([
    //     'prefix' => 'dcinfo', 'middleware' => ['auth']
    // ], function () {
    //     Route::resource('/dc', 'Api\DCInfo\DCInfoController');        
    // });

    Route::group([
        'prefix' => 'vps', 'middleware' => ['auth']
    ], function () {
        /* upload profile pic */
        Route::post('');

        /*edit profile*/
        Route::post('/user_update/upload', 'Api\Vps\UserUpdateController@uploadPic');
        Route::get('/user_update/personal/{id}', 'Api\Vps\UserUpdateController@updatePersonal');
        Route::get('/user_update/employment/{id}', 'Api\Vps\UserUpdateController@updateEmployment');
        Route::get('/user_update/educational/{id}', 'Api\Vps\UserUpdateController@updateEducational');
        Route::get('/user_update/government/{id}', 'Api\Vps\UserUpdateController@updateGovernment');
        Route::get('/user_update/details/{id}', 'Api\Vps\UserUpdateController@updateDetails');
        
//        Route::get('/rules/getRuleParent/{id}', 'Api\Vps\RulesController@getRuleParent');
//        Route::get('/rules/getRuleChild/{id}', 'Api\Vps\RulesController@getRuleChild');
//        Route::get('/rules/findChild/{id}', 'Api\Vps\RulesController@findChild');
//        Route::get('/rules/findSwitchOn/{id}/{name}', 'Api\Vps\RulesController@findSwitchOn')->where(['id' => '[0-9]+', 'name' => '[a-z]+']);
//        Route::get('/rules/getParentChild', 'Api\Vps\RulesController@getParentChild');

        Route::get('/rules/getAclRulesBindToUser/{empid}', 'Api\Vps\RulesController@getAclRulesBindToUser');
        Route::post('/rules/saveAclRulesBindToUser/{empid}', 'Api\Vps\RulesController@saveAclRulesBindToUser');
        
//        Route::resource('/rules', 'Api\Vps\RulesController');
        // Route::get('/rules/findChild/{rule_parent_id?}', 'Api\Vps\RulesController@findChild')
        // ->where(array('rule_parent_id' => '[0-9]+'));



    });

    Route::group([
        'prefix' => 'settings', 'middleware' => ['auth']
    ], function () {
        Route::get('/department/dropdown', 'Api\Settings\DepartmentController@dropdown');
        Route::get('/officelocation/dropdown', 'Api\Settings\OfficeLocationController@dropdown');
        Route::get('/employment_type/dropdown', 'Api\Settings\EmploymentTypeController@dropdown');
        Route::get('/designation/dropdown', 'Api\Settings\DesignationController@dropdown');
        Route::get('/acl_rule_parent/dropdown', 'Api\Settings\ACLRulesController@dropdown');
        Route::get('/portfolio/dropdown', 'Api\Settings\PortfolioController@dropdown');
        Route::post('/employee/updatepassword', 'Api\Settings\EmployeeController@updatePassword');

        Route::resource('/acl', 'Api\Settings\ACLRulesController');
        Route::resource('/department', 'Api\Settings\DepartmentController');
        Route::resource('/employee', 'Api\Settings\EmployeeController');
        Route::get('/employee_dropdown/dropdown', 'Api\Settings\EmployeeController@dropdown');
        Route::resource('/costcenter', 'Api\Settings\CostCenterController');
        Route::resource('/designation', 'Api\Settings\DesignationController');
        Route::resource('/officelocation', 'Api\Settings\OfficeLocationController');
        Route::resource('/employment', 'Api\Settings\EmploymentTypeController');
        Route::resource('/portfolio', 'Api\Settings\PortfolioController');
        Route::get('/usersgroups/portfolio/{portfolio_id}', 'Api\Settings\UsersGroupsController@portfolio');
        Route::put('/usersgroups/updates', 'Api\Settings\UsersGroupsController@updateUsersGroups');
        Route::get('/usersgroups/teamlead/{portfolio_id}', 'Api\Settings\UsersGroupsController@getTeamLead');
    });


    Route::group([
        'prefix' => 'epic', 'middleware' => ['auth']
    ], function () {

        Route::get('/{portfolio}/{environment}', 'EpicApiController@index');
        Route::get('/{portfolio}/{environment}/config', 'EpicApiController@config');
        Route::get('/{portfolio}/{environment}/verifyCustomer/', 'EpicApiController@verifyCustomer');
        Route::get('/{portfolio}/{environment}/customer', 'EpicApiController@customer');
        Route::get('/{portfolio}/{environment}/loans/{app_no}', 'EpicApiController@loans');
//        Route::resource('/{portfolio}/{environment}/notes', 'EpicApiController@notes');
//        Route::resource('/{portfolio}/{environment}/payments', 'EpicApiController@payments');
//        Route::resource('/{portfolio}/{environment}/payments', 'EpicApiController@payroll');
    });

    Route::group([
        'prefix' => 'lms', 'middleware' => ['auth']
    ], function () {
        Route::get('/{portfolio}/verifyCustomer/', 'LmsApiController@verifyCustomer');
    });

    /*QA System Routes*/
    Route::group([
        'prefix' => 'qa', 'middleware' => ['auth']
    ], function () {
        Route::group(['prefix' => 'user', 'middleware' => ['auth']], function () {
            Route::get('/all', 'Api\QualityAssurance\UserDataController@allUser');
            Route::get('/active', 'Api\QualityAssurance\UserDataController@activeUsers');
            Route::get('/supervisors', 'Api\QualityAssurance\UserDataController@activeSupervisor');
            Route::get('/locations', 'Api\QualityAssurance\UserDataController@usersLocation');
        });
        Route::group(['prefix' => 'form', 'middleware' => ['auth']], function () {
            Route::get('/all', 'Api\QualityAssurance\FormsController@allForms');
            Route::get('/type', 'Api\QualityAssurance\FormsController@formType');
            Route::post('/search', 'Api\QualityAssurance\FormsController@searchForms');
            Route::post('/audit/create', 'Api\QualityAssurance\FormsController@createNewForm');
        });
        Route::group(['prefix' => 'session', 'middleware' => ['auth']], function () {
            Route::post('/get/month', 'Api\QualityAssurance\SessionController@getMonth');
            Route::post('/set/month', 'Api\QualityAssurance\SessionController@setMonth');
        });
    });

});

/*End API Route*/

/* Vue index routing there should be now route after this */
Route::get('/{vue_template}', function ($name) {
    return view('index');
})->where('vue_template', '.*');