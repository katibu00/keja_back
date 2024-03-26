<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BuyDataController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DataPlansController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonnifyController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PlanProviderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WalletController;
use App\Models\ReservedAccount;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
   
    if(auth()->check()){
        if(Auth::user()->user_type == 'regular'){
            return redirect()->route('regular.home');
        }
        if(Auth::user()->user_type == 'regular'){
            return redirect()->route('regular.home');
        }
    }
   
    return view('auth.login');
});


Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.forgot');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.send.reset.link');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');



Route::group(['middleware' => ['auth', 'regular']], function () {
    Route::get('/user/home', [HomeController::class, 'regular'])->name('regular.home');
});
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin/home', [HomeController::class, 'admin'])->name('admin.home');
});


Route::post('/get-transfers',  [MonnifyController::class, 'getTransfers']);

Route::post('/webhook',  [MonnifyController::class, 'getTransfers']);

Route::get('/add_money', function(){
    $query = ReservedAccount::where('customer_email', auth()->user()->email)->first();

    if ($query) {
        $accounts = json_decode($query->accounts, true);
    } else {
        $accounts = [];
    }
    return view('pages.add_money',compact('accounts'));
})->name('add_money');



Route::group(['prefix' => 'data_plans', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/index', [DataPlansController::class, 'index'])->name('data_plans.index');
    Route::post('/store', [DataPlansController::class, 'store'])->name('data_plans.store');
    Route::get('/edit/{id}', [DataPlansController::class, 'edit'])->name('stock.edit');
    Route::get('/copy/{id}', [DataPlansController::class, 'copyIndex'])->name('inventory.copy');
    Route::post('/update/{id}', [DataPlansController::class, 'update'])->name('stock.update');
    Route::post('/copy', [DataPlansController::class, 'copyStore'])->name('stock.copy');
    Route::post('/delete', [DataPlansController::class, 'delete'])->name('stock.delete');
    Route::post('/fetch-stocks', [DataPlansController::class, 'fetchStocks'])->name('fetch-stocks');
    Route::post('/search-stocks', [DataPlansController::class, 'Search'])->name('search-stocks');

});
Route::group(['prefix' => 'beneficiaries', 'middleware' => ['auth', 'regular']], function () {
    Route::post('/store', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('/', [ContactController::class, 'index'])->name('contacts.index');
    Route::post('/update', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('/delete', [ContactController::class, 'delete'])->name('contacts.destroy');
});



Route::group(['middleware' => ['auth', 'regular']], function () {

    Route::post('/fetch-data-plans', [DataPlansController::class, 'fetchPlans'])->name('fetch-data-plans');
    Route::post('/buy-data-plans', [BuyDataController::class, 'buyData'])->name('buy-data-plans');

    Route::get('/transactions', [TransactionsController::class, 'index'])->name('transactions.index');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');


});


Route::group(['prefix' => 'settings', 'middleware' => ['auth', 'admin']], function () {

    Route::get('/openai_key', [SettingsController::class, 'openaiKeys'])->name('openai_key');
    Route::post('/openai_key', [SettingsController::class, 'saveOpenai']);

    Route::get('/brevo_key', [SettingsController::class, 'brevoKeys'])->name('brevo_key');
    Route::post('/brevo_key', [SettingsController::class, 'saveBrevo']);

    Route::get('/paystack_key', [SettingsController::class, 'paystackKeys'])->name('paystack_key');
    Route::post('/paystack_key', [SettingsController::class, 'savePaystack']);

    Route::get('/monnify_api_key', [SettingsController::class, 'monnifyKeys'])->name('monnify_api_key');
    Route::post('/monnify_api_key', [SettingsController::class, 'saveMonnify']);

    Route::get('/charges', [SettingsController::class, 'charges'])->name('charges');
    Route::post('/charges', [SettingsController::class, 'saveCharges']);


    Route::get('/pop_up_notification', [SettingsController::class, 'popup'])->name('pop_up_notification');
    Route::post('/pop_up_notification', [SettingsController::class, 'savePopup']);


    Route::get('/marquee_notification', [SettingsController::class, 'marquee'])->name('marquee_notification');
    Route::post('/marquee_notification', [SettingsController::class, 'saveMarquee'])->name('marquee_notification.save');



});

Route::group(['prefix' => 'users', 'middleware' => ['auth', 'admin']], function () {
   
    Route::get('/regular', [UsersController::class, 'regular'])->name('regular.index');
    Route::get('/admins', [UsersController::class, 'admins'])->name('admins.index');
    Route::post('/manual-funding', [UsersController::class, 'manualFunding'])->name('manual-funding');
    Route::post('/change-password', [UsersController::class, 'changePassword'])->name('change-password');
    Route::delete('/{id}',  [UsersController::class, 'destroy'])->name('users.destroy');

    Route::post('/admin/submit',  [UsersController::class, 'storeAdmin'])->name('admin.store');


});



Route::post('/api/submit',  [ChatController::class, 'submit'])->middleware('auth');

Route::get('/chat', [ChatController::class, 'index'])->name('chat.index')->middleware('auth');

Route::group(['prefix' => 'wallet', 'middleware' => ['auth', 'regular']], function () {
   
    Route::get('/', [WalletController::class, 'index'])->name('wallet.index');
    Route::post('/verify-payment', [WalletController::class, 'creditWallet'])->name('verify-payment');


});


Route::post('/save-contact',[ContactController::class, 'saveNewContact'])->name('save-contact')->middleware('regular');



Route::group(['prefix' => 'data-plans', 'middleware' => ['auth', 'admin']], function () {
   
    // Route for displaying all data plans
    Route::get('/', [DataPlansController::class, 'index'])->name('data-plans.index');

    // Route for displaying the form to create a new data plan
    Route::get('/create', [DataPlansController::class, 'create'])->name('data-plans.create');

    // Route for storing a newly created data plan
    Route::post('/', [DataPlansController::class, 'store'])->name('data-plans.store');

    // Route for displaying a specific data plan
    Route::get('/{id}', [DataPlansController::class, 'show'])->name('data-plans.show');

    // Route for displaying the form to edit a specific data plan
    Route::get('/{id}/edit', [DataPlansController::class, 'edit'])->name('data-plans.edit');

    // Route for updating a specific data plan
    Route::put('/{id}', [DataPlansController::class, 'update'])->name('data-plans.update');

    // Route for deleting a specific data plan
    Route::delete('/{id}', [DataPlansController::class, 'destroy'])->name('data-plans.destroy');
});



Route::get('/plan-providers', [PlanProviderController::class, 'index'])->name('plan-providers.index');
Route::patch('/plan-providers/{planProvider}', [PlanProviderController::class, 'activate'])->name('plan-providers.activate');

Route::get('/recent-transactions', [BuyDataController::class, 'recentTransactions'])->name('recent.transactions');


Route::get('/contact-us', [ContactUsController::class, 'showForm'])->name('contact_us');
Route::post('/contact-us', [ContactUsController::class, 'submitForm'])->name('contact_us.submit');


// Route::get('/account', [AccountController::class, 'showAccountMenu'])->name('account.menu');
Route::get('/account', [AccountController::class, 'index'])->name('account.index');
Route::post('/account-menu/switch-account', [AccountController::class, 'switchAccount'])->name('account.menu.switch');





