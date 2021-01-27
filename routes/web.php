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
    return view('welcome');
});
Route::get('cache-clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    //Artisan::call('eth:transaction');
    //Artisan::call('btc:transaction');
    return 'cleared';
});
Route::post('login','AdminLoginController@login');
Route::get('logout', 'AdminLoginController@logout');
Route::get('testmail', 'CronController@testmail');
Route::get('blastcoin', 'CronController@blastcoin');
// Cron 
Route::get('addresscreate', 'CronController@AddressGenerate');
Route::get('admin_btc', 'CronController@adminBtcTransactions');
Route::get('admin_eth', 'CronController@adminEthTransactions');
Route::get('admin_xrp', 'CronController@adminXrpTransactions');
Route::get('send_btc', 'CronController@sendBtcToAdmin');
Route::get('send_eth', 'CronController@sendEthToAdmin');
Route::get('send_ltc', 'CronController@sendLtcToAdmin');
Route::get('generateethtoken', 'CronController@generateethtoken');
Route::group([ 'middleware' => ['admin'], 'prefix'=>'admin', 'namespace' =>'Admin' ], function () 
{
	Route::get('dashboard', 'DashboardController@index');
	//Users
	Route::group(['prefix'=>'users'], function(){	
		Route::get('/', 'UserController@index')->name('users.index');
		Route::get('/edit/{id}', 'UserController@edit')->name('users.edit');
		//mail send
		Route::get('/show/{id}', 'MailController@show')->name('mails.show');
		Route::post('single_mail_submit', 'MailController@single_mail_submit')->name('mails.single_mail_submit');
		//Export Excell
		Route::get('excel/{id}', 'ExportexcelController@show')->name('excel.show');
		Route::get('export_excel', 'ExportexcelController@export_excel');
		Route::get('induvidual-export-excel/{id}/{type}', 'ExportexcelController@induvidual_export_excel')->name('excel.export');
	});
	Route::post('update_user', 'UserController@update');
	Route::get('users_wallet/{id}', 'UserController@userWallet');
	Route::post('update_wallet', 'UserController@updateWallet');
	Route::get('users/search', 'UserController@userSearchList');
	Route::post('users/search', 'UserController@userSearchList');
	Route::post('user_status', 'UserController@userStatus');




	Route::get('deactive_users', 'UserController@deactiveUser');
	Route::get('today_users', 'UserController@todayUser');
	Route::get('kyc_request_users', 'UserController@kyc_RequestUser');
	Route::get('users_activity', 'UserController@userActivity');
	//Admin Wallet
	Route::get('wallet', 'AdminWalletController@index');
	//Trade
	Route::get('user_trade/', 'TradesController@userTrade');
	Route::post('user_trade_search/', 'TradesController@userTradeSearch');
	//Admin Deposit 
	Route::get('btc_deposithistory', 'DepositController@adminBtcDeposit');
	Route::get('eth_deposithistory', 'DepositController@adminEthDeposit');
	Route::get('xrp_deposithistory', 'DepositController@adminXrpDeposit');
	Route::get('ltc_deposithistory', 'DepositController@adminLtcDeposit');
	Route::get('jadax_deposithistory', 'DepositController@adminJadaxDeposit');
	Route::get('linear_deposithistory', 'DepositController@adminLinearDeposit');
	Route::get('usd_deposithistory', 'DepositController@adminUsdDeposit');
	//Admin Withdraw
	Route::get('btc_withdrawhistory', 'WithdrawController@adminBtcWithdraw');
	Route::get('eth_withdrawhistory', 'WithdrawController@adminEthWithdraw');
	Route::get('ltc_withdrawhistory', 'WithdrawController@adminLtcWithdraw');
	Route::get('xrp_withdrawhistory', 'WithdrawController@adminXrpWithdraw');
	Route::get('linear_withdrawhistory', 'WithdrawController@adminLinearWithdraw');
	Route::get('jadax_withdrawhistory', 'WithdrawController@adminJadaxWithdraw');
	Route::get('usd_withdrawhistory', 'WithdrawController@adminUsdWithdraw');
	// user transaction search
	Route::post('coin_his_search', 'UserHistoryController@depositHistorySearch');
	//User History 
	Route::get('user_history', 'UserHistoryController@userHistory');
	Route::post('user_history_search', 'UserHistoryController@userHistorySearch');
	Route::post('user_history_update', 'UserHistoryController@userHistoryUpdate');
	Route::post('/selltrade_his_search', 'UserController@sellTradeHistorySearch')->name('ajaxtradehistroysell');
	Route::post('/buytrade_his_search', 'UserController@buyTradeHistorySearch')->name('ajaxtradehistroybuy');
	//Kyc 
  	Route::get('kyc', 'KycController@index');
	Route::get('kycview/{id}', 'KycController@kycview');
	Route::post('kycupdate', 'KycController@kycUpdate');
	// Commission start
	// Route::get('commission', 'CommissionController@index');
	// Route::get('commissionsettings/{id}', 'CommissionController@edit');
	// Route::post('commissionupdate', 'CommissionController@commissionUpdate');
	Route::group(['prefix'=>'commission-settings'], function(){
		Route::get('/', 'CommissionController@index')->name('commission_settings.index'); 
		Route::get('/create', 'CommissionController@create')->name('commission_settings.create');
		Route::post('/', 'CommissionController@store')->name('commission_settings.store');
		Route::get('{id}/edit', 'CommissionController@edit')->name('commission_settings.edit');
		Route::post('/update', 'CommissionController@update')->name('commission_settings.update');
		Route::get('{id}', 'CommissionController@destroy')->name('commission_settings.destroy');
	});
	// Commission end
	//Support
	Route::get('support', 'SupportController@index');
	Route::get('/support/{id}', 'SupportController@supportdetails');
	Route::post('addMessage','SupportController@addMessage');
	//Bank
	Route::get('bank', 'BankController@index');
	Route::get('edit_bank/{id}', 'BankController@editBank');
	Route::post('updateBank', 'BankController@updateBank');
	//Site Settings
	Route::get('logo', 'SettingsController@logo');
	Route::post('update_logo', 'SettingsController@updateLogo');
	Route::get('token', 'SettingsController@token');
	Route::get('add_token', 'SettingsController@addToken');
	Route::post('save_token', 'SettingsController@saveToken');
	Route::get('edit_token/{id}', 'SettingsController@editToken');
	Route::post('update_token', 'SettingsController@updateToken');
	Route::get('2fa_settings', 'SettingsController@twoFA');
	Route::get('add_twofa', 'SettingsController@addtwoFA');
	Route::post('save_twofaoption', 'SettingsController@savetwofa');
	Route::get('edit_twofa/{id}', 'SettingsController@edittwofa');
	Route::post('update_twofa', 'SettingsController@updateTwofa');
	Route::get('tc', 'SettingsController@tc');
	Route::post('update_terms', 'SettingsController@update_terms');
	Route::get('privacy', 'SettingsController@privacy');
	Route::post('update_privacy', 'SettingsController@updatePrivacy');
	Route::get('aboutus', 'SettingsController@aboutus');
	Route::post('update_about', 'SettingsController@updateAbout');
	Route::get('aboutus', 'SettingsController@aboutus');
	Route::post('update_about', 'SettingsController@updateAbout');
	Route::get('benefits', 'SettingsController@benefits');
	Route::post('benefits_update', 'SettingsController@benefits_settings');
	Route::get('features', 'SettingsController@features');
	Route::post('features_update', 'SettingsController@features_settings');
	Route::get('faq', 'SettingsController@faq'); 
	Route::get('/faq_add', 'SettingsController@faq_add');
	Route::post('/faq_save', 'SettingsController@faq_save');
	Route::get('/faq_edit/{id}', 'SettingsController@faq_edit');
	Route::post('/faq_update', 'SettingsController@faq_update');
	// news start
	Route::group(['prefix'=>'news'], function(){
		Route::get('/', 'NewsController@index')->name('news.index'); 
		Route::get('/add', 'NewsController@add')->name('news.add');
		Route::post('/', 'NewsController@store')->name('news.store');
		Route::get('{id}/edit', 'NewsController@edit')->name('news.edit');
		Route::post('/update', 'NewsController@update')->name('news.update');
		Route::get('{id}', 'NewsController@destroy')->name('news.destroy');
	});
	// news end
	// project advisor
	Route::get('project_advisor', 'AdvisorController@index'); 
	Route::get('project_advisor_add', 'AdvisorController@new_add');
	Route::post('project_advisor_save', 'AdvisorController@new_save');
	Route::get('project_advisor_edit/{id}', 'AdvisorController@edit');
	Route::post('project_advisor_update', 'AdvisorController@update');
	Route::get('project_advisor_delete/{id}', 'ExecutiveController@new_delete');
	// Executive team
	Route::get('executive_team', 'ExecutiveController@index'); 
	Route::get('executive_team_add', 'ExecutiveController@new_add');
	Route::post('executive_team_save', 'ExecutiveController@new_save');
	Route::get('executive_team_edit/{id}', 'ExecutiveController@edit');
	Route::post('executive_team_update', 'ExecutiveController@update');
	Route::get('executive_team_delete/{id}', 'ExecutiveController@new_delete');
	// Our services
	// Route::get('executive_team', 'ExecutiveController@index'); 
	// Route::get('executive_team_add', 'ExecutiveController@new_add');
	// Route::post('executive_team_save', 'ExecutiveController@new_save');
	// Route::get('executive_team_edit/{id}', 'ExecutiveController@edit');
	// Route::post('executive_team_update', 'ExecutiveController@update');
	// Route::get('executive_team_delete/{id}', 'ExecutiveController@new_delete');
	// Road map
	Route::get('roadmap', 'RoadmapController@index'); 
	Route::get('executive_team_add', 'RoadmapController@new_add');
	Route::get('roadmap/{id}', 'RoadmapController@edit');
	Route::post('roadmap_update', 'RoadmapController@update');
	Route::get('executive_team_delete/{id}', 'RoadmapController@new_delete');
	// partners
	Route::get('partners', 'PartnersController@index'); 
	Route::get('partners/{id}', 'PartnersController@edit');
	Route::post('partners_update', 'PartnersController@update');
	// upcomming
	Route::get('upcomming', 'UpcomeController@index'); 
	Route::get('upcomming/{id}', 'UpcomeController@edit');
	Route::post('upcomming_update', 'UpcomeController@update');
	Route::get('socialmedia', 'SettingsController@socialmedia'); 
	Route::post('save_social_media', 'SettingsController@saveSocialMedia');
	Route::get('userpanel_settings', 'SettingsController@userpanelSettings'); 
	Route::post('save_userpanel_settings', 'SettingsController@saveUserpanelSettings');
	Route::get('addsubadmin', 'SubadminController@addsubadmin');
	Route::post('subadmin_save', 'SubadminController@subadmin_save');
	Route::get('subadmin_delete/{id}', 'SubadminController@subadminDelete');	
	
	//get individual user deposit amount details
	Route::get('/users/userdepositamt', 'UserController@userDepostAmount');	
	Route::group(['prefix'=>'under-maintenance'], function(){
		Route::get('/', 'MaintenanceController@edit')->name('under_maintenance.edit');
		Route::post('/update/{id?}', 'MaintenanceController@update')->name('under_maintenance.update');
	});
	// subadmins start
	Route::group(['prefix'=>'subadmins'], function(){
		Route::get('/', 'SubadminController@index')->name('subadmins.index'); 
		Route::get('/add', 'SubadminController@add')->name('subadmins.add');
		Route::post('/', 'SubadminController@store')->name('subadmins.store');
		Route::get('{id}/edit', 'SubadminController@edit')->name('subadmins.edit');
		Route::post('/update', 'SubadminController@update')->name('subadmins.update');
		Route::get('{id}', 'SubadminController@destroy')->name('subadmins.destroy');
	});
	// subadmins end
	// Security Settings start
	Route::group(['prefix'=>'security-settings'], function(){
		Route::get('/', 'SecuritysettingController@edit')->name('security_settings.edit');
		Route::post('change-email', 'SecuritysettingController@change_email')->name('security_settings.change_email');
		Route::post('change-password', 'SecuritysettingController@change_password')->name('security_settings.change_password');
	});
	// Security Settings end
	Route::get('market', 'MarketController@index')->name('market.index');
});