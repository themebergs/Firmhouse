<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('admin');
Route::get('/report', 'ReportController@index')->name('expense.report');
Route::post('/expenseReport/CategoryFilter', 'ReportController@filter')->name('expense.filter');
Route::post('/expenseReport/SectorFilter', 'ReportController@sectorfilter')->name('expense.sectorfilter');

Route::get('/income_report', 'IncomeReportController@index')->name('income.report');
Route::post('/incomeReport/CategoryFilter', 'IncomeReportController@filter')->name('income.filter');
Route::post('/incomeReport/SectorFilter', 'IncomeReportController@sectorfilter')->name('income.sectorfilter');

Route::resource('/profile', 'UserController');
    
Route::group(['middleware' => 'Admin'], function () {

    
    Route::resource('all_admin', 'AdminController');

    Route::get('all_users', 'AdminController@user')->name('user');
    Route::get('investors', 'AdminController@investors')->name('user');

    Route::get('/users/{id}', 'RoleController@show')->name('user.show');

    Route::get('/salary', 'SalaryController@index')->name('salary');
    Route::post('/salary/store', 'SalaryController@store')->name('salary.store');
    Route::get('/salary/user', 'SalaryController@finduser')->name('finduser');
    Route::get('/salary/user/{id}', 'SalaryController@show')->name('salary.show');
    Route::get('/salary/filter', 'SalaryController@filter')->name('salary.filter');
    Route::get('/salary_set/{id}', 'SalaryController@set')->name('salary.set');

    Route::resource('/expense', 'ExpenseController');
    Route::get('/expense/{id}', 'ExpenseController@show')->name('expense.show');
    Route::get('/find_expense_sub_category/{id}', 'ExpenseController@find')->name('expense.subcategory');
    Route::post('/expense_update', 'ExpenseController@update')->name('expense.update');
    Route::get('/expense_history', 'ExpenseController@history')->name('expense.history');
    Route::get('/expense_del/{id}', 'ExpenseController@delete')->name('expense.destroy');


    Route::get('/investment', 'InvestmentController@all')->name('investment');
    Route::post('/investment_update', 'InvestmentController@update')->name('update.investment');
    Route::get('/investment/add', 'InvestmentController@index')->name('investment.add');
    Route::post('/investment/store', 'InvestmentController@store')->name('investment.store');
    Route::get('/investment/user', 'InvestmentController@finduser')->name('investment.finduser');
    Route::get('/investment/user/{id}', 'InvestmentController@show')->name('investment.show');
    Route::get('/investment/filter', 'InvestmentController@filter')->name('investment.filter');
    Route::get('/investment_del/{id}', 'InvestmentController@destroy');

    Route::get('/income/{id}', 'IncomeController@index')->name('income');
    Route::post('/income/store', 'IncomeController@store')->name('income.store');
    Route::post('/income_update', 'IncomeController@update')->name('update.income');
    Route::get('/income_del/{id}', 'IncomeController@destroy');
    Route::get('/income/filter', 'IncomeController@filter')->name('income.filter');
    Route::get('/income_sectors', 'IncomeController@sectors')->name('income.sectors');
    Route::post('/IncomeSectorStore', 'IncomeController@IncomeSectorStore')->name('income.sectors_store');
    Route::get('/find_income_sub_category/{id}', 'IncomeController@find')->name('income.subcategory');


    Route::get('/business', 'BusinessController@index');
    Route::post('/register', 'UserController@store')->name('admin.register');
    Route::get('/member/{id}', 'AdminController@edit')->name('all_admin.edit');
    Route::put('/member/role/{id}', 'AdminController@update')->name('role.update');
    Route::get('/search', 'SearchController@search')->name('admin.search');
    Route::resource('/sectors', 'SectorController');
    Route::resource('/categories', 'CategoryController');
    Route::resource('/subcategories', 'SubCategoryController');
    Route::resource('/employee_roles', 'RoleController');
    Route::resource('/default_salary', 'DefaultSalaryController');
    Route::resource('/loan', 'LoanController');
    Route::get('/expense_all/filter', 'ExpenseController@filter');

    Route::group(['middleware' => 'SuperAdmin'], function () {

    });
});