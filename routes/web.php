<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Rider\RiderController;
use App\Http\Controllers\Admin\RequestsController;

// login page to admin
Route::group([
    'middleware' => ['guest'],
], function () {
    Route::get('control/panel/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
    Route::post('control/panel/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login_admin'])->name('login');
});

//all linkks that admin can access 
Route::group([
    'middleware' => ['auth:admin'],
], function () {

    Route::group([
        'prefix' => 'stakeholders',
        // 'middleware' => ['permission:rider_box|driver_box|vechile_box|user_manage|stakeholders']
    ],function () { 
        Route::get('/show', [App\Http\Controllers\Admin\InternalTransfer\InternalTransferController::class, 'get_stakeholders']);

        // Route::post('/delivery/add', [App\Http\Controllers\Admin\Covenant\CovenantItemManageController::class, 'save_add']);
    });
    
    // all file pdf and images
    Route::get('show/pdf', [App\Http\Controllers\Controller::class , 'show_pdf']);

    //logout from control panel
    Route::get('logout', [App\Http\Controllers\Admin\Auth\homeController::class, 'logout']);
    
    // home page is the first page user see after login
    Route::get('/home', [App\Http\Controllers\Admin\Auth\homeController::class, 'home']);
    

    // user manage roles and permission
    Route::group([
        'prefix' => 'user',
        'middleware' => ['permission:user_manage']
    ],function () {
        Route::get('show', [App\Http\Controllers\Admin\Users\UsersController::class, 'show_users']);
        Route::get('add', [App\Http\Controllers\Admin\Users\UsersController::class, 'add_show']);
        Route::post('add', [App\Http\Controllers\Admin\Users\UsersController::class, 'add_save']);
        Route::get('update/{id}', [App\Http\Controllers\Admin\Users\UsersController::class, 'update_show']);
        Route::post('update', [App\Http\Controllers\Admin\Users\UsersController::class, 'update_save']);
        Route::get('detials/{id}', [App\Http\Controllers\Admin\Users\UsersController::class, 'detials']);
        Route::get('roles/show', [App\Http\Controllers\Admin\Users\Roles\RolesController::class, 'show_roles']);
        Route::get('roles/add', [App\Http\Controllers\Admin\Users\Roles\RolesController::class, 'show_add']);
        Route::post('roles/add', [App\Http\Controllers\Admin\Users\Roles\RolesController::class, 'save_role']);
        Route::get('roles/update/{id}', [App\Http\Controllers\Admin\Users\Roles\RolesController::class, 'update_show']);
        Route::post('roles/update', [App\Http\Controllers\Admin\Users\Roles\RolesController::class, 'update_save']);
    });
    
    // rider data that show rider and trips and convert hist state
    Route::group([
        'prefix' => 'rider',
        'middleware' => ['permission:rider_data']
    ],function () {     
        Route::get('show', [RiderController::class, 'index']);
        Route::get('detials/{id}', [RiderController::class, 'detials']);
        Route::get('trips/{id}', [RiderController::class, 'show']);
        Route::get('edit/{id}', [RiderController::class, 'edit']);
        Route::get('edit/state/{id}', [RiderController::class, 'change_state']);
});  
    
    //user accest to all trips and request in any state
    Route::group([
        'prefix' => 'requests',
        'middleware' => ['permission:requests']
    ],function () {  
        Route::get('/{request_state}', [RequestsController::class, 'requests']);
    });
    
    //Category and Ctiy manage
    Route::group([
        'prefix' => 'vechile',
        'middleware' => ['permission:category_city']
    ],function () { 
        Route::get('/show/cagegory', [App\Http\Controllers\Admin\Vechile\CategoryController::class, 'show_category']);
        Route::get('/detials/cagegory/{id}', [App\Http\Controllers\Admin\Vechile\CategoryController::class, 'detials_show']);
        Route::get('/add/cagegory', [App\Http\Controllers\Admin\Vechile\CategoryController::class, 'show_add']);
        Route::post('/add/cagegory', [App\Http\Controllers\Admin\Vechile\CategoryController::class, 'add_category']);
        Route::get('/update/cagegory/{id}', [App\Http\Controllers\Admin\Vechile\CategoryController::class, 'update_show']);
        Route::post('/update/cagegory', [App\Http\Controllers\Admin\Vechile\CategoryController::class, 'update_category']);
        
        Route::get('/add/cagegory/secondary/{id}', [App\Http\Controllers\Admin\Vechile\CategorySecondaryController::class, 'show_add']);
        Route::post('/add/cagegory/secondary', [App\Http\Controllers\Admin\Vechile\CategorySecondaryController::class, 'add_category']);
        Route::get('/update/secondary/cagegory/{id}', [App\Http\Controllers\Admin\Vechile\CategorySecondaryController::class, 'update_show']);
        Route::post('/update/secondary/cagegory', [App\Http\Controllers\Admin\Vechile\CategorySecondaryController::class, 'update_category']);
        

        Route::get('/show/city/{id}', [App\Http\Controllers\Admin\Vechile\CityController::class, 'show_city']);
        Route::get('/add/city/{id}', [App\Http\Controllers\Admin\Vechile\CityController::class, 'show_add']);
        Route::post('/add/city', [App\Http\Controllers\Admin\Vechile\CityController::class, 'add_city']);
        Route::get('/update/city/{catid}/{citid}', [App\Http\Controllers\Admin\Vechile\CityController::class, 'show_update']);
        Route::post('/update/city', [App\Http\Controllers\Admin\Vechile\CityController::class, 'update_city']);
    
    });

    //vechile data show all vechiles and add new vechile, change state to vechile
    Route::group([
        'prefix' => 'vechile',
        'middleware' => ['permission:vechile_data']
    ],function () {     
        Route::get('/add', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'show_add']);
        Route::post('/add', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'add_vechile']);
        Route::get('/show/{state?}', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'show_vechile']);
        Route::get('/update/{id}', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'update_show']);
        Route::post('/update', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'update_vechile']);
        Route::get('/details/{id}', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'detials']);
        
        // Ajax get secondary Category
        Route::get('/secondary/category', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'secondary_category']);


        Route::get('/drivers/{id}', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'drivers']);
        
        Route::get('/state/{id}', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'show_state']);
        Route::post('/state', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'save_state']);

        Route::get('/maintenance/{id}', [App\Http\Controllers\Admin\Driver\Maintenance\MaintenanceController::class, 'vechile_show_maintenance']);

    });

    //  driver data show all drivers and add new driver
    Route::group([
        'prefix' => 'driver',
        'middleware' => ['permission:driver_data']
    ],function () { 
        Route::get('/show/{state?}', [App\Http\Controllers\Admin\Driver\DriverController::class, 'show_driver']);
        Route::get('/add', [App\Http\Controllers\Admin\Driver\DriverController::class, 'show_add']);
        Route::post('/add', [App\Http\Controllers\Admin\Driver\DriverController::class, 'add_driver']);
        Route::get('/details/{id}', [App\Http\Controllers\Admin\Driver\DriverController::class, 'detials']);
        Route::get('/update/{id}', [App\Http\Controllers\Admin\Driver\DriverController::class, 'update_show']);
        Route::post('/update', [App\Http\Controllers\Admin\Driver\DriverController::class, 'update_driver']);
        Route::get('/availables', [App\Http\Controllers\Admin\Driver\DriverController::class, 'availables']);
        
        Route::get('/vechile/{id}', [App\Http\Controllers\Admin\Driver\DriverController::class, 'vechiles']);
        
        Route::get('/state/{id}', [App\Http\Controllers\Admin\Driver\DriverController::class, 'show_state']);
        Route::post('/state', [App\Http\Controllers\Admin\Driver\DriverController::class, 'save_state']);
        
        Route::get('/take/vechile/{id}', [App\Http\Controllers\Admin\Driver\DriverController::class, 'show_take']);
        Route::post('/take/vechile', [App\Http\Controllers\Admin\Driver\DriverController::class, 'save_take']);
        
        Route::get('/records/notes', [App\Http\Controllers\Admin\Driver\Maintenance\MaintenanceController::class, 'show']);
        Route::get('/vechile/maintenance/{id}', [App\Http\Controllers\Admin\Driver\Maintenance\MaintenanceController::class, 'current_maintenance']);

        Route::get('/pending/active/{id}', [App\Http\Controllers\Admin\Driver\DriverController::class, 'driver_active']);
        
        Route::get('/reports/show', [App\Http\Controllers\Admin\Driver\DriverController::class, 'show_report'])->middleware(['permission:driver_reports']);
        Route::get('/debits', [App\Http\Controllers\Admin\Driver\DriverController::class, 'show_debits'])->middleware(['permission:driver_debits']);
    });

    // Documents and Notes for vechile
    Route::group([
        'prefix' => 'vechile',
        'middleware' => ['permission:vechile_document_notes']
    ],function () { 
        Route::get('/documents/show/{id}', [App\Http\Controllers\Admin\Vechile\Documents\DocumentVechileController::class, 'show_document']);
        Route::get('/documents/add/{id}', [App\Http\Controllers\Admin\Vechile\Documents\DocumentVechileController::class, 'show_add']);
        Route::post('/documents/add/{id}', [App\Http\Controllers\Admin\Vechile\Documents\DocumentVechileController::class, 'add_document']);
        
        Route::get('/notes/show/{id}', [App\Http\Controllers\Admin\Vechile\Notes\NotesVechileController::class, 'show_note']);
        Route::get('/notes/add/{id}', [App\Http\Controllers\Admin\Vechile\Notes\NotesVechileController::class, 'show_add']);
        Route::post('/notes/add/{id}', [App\Http\Controllers\Admin\Vechile\Notes\NotesVechileController::class, 'add_note']);
    });

    // Documents and Notes for Driver
    Route::group([
        'prefix' => 'driver',
        'middleware' => ['permission:driver_document_notes']
    ],function () { 
        Route::get('/documents/show/{id}', [App\Http\Controllers\Admin\Driver\Documents\DocumentDriverController::class, 'show_document']);
        Route::get('/documents/add/{id}', [App\Http\Controllers\Admin\Driver\Documents\DocumentDriverController::class, 'show_add']);
        Route::post('/documents/add/{id}', [App\Http\Controllers\Admin\Driver\Documents\DocumentDriverController::class, 'add_document']);

        Route::get('/notes/show/{id}', [App\Http\Controllers\Admin\Driver\Notes\NotesDriverController::class, 'show_note']);
        Route::get('/notes/add/{id}', [App\Http\Controllers\Admin\Driver\Notes\NotesDriverController::class, 'show_add']);
        Route::post('/notes/add/{id}', [App\Http\Controllers\Admin\Driver\Notes\NotesDriverController::class, 'add_note']);
    });    
    
    // Documents and Notes for rider
    Route::group([
        'prefix' => 'rider',
        'middleware' => ['permission:rider_document_notes']
    ],function () { 
    Route::get('/documents/show/{id}', [App\Http\Controllers\Admin\Rider\Documents\DocumentRiderController::class, 'show_document']);
    Route::get('/documents/add/{id}', [App\Http\Controllers\Admin\Rider\Documents\DocumentRiderController::class, 'show_add']);
    Route::post('/documents/add/{id}', [App\Http\Controllers\Admin\Rider\Documents\DocumentRiderController::class, 'add_document']);
    
    Route::get('/notes/show/{id}', [App\Http\Controllers\Admin\Rider\Notes\NotesRiderController::class, 'show_note']);
    Route::get('/notes/add/{id}', [App\Http\Controllers\Admin\Rider\Notes\NotesRiderController::class, 'show_add']);
    Route::post('/notes/add/{id}', [App\Http\Controllers\Admin\Rider\Notes\NotesRiderController::class, 'add_note']);
    });
    
    // Documents and Notes for Driver
    Route::group([
        'prefix' => 'user',
        //'middleware' => ['permission:driver_document_notes']
    ],function () { 
        Route::get('/documents/show/{id}', [App\Http\Controllers\Admin\Users\Documents\DocumentUserController::class, 'show_document']);
        Route::get('/documents/add/{id}', [App\Http\Controllers\Admin\Users\Documents\DocumentUserController::class, 'show_add']);
        Route::post('/documents/add/{id}', [App\Http\Controllers\Admin\Users\Documents\DocumentUserController::class, 'add_document']);

        Route::get('/notes/show/{id}', [App\Http\Controllers\Admin\Users\Notes\NotesUserController::class, 'show_note']);
        Route::get('/notes/add/{id}', [App\Http\Controllers\Admin\Users\Notes\NotesUserController::class, 'show_add']);
        Route::post('/notes/add/{id}', [App\Http\Controllers\Admin\Users\Notes\NotesUserController::class, 'add_note']);
       
        Route::get('/block/{id}', [App\Http\Controllers\Admin\Users\UserController::class, 'user_block']);
        Route::get('/block/confirm/{id}', [App\Http\Controllers\Admin\Users\UserController::class, 'confirm_block']);
    }); 

    // Box for driver
    Route::group([
        'prefix' => 'driver',
        'middleware' => ['permission:driver_box']
    ],function () { 
        Route::get('/box/show/{type}/{id}', [App\Http\Controllers\Admin\Driver\Box\BoxDriverController::class, 'show_box']);
        Route::get('/box/add/{id}', [App\Http\Controllers\Admin\Driver\Box\BoxDriverController::class, 'show_add']);
        Route::post('/box/add/{id}', [App\Http\Controllers\Admin\Driver\Box\BoxDriverController::class, 'add_box']);
    });
    
    // Box for user
    Route::group([
        'prefix' => 'user',
        'middleware' => ['permission:user_manage']
    ],function () { 
        Route::get('/box/show/{type}/{id}', [App\Http\Controllers\Admin\Users\Box\BoxUserController::class, 'show_box']);
        Route::get('/box/add/{id}', [App\Http\Controllers\Admin\Users\Box\BoxUserController::class, 'show_add']);
        Route::post('/box/add/{id}', [App\Http\Controllers\Admin\Users\Box\BoxUserController::class, 'add_box']);
    });

    // Box for vechile
    Route::group([
        'prefix' => 'vechile',
        'middleware' => ['permission:vechile_box']
    ],function () { 
        Route::get('/box/show/{type}/{id}', [App\Http\Controllers\Admin\Vechile\Box\BoxVechileController::class, 'show_box']);
        Route::get('/box/add/{id}', [App\Http\Controllers\Admin\Vechile\Box\BoxVechileController::class, 'show_add']);
        Route::post('/box/add/{id}', [App\Http\Controllers\Admin\Vechile\Box\BoxVechileController::class, 'add_box']);
    });

    // Box for rider
    Route::group([
        'prefix' => 'rider',
        'middleware' => ['permission:rider_box']
    ],function () { 
        Route::get('/box/show/{type}/{id}', [App\Http\Controllers\Admin\Rider\Box\BoxRiderController::class, 'show_box']);
        Route::get('/box/add/{id}', [App\Http\Controllers\Admin\Rider\Box\BoxRiderController::class, 'show_add']);
        Route::post('/box/add/{id}', [App\Http\Controllers\Admin\Rider\Box\BoxRiderController::class, 'add_box']);
    });

    // Box for nathiraat
    Route::get('nathiraat/box/show/{type}', [App\Http\Controllers\Admin\Nathiraat\BoxNathiraatController::class, 'show_box'])->middleware(['permission:nathiraat_box']);
    Route::group([
        'prefix' => 'nathiraat',
        'middleware' => ['permission:stakeholders']
    ],function () { 

        Route::get('/stakeholders/box/show/{type}/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\Box\BoxStakeholdersController::class, 'show_box']);
        Route::get('/stakeholders/box/add/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\Box\BoxStakeholdersController::class, 'show_add']);
        Route::post('/stakeholders/box/add', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\Box\BoxStakeholdersController::class, 'add_box']);
        
        Route::get('/stakeholders/show', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\StakeholdersController::class, 'show_stakeholders']);
        Route::get('/stakeholders/add', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\StakeholdersController::class, 'add_show']);
        Route::post('/stakeholders/add', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\StakeholdersController::class, 'add_save']);
        
        Route::get('/stakeholders/detials/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\StakeholdersController::class, 'detials']);

        Route::get('stakeholders/documents/show/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\Documents\DocumentStakeholdersController::class, 'show_document']);
        Route::get('stakeholders/documents/add/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\Documents\DocumentStakeholdersController::class, 'show_add']);
        Route::post('stakeholders/documents/add/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\Documents\DocumentStakeholdersController::class, 'add_document']);

        Route::get('stakeholders/notes/show/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\Notes\NotesStakeholdersController::class, 'show_note']);
        Route::get('stakeholders/notes/add/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\Notes\NotesStakeholdersController::class, 'show_add']);
        Route::post('stakeholders/notes/add/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\Notes\NotesStakeholdersController::class, 'add_note']);
    });

    // Confirm bills
    Route::group([
        'prefix' => 'bills/waiting/confrim',
        'middleware' => ['permission:waiting_confirm']
    ],function () { 
        Route::get('/{type}', [App\Http\Controllers\Admin\Bills\ConfirmBillsController::class, 'show_bills']);
        Route::post('/', [App\Http\Controllers\Admin\Bills\ConfirmBillsController::class, 'confirm_bills']);
        Route::post('/show', [App\Http\Controllers\Admin\Bills\ConfirmBillsController::class, 'show']);
    });

    // Trusthworthy bill
    Route::group([
        'prefix' => 'bills/waiting/trustworthy',
        'middleware' => ['permission:waiting_trustworthy']
    ],function () { 
        Route::get('/{type}', [App\Http\Controllers\Admin\Bills\TrutworthyBillsController::class, 'show_bills']);
        Route::post('/', [App\Http\Controllers\Admin\Bills\TrutworthyBillsController::class, 'trustworthy_bills']);
        Route::post('/show', [App\Http\Controllers\Admin\Bills\TrutworthyBillsController::class, 'show']);
    });

    // Deposit money
    Route::group([
        'prefix' => 'bills/waiting/deposit',
        'middleware' => ['permission:waiting_deposit']
    ],function () { 
        Route::get('/{type}', [App\Http\Controllers\Admin\Bills\DepositBillsController::class, 'show_bills']);
        Route::post('/', [App\Http\Controllers\Admin\Bills\DepositBillsController::class, 'deposit_bills']);
        Route::post('/show', [App\Http\Controllers\Admin\Bills\DepositBillsController::class, 'show']);
    });

    // General box 
    Route::group([
        'prefix' => 'general/box',
        'middleware' => ['permission:general_box']
    ],function () { 
        Route::get('/', [App\Http\Controllers\Admin\Bills\GeneralBoxController::class, 'show_general_box']);
        Route::post('/show', [App\Http\Controllers\Admin\Bills\GeneralBoxController::class, 'show']);
        // Route::post('/search', [App\Http\Controllers\Admin\Bills\GeneralBoxController::class, 'search']);
    });

    Route::group([
        'prefix' => 'tasks',
        'middleware' => ['permission:user_manage']
    ],function () { 
        Route::get('/add', [App\Http\Controllers\Admin\Tasks\ManageTaskController::class, 'add_show']);
        Route::post('/add', [App\Http\Controllers\Admin\Tasks\ManageTaskController::class, 'add_task']);
        Route::get('/show/{state}', [App\Http\Controllers\Admin\Tasks\ManageTaskController::class, 'show_tasks']);
        Route::get('/show/complete/{state}', [App\Http\Controllers\Admin\Tasks\ManageTaskController::class, 'show_complete_tasks'])->middleware(['permission:complete_task']);
        Route::get('/make/uncomplete/{id}/{type}', [App\Http\Controllers\Admin\Tasks\ManageTaskController::class, 'make_uncomplate'])->middleware(['permission:complete_task']);
        
        Route::get('/user/department', [App\Http\Controllers\Admin\Tasks\ManageTaskController::class, 'user_department']);
        
    });

    Route::group([
        'prefix' => 'tasks/user',
        'middleware' => ['permission:user_own_tasks']
    ],function () { 
        Route::get('/show/{state}', [App\Http\Controllers\Admin\Tasks\UserTaskController::class, 'show_tasks']);
        Route::get('/show/complete/{state}', [App\Http\Controllers\Admin\Tasks\UserTaskController::class, 'show_complete_tasks'])->middleware(['permission:complete_task']);
        Route::get('/add/{id}/{type}', [App\Http\Controllers\Admin\Tasks\UserTaskController::class, 'show_add']);
        Route::post('/add', [App\Http\Controllers\Admin\Tasks\UserTaskController::class, 'save_tasks_result']);
    });
    
    Route::group([
        'prefix' => 'tasks',
        'middleware' => ['permission:user_manage|user_own_tasks']
    ],function () { 
        Route::get('/detials/{id}/{type}', [App\Http\Controllers\Admin\Tasks\ShowTaskController::class, 'show']);
        Route::get('/direct/{id}/{type}', [App\Http\Controllers\Admin\Tasks\ShowTaskController::class, 'direct']);
        Route::post('/direct', [App\Http\Controllers\Admin\Tasks\ShowTaskController::class, 'direct_save']);
        Route::get('recived/{id}/{type}', [App\Http\Controllers\Admin\Tasks\UserTaskController::class, 'recieved_task']);
    });
    
    Route::group([
        'prefix' => 'import/export',
        'middleware' => ['permission:import_export']
    ],function () { 
        Route::get('/show/{type}', [App\Http\Controllers\Admin\ImportsAndExport\ImportsAndExportController::class, 'show']);
        Route::get('/add', [App\Http\Controllers\Admin\ImportsAndExport\ImportsAndExportController::class, 'add']);
        Route::post('/add', [App\Http\Controllers\Admin\ImportsAndExport\ImportsAndExportController::class, 'add_save']);
        
    });

    Route::group([
        'prefix' => 'covenant',
        'middleware' => ['permission:manage_covenant']
    ],function () { 
        Route::get('/show', [App\Http\Controllers\Admin\Covenant\CovenantManageController::class, 'show']);
        Route::get('/add', [App\Http\Controllers\Admin\Covenant\CovenantManageController::class, 'show_add']);
        Route::post('/add', [App\Http\Controllers\Admin\Covenant\CovenantManageController::class, 'save_add']);
        
        Route::get('/delivery/{id}', [App\Http\Controllers\Admin\Driver\Covenant\CovenantDriverController::class, 'delivery_covenant']);
        Route::get('/delivery/add/{id}', [App\Http\Controllers\Admin\Driver\Covenant\CovenantDriverController::class, 'show_add']);
        Route::get('/select/item', [App\Http\Controllers\Admin\Driver\Covenant\CovenantDriverController::class, 'show_item']);
        Route::post('/delivery/add', [App\Http\Controllers\Admin\Driver\Covenant\CovenantDriverController::class, 'save_add']);
        
        Route::post('/delivery/user', [App\Http\Controllers\Admin\Covenant\CovenantManageController::class, 'receive_to_user']);
        Route::get('/show/note/{id}', [App\Http\Controllers\Admin\Covenant\CovenantItemManageController::class, 'show_note']);
        Route::get('/add/note/{id}', [App\Http\Controllers\Admin\Covenant\CovenantItemManageController::class, 'add_note']);
        Route::post('/add/note', [App\Http\Controllers\Admin\Covenant\CovenantItemManageController::class, 'save_note']);
        
        Route::group([
            'prefix' => 'item',
            // 'middleware' => ['permission:user_manage|user_own_tasks']
        ],function () { 
            Route::get('/show/{covenant}', [App\Http\Controllers\Admin\Covenant\CovenantItemManageController::class, 'show']);
            Route::get('/add/{id}', [App\Http\Controllers\Admin\Covenant\CovenantItemManageController::class, 'show_add']);
            Route::post('/delivery/add', [App\Http\Controllers\Admin\Covenant\CovenantItemManageController::class, 'save_add']);
        });
    }); // end covenant

    Route::group([
        'prefix' => 'warning',
        'middleware' => ['permission:warning_driver|warning_vechile|warning_user']
    ],function () { 
        Route::get('/driver/{type}', [App\Http\Controllers\Admin\Warning\DriverWarningController::class, 'show'])->middleware(['permission:warning_driver']);
        Route::get('/vechile/{type}', [App\Http\Controllers\Admin\Warning\VechileWarningController::class, 'show'])->middleware(['permission:warning_vechile']);
        Route::get('/user/{type}', [App\Http\Controllers\Admin\Warning\UserWarningController::class, 'show'])->middleware(['permission:warning_user']);
    });
    
}); //end middleware auth:admin all

 Route::get('data', [ App\Http\Controllers\AuthController::class , 'data']);