<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
* Middleware Authentication for guests.
*/
Route::group(['middleware' => 'guest'], function(){

	//login view
	Route::get('/', [
	'as' => 'login',
	'uses' => 'Auth\AuthController@login'
	]);

	//forgot password route
	Route::Get('forgotPassword', [
		'as' => 'forgotPass',
		'uses' => 'Auth\AuthController@forgot'
		]);

	//code for the password route.
	Route::Get('forgotPassword/{code}', [
		'as' => 'forgotPasswordCode',
		'uses' => 'Auth\AuthController@forgotCode'
		]);

	//activate account.
	Route::get('create/account/{code}', [
		'as' => 'activate',
		'uses' => 'Auth\AuthController@activate'
		]);
	
	/*
	* CSRF PROTECTION.
	*/
	Route::group([ 'before', 'csrf' ], function() {

		//login a user.
		Route::post('login/access', [
			'as' => 'access',
			'uses' => 'Auth\AuthController@access'
			]);

		//forgot password.
		Route::post('forgotPassword/store', [
			'as' => 'storePass',
			'uses' => 'Auth\AuthController@storePass'
			]);
	});

});

/**
* Middleware Authentication for users.
*/

Route::group(['middleware' => 'auth'], function() {

	//logout.
	Route::get('logout', [
		'as' => 'logout',
		'uses' => 'Auth\AuthController@logout'
		]);

	//Create Account.
	Route::get('create/account', [
		'as' => 'createAccount',
		'uses' => 'Auth\AuthController@create'
		]);

	//Change Password.
	Route::get('password/change/{id}', [
		'as' => 'passChange',
		'uses' => 'Auth\AuthController@passChange'
		]);

	//prologue
	Route::get('prologue', [
		'as' => 'prologue',
		'uses' => 'PrologueController@index'
		]);


	//dashboard.
	Route::get('dashboard', [
		'as' => 'dashboard',
		'uses' => 'AdminController@dashboard'
		]);

	//charts.
	Route::get('charts', [
		'as' => 'charts',
		'uses' => 'AdminController@charts'
		]);

	//tables.
	Route::get('ledgers', [
		'as' => 'ledgers',
		'uses' => 'AdminController@ledgers'
		]);

	//forms.
	Route::get('forms', [
		'as' => 'forms',
		'uses' => 'AdminController@forms'
		]);

	//User Accounts.
	Route::get('system/accounts', [
		'as' => 'sysAccounts',
		'uses' => 'AdminController@sysAccounts'
		]);

	//Trashed Accounts.
	Route::Get('trashed/accounts', [
		'as' => 'trashedAccounts',
		'uses' => 'AdminController@trashed'
		]);

	//savings updates.
	Route::get('sacco/savings/{id}', [
		'as' => 'showSavings',
		'uses' => 'AdminController@show'
		]);

	//reconcile sacco coop accounts.
	Route::get('sacco/accounts/coop/reconcile', [
		'as' => 'saccoCoopReconcile',
		'uses' => 'AdminController@coopReconcile'
		]);

	//March coop route.
	Route::get('sacco/accounts/coop/reconcile/March', [
		'as' => 'reconcileCoopMarch',
		'uses' => 'AdminController@reconcileCoopMarch'
		]);

	//April coop route.
	Route::get('sacco/accounts/coop/reconcile/April', [
		'as' => 'reconcileCoopApril',
		'uses' => 'AdminController@reconcileCoopApril'
		]);

	//reconcile sacco equity accounts.
	Route::get('sacco/accounts/equity/reconcile', [
		'as' => 'saccoEquityReconcile',
		'uses' => 'AdminController@equityReconcile'
		]);

	//March equity route.
	Route::get('sacco/accounts/equity/reconcile/March', [
		'as' => 'reconcileEquityMarch',
		'uses' => 'AdminController@reconcileEquityMarch'
		]);

	//April equity route.
	Route::get('sacco/accounts/equity/reconcile/April', [
		'as' => 'reconcileEquityApril',
		'uses' => 'AdminController@reconcileEquityApril'
		]);

	//reconcile sacco pettycash accounts.
	Route::get('sacco/accounts/pettycash/reconcile', [
		'as' => 'saccoPettycashReconcile',
		'uses' => 'AdminController@pettycashReconcile'
		]);

	//March pettycash route.
	Route::get('sacco/accounts/pettycash/reconcile/March', [
		'as' => 'reconcilePettycashMarch',
		'uses' => 'AdminController@reconcilePettycashMarch'
		]);

	//April pettycash route.
	Route::get('sacco/accounts/pettycash/reconcile/April', [
		'as' => 'reconcilePettycashApril',
		'uses' => 'AdminController@reconcilePettycashApril'
		]);

	//twelve months route.
	Route::get('sacco/accounts/reconcile/twelve', [
		'as' => 'reconcileTwelve',
		'uses' => 'AdminController@twelve'
		]);

	//grab all the data in the savings table
	Route::get('sacco/json', [
		'as' => 'savingsJson',
		'uses' => 'AdminController@savingsJson'
		]);

	//grab all the members data for search.
	Route::get('search/json', [
		'as' => 'searchJson',
		'uses' => 'AdminController@searchJson'
		]);

	//access balances for yesterday.
	Route::get('sacco/balances/yesterday', [
		'as' => 'balancesYesterday',
		'uses' => 'AdminController@balancesYesterday'
		]);

	//access balances for today.
	Route::get('sacco/balances/today', [
		'as' => 'balancesToday',
		'uses' => 'AdminController@balancesToday'
		]);


	//Chart of Accounts.
	Route::Get('sacco/chart/accounts', [
		'as' => 'chartAccounts',
		'uses' => 'AdminController@chartAccounts'
		]);

	//Chart of Accounts.
	Route::Get('sacco/create/chart/accounts', [
		'as' => 'createChartAccounts',
		'uses' => 'AdminController@createChartAccounts'
		]);

	//Co-oop bank Cash book
	Route::get('sacco/coop/cash/book', [
		'as' => 'coopCashbook',
		'uses' => 'AdminController@coopCashbook'
		]);

	//equity bank Cash book
	Route::get('sacco/equity/cash/book', [
		'as' => 'equityCashbook',
		'uses' => 'AdminController@equityCashbook'
		]);

	//Petty cash
	Route::get('sacco/petty/cash/book', [
		'as' => 'pettyCashbook',
		'uses' => 'AdminController@pettyCashbook'
		]);

	//Create Cash book
	Route::get('sacco/create/cashbook', [
		'as' => 'createCashbook',
		'uses' => 'AdminController@createCashbook'
		]);

	//Profit and Loss
	Route::get('sacco/profit/loss', [
		'as' => 'profitLoss',
		'uses' => 'AdminController@profitLoss'
		]);

	//Balance Sheet
	Route::get('sacco/balance/sheet', [
		'as' => 'balanceSheet',
		'uses' => 'AdminController@balanceSheet'
		]);

	//display all active loans in tabular format.
	Route::Get('ledger/members/active', [
		'as' => 'activeMembersLedger',
		'uses' => 'AdminController@activeLedger'
		]);

	//display individual loans and their guarantees.
	Route::get('ledger/loan/guarantors/{id}', [
		'as' => 'loanGuarantors',
		'uses' => 'AdminController@loanGuarantors'
		]);

	//display all guarantors in tabular format.
	Route::Get('ledger/members/guarantors', [
		'as' => 'guarantorsMembersLedger',
		'uses' => 'AdminController@guarantorsLedger'
		]);

	//display all member deposits in a ledger.
	Route::Get('ledger/members/deposits', [
		'as' => 'depositsMembersLedger',
		'uses' => 'AdminController@depositsLedger'
		]);

	//display all Defaulters in tabular format.
	Route::Get('ledger/members/defaulters', [
		'as' => 'defaultersMembersLedger',
		'uses' => 'AdminController@defaultersLedger'
		]);

	//display all loan disbursements.
	Route::get('ledger/loan/disbursements', [
		'as' => 'loanDisburseLedger',
		'uses' => 'AdminController@loanDisburseLedger'
		]);

	//display all loan reimbursements.
	Route::get('ledger/loan/reimbursements', [
		'as' => 'loanReimburseLedger',
		'uses' => 'AdminController@loanReimburseLedger'
		]);

	//Trial Balance report.
	Route::Get('sacco/report/trialBalance', [
		'as' => 'trialBalance',
		'uses' => 'AdminController@trialBalance'
		]);


	//PDF Members.
	Route::Get('PDF/members', [
		'as' => 'pdfMembers',
		'uses' => 'AdminController@pdfMembers'
		]);

	//PDF Co - op Cashbook.
	Route::Get('PDF/coopCashbook', [
		'as' => 'pdfcoopCashbook',
		'uses' => 'AdminController@pdfcoopCashbook'
		]);

	//PDF equity Cashbook.
	Route::Get('PDF/equityCashbook', [
		'as' => 'pdfequityCashbook',
		'uses' => 'AdminController@pdfequityCashbook'
		]);

	//PDF pettycash Cashbook.
	Route::Get('PDF/pettyCashbook', [
		'as' => 'pdfpettyCashbook',
		'uses' => 'AdminController@pdfpettyCashbook'
		]);

	//PDF profit and loss.
	Route::Get('PDF/profitLoss', [
		'as' => 'pdfProfitLoss',
		'uses' => 'AdminController@pdfProfitLoss'
		]);

	//PDF Balance Sheet
	Route::get('PDF/balance/sheet', [
		'as' => 'pdfBalanceSheet',
		'uses' => 'AdminController@pdfBalanceSheet'
		]);

	//PDF Trial Balance.
	Route::Get('PDF/trialBalance', [
		'as' => 'pdfTrialBalance',
		'uses' => 'AdminController@pdfTrialBalance'
		]);

	//PDF Active Loans.
	Route::Get('PDF/activeLoans', [
		'as' => 'pdfActiveLoans',
		'uses' => 'AdminController@pdfActiveLoans'
		]);


	//PDF Loan Guarantors.
	Route::Get('PDF/loanGuarantors/{id}', [
		'as' => 'pdfLoanGuarantors',
		'uses' => 'AdminController@pdfLoanGuarantors'
		]);

	//PDF Guarantors.
	Route::Get('PDF/guarantors', [
		'as' => 'pdfGuarantors',
		'uses' => 'AdminController@pdfGuarantors'
		]);

	//PDF Deposits.
	Route::Get('PDF/deposits', [
		'as' => 'pdfDeposits',
		'uses' => 'AdminController@pdfDeposits'
		]);

	//PDF Loan Defaulters.
	Route::Get('PDF/loanDefaulters', [
		'as' => 'pdfLoanDefaulters',
		'uses' => 'AdminController@pdfLoanDefaulters'
		]);

	//PDF loan disbursements.
	Route::get('PDF/loanDisbursements', [
		'as' => 'pdfLoanDisburse',
		'uses' => 'AdminController@pdfLoanDisburse'
		]);

	//PDF yesterday balance.
	Route::get('PDF/yesterdayBalance', [
		'as' => 'pdfYesterdayBalance',
		'uses' => 'AdminController@pdfYesterdayBalance'
		]);

	//PDF today balance.
	Route::get('PDF/todayBalance', [
		'as' => 'pdfTodayBalance',
		'uses' => 'AdminController@pdfTodayBalance'
		]);

	//route to handle chart account statements.
	Route::get('chart/of/accounts/statement/{id}', [
		'as' => 'chartStatement',
		'uses' => 'AdminController@chartStatement'
		]);

	//route to handle subchart account statements.
	Route::get('subchart/of/accounts/statement/{id}', [
		'as' => 'subchartStatement',
		'uses' => 'AdminController@subchartStatement'
		]);

	//jornals.
	Route::get('sacco/journals', [
		'as' => 'journals',
		'uses' => 'AdminController@journals'
		]);

	//create jornals.
	Route::get('sacco/create/journals', [
		'as' => 'createJournals',
		'uses' => 'AdminController@createJournals'
		]);

	//edit/update jornals.
	Route::get('sacco/edit/journals/{id}', [
		'as' => 'editJournals',
		'uses' => 'AdminController@editJournals'
		]);

	/*
	* Member Accounts.
	*/
	Route::get('member/account', [
		'as' => 'memberAccount',
		'uses' => 'MemberController@index'
		]);

	//create member accounts.
	Route::get('create/member', [
		'as' => 'createMember',
		'uses' => 'MemberController@create'
		]);

	//show trashed members.
	Route::get('trashed/members', [
		'as' => 'trashedMembers',
		'uses' => 'MemberController@trashed'
		]);

	//show fixed account holders members.
	Route::get('fixed/account', [
		'as' => 'fixedAccount',
		'uses' => 'MemberController@fixed'
		]);

	//show savings account holders members.
	Route::get('savings/account', [
		'as' => 'savingsAccount',
		'uses' => 'MemberController@savings'
		]);

	//show asset account holders members.
	Route::get('asset/account', [
		'as' => 'assetAccount',
		'uses' => 'MemberController@asset'
		]);

	//account's details.
	Route::Get('member/account/edit/{id}', [
		'as' => 'accountEdit',
		'uses' => 'MemberController@edit'
		]);	

	//members statement.
	Route::Get('member/statement/{id}', [
		'as' => 'memberStatement',
		'uses' => 'MemberController@memberStatement'
		]);	

	//pdf member statement
	Route::get('pdf/member/statement/{id}', [
		'as' => 'pdfmemberStatement',
		'uses' => 'MemberController@pdfmemberStatement'
		]);

	//edit member's account.
	Route::get('member/account/money/edit/{id}', [
		'as' => 'moneyEdit',
		'uses' => 'MemberController@money'
		]);

	//member accounts.
	Route::get('members/accounts/reconcile', [
		'as' => 'accountsReconcile',
		'uses' => 'MemberController@reconcileAccounts'
		]);

	//reconcile member accounts for 3 months
	Route::get('members/accounts/reconcile/three', [
		'as' => 'reconcileAccountsThree',
		'uses' => 'MemberController@three'
		]);

	//reconcile member accounts for 6 months
	Route::get('members/accounts/reconcile/six', [
		'as' => 'reconcileAccountsSix',
		'uses' => 'MemberController@six'
		]);

	//reconcile member accounts for 12 months
	Route::get('members/accounts/reconcile/twelve', [
		'as' => 'reconcileAccountsTwelve',
		'uses' => 'MemberController@twelve'
		]);

	//grab all the members data for presentation.
	Route::get('members/json', [
		'as' => 'membersJson',
		'uses' => 'MemberController@membersJson'
		]);


	/**
	** Loans
	**/
	Route::get('member/loans', [
		'as' => 'memberLoans',
		'uses' => 'LoanController@index'
		]);

	//route for the loan calculator.
	Route::get('loan/calculator', [
		'as' => 'loanCalculator',
		'uses' => 'LoanController@calculator'
		]);

	//create loans.
	Route::get('create/loans/{id}', [
		'as' => 'createLoan',
		'uses' => 'LoanController@create'
		]);

	//show a single member's loans.
	Route::get('loans/member/{id}', [
		'as' => 'loansMember',
		'uses' => 'LoanController@loansMember'
		]);

	//edit loans.
	Route::get('show/loan/{id}', [
		'as' => 'showLoan',
		'uses' => 'LoanController@show'
		]);

	//create loan disbursements.
	Route::get('loan/disbursement/{id}/create', [
		'as' => 'createDisbursement',
		'uses' => 'LoanController@createDisbursement'
		]);

	//loan disbursements.
	Route::get('loan/disbursement/{id}', [
		'as' => 'loanDisburse',
		'uses' => 'LoanController@loanDisburse'
		]);

	//edit disbursements.
	Route::get('loan/disbursement/{id}/edit', [
		'as' => 'editDisburse',
		'uses' => 'LoanController@editDisburse'
		]);

	//display all matured loans.
	Route::get('matured/loans', [
		'as' => 'maturedLoans',
		'uses' => 'LoanController@matured'
		]);

	//display all matured loans.
	Route::get('approved/loans', [
		'as' => 'approvedLoans',
		'uses' => 'LoanController@approved'
		]);

	//display institution based matured loans.
	Route::get('corporate/matured/loans', [
		'as' => 'mouMaturedLoans',
		'uses' => 'LoanController@mouMatured'
		]);

	//display default loans.
	Route::get('default/loans', [
		'as' => 'defaultLoans',
		'uses' => 'LoanController@defaults'
		]);

	//display loans that installments have to be paid today.
	Route::Get('pay/installments/today', [
		'as' => 'payToday',
		'uses' => 'LoanController@pay'
		]);

	//update the installment details.
	Route::get('installment/updates/{id}', [
		'as' => 'installmentUpdates',
		'uses' => 'LoanController@installmentUpdates'
		]);

	//grab all the loans data for presentation.
	Route::get('loans/json', [
		'as' => 'loansJson',
		'uses' => 'LoanController@loansJson'
		]);

	//display loan defaulters.
	Route::Get('loans/default', [
		'as' => 'loanDefaulters',
		'uses' => 'LoanController@defaulters'
		]);

	//analyse the system using JS for loan defaulters.
	Route::get('loan/analysis/{id}/defaulters', [
		'as' => 'analyseLoanDefaulters',
		'uses' => 'LoanController@analyseLoanDefaulters'
		]);

	/*
	* CSRF PROTECTION.
	*/
	Route::group([ 'before', 'csrf' ], function() {

		//save the account details in a session.
		Route::post('save/account', [
			'as' => 'saveAccount',
			'uses' => 'Auth\AuthController@save'
			]);

		//submit account details
		Route::post('create/account/post', [
			'as' => 'storeAccount',
			'uses' => 'Auth\AuthController@storeAccount'
			]);

		//store new password.
		Route::post('password/change/{id}/store', [
			'as' => 'storePassword',
			'uses' => 'Auth\AuthController@storePassword'
			]);

		//update user roles.
		Route::post('assign/roles/store', [
			'as' => 'storeRoles',
			'uses' => 'AdminController@storeRoles'
			]);

		//soft delete or trash users.
		Route::delete('trash/account/{id}', [
			'as' => 'trashAccount',
			'uses' => 'AdminController@trash'
			]);

		//Restore trashed users.
		Route::post('restore/accounts', [
			'as' => 'restoreAccounts',
			'uses' => 'AdminController@restoreAll'
			]);

		//Restore a single trashed user.
		Route::post('restore/account/{id}', [
			'as' => 'restoreAccount',
			'uses' => 'AdminController@restore'
			]);

		//Route to insert sacco savings.
		Route::post('sacco/savings', [
			'as' => 'saccoSavings',
			'uses' => 'AdminController@savings'
			]);

		//Route to store sacco savings updates.
		Route::post('sacco/savings/updates', [
			'as' => 'savingsUpdates',
			'uses' => 'AdminController@updates'
			]);

		//check reconciliation of sacco accounts.
		Route::post('sacco/accounts/reconciled', [
			'as' =>'saccoReconciled',
			'uses' => 'AdminController@reconciled'
			]);

		//create chart of accounts.
		Route::post('sacco/create/chart/accounts/store', [
			'as' => 'storeCharts',
			'uses' => 'AdminController@storeCharts'
			]);

		//create sub chart of accounts.
		Route::post('sacco/chart/account/sub/store', [
			'as' => 'storeSubCharts',
			'uses' => 'AdminController@storeSubCharts'
			]);

		//store journals.
		Route::post('sacco/create/journals/store', [
			'as' => 'storeJournals',
			'uses' => 'AdminController@storeJournals'
			]);

		//update journal.
		Route::post('sacco/update/journal/{id}', [
			'as' => 'updateJournal',
			'uses' => 'AdminController@updateJournal'
			]);

		//Route to save new members.
		Route::post('save/member', [
			'as' => 'saveMember',
			'uses' => 'MemberController@save'
			]);

		//Route to store new members.
		Route::post('store/member', [
			'as' => 'storeMember',
			'uses' => 'MemberController@store'
			]);

		//Route to trash members.
		Route::delete('trash/member/{id}', [
			'as' => 'trashMember',
			'uses' => 'MemberController@trashMember'
			]);

		//Route to restore a single member's account.
		Route::post('restore/member/{id}', [
			'as' => 'restoreMember',
			'uses' => 'MemberController@restore'
			]);

		//Route to restore all members' accounts.
		Route::post('restoreAll/members', [
			'as' => 'restoreAllMembers',
			'uses' => 'MemberController@restoreAll'
			]);

		//Route to update account details.
		Route::post('member/account/moneys/{id}', [
			'as' => 'moneyUpdate',
			'uses' => 'MemberController@moneys'
			]);

		//Route to update member account details.
		Route::post('member/account/update/{id}', [
			'as' => 'memberUpdate',
			'uses' => 'MemberController@update'
			]);

		//store member's moneys.
		Route::post('member/account/money/store', [
			'as' => 'moneyStore',
			'uses' => 'MemberController@moneyStore'
			]);

		//store loans.
		Route::post('member/loans/store', [
			'as' => 'loanStore',
			'uses' => 'LoanController@store'
			]);

		//update loans.
		Route::post('member/loan/update/{id}', [
			'as' => 'loanUpdate',
			'uses' => 'LoanController@update'
			]);

		//process the loan.
		Route::post('member/loan/process/{id}', [
			'as' => 'loanProcess',
			'uses' => 'LoanController@process'
			]);

		//store the installments.
		Route::post('member/maturity/store', [
			'as' => 'storeInstallments',
			'uses' => 'LoanController@storeInstallments'
			]);

		//store Defaulters installments.
		Route::post('member/maturity/default/store', [
			'as' => 'maturityStorage',
			'uses' => 'LoanController@storeDefaultInstallments'
			]);

		//update installments.
		Route::post('installment/updates/store/{id}', [
			'as' => 'installmentUpdatesStore',
			'uses' => 'LoanController@installmentUpdatesStore'
			]);

		//corporate matured loans installments.
		Route::post('corporate/matured/loans/store', [
			'as' => 'storeCorporateLoans',
			'uses' => 'LoanController@storeCorporateLoans'
			]);

		//loan disbursement
		Route::post('loan/disbursement/{id}', [
			'as' => 'storeDisbursement',
			'uses' => 'LoanController@storeDisbursement'
			]);

		//commit updates for loan disbursements.
		Route::post('loan/disbursement/{id}/update', [
			'as' => 'updateDisbursement',
			'uses' => 'LoanController@updateDisbursement'
			]);
	});
});