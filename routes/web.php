<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AdminDashboardController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CustomerSiteController;
use App\Http\Controllers\Web\CustomerCartController;
use App\Http\Controllers\Web\CustomerOrderWebController;
use App\Http\Controllers\Web\CustomerDashboardController;
use App\Http\Controllers\Web\SellerDashboardController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/beranda', [CustomerSiteController::class, 'beranda']);
Route::get('/toko', [CustomerSiteController::class, 'toko']);
Route::get('/toko/{seller}', [CustomerSiteController::class, 'tokoDetail']);
Route::get('/hubungi-kami', [CustomerSiteController::class, 'hubungi']);
Route::get('/tentang', [CustomerSiteController::class, 'tentang']);
Route::middleware('auth')->get('/keranjang', [CustomerCartController::class, 'index']);
Route::middleware('auth')->get('/profil', [CustomerSiteController::class, 'profil']);
Route::middleware('auth')->post('/keranjang/add/{product}', [CustomerCartController::class, 'add']);
Route::middleware('auth')->patch('/keranjang/{product}', [CustomerCartController::class, 'update']);
Route::middleware('auth')->delete('/keranjang/{product}', [CustomerCartController::class, 'remove']);
Route::middleware('auth')->get('/checkout', [CustomerCartController::class, 'checkout']);
Route::middleware('auth')->post('/checkout', [CustomerCartController::class, 'placeOrder']);
Route::middleware('auth')->get('/pesanan/{order}/bayar', [CustomerOrderWebController::class, 'uploadForm']);
Route::middleware('auth')->post('/pesanan/{order}/bayar', [CustomerOrderWebController::class, 'upload']);

Route::get('/login', [AuthController::class, 'showLogin'])->defaults('role', 'customer');
Route::post('/login', [AuthController::class, 'login'])->defaults('role', 'customer');
Route::get('/register', [AuthController::class, 'showRegister'])->defaults('role', 'customer');
Route::post('/register', [AuthController::class, 'register'])->defaults('role', 'customer');

Route::get('/admin/login', [AuthController::class, 'showLogin'])->defaults('role', 'admin');
Route::post('/admin/login', [AuthController::class, 'login'])->defaults('role', 'admin');

Route::get('/seller/login', [AuthController::class, 'showLogin'])->defaults('role', 'seller');
Route::post('/seller/login', [AuthController::class, 'login'])->defaults('role', 'seller');
Route::get('/seller/register', [AuthController::class, 'showRegister'])->defaults('role', 'seller');
Route::post('/seller/register', [AuthController::class, 'register'])->defaults('role', 'seller');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['auth', 'role:admin'])->get('/admin/beranda', [AdminDashboardController::class, 'beranda']);
Route::middleware(['auth', 'role:admin'])->get('/admin/data-nasi-bakar', [AdminDashboardController::class, 'dataNasiBakar']);
Route::middleware(['auth', 'role:admin'])->get('/admin/data-pengguna', [AdminDashboardController::class, 'dataPengguna']);
Route::middleware(['auth', 'role:admin'])->get('/admin/pesanan-laporan', [AdminDashboardController::class, 'pesananLaporan']);
Route::middleware(['auth', 'role:admin'])->get('/admin/customers', [AdminDashboardController::class, 'customers']);
Route::middleware(['auth', 'role:admin'])->get('/admin/customer-reviews', [AdminDashboardController::class, 'customerReviews']);
Route::middleware(['auth', 'role:admin'])->patch('/admin/customers/{user}/deactivate', [AdminDashboardController::class, 'deactivateCustomer']);
Route::middleware(['auth', 'role:admin'])->patch('/admin/customers/{user}/activate', [AdminDashboardController::class, 'activateCustomer']);
Route::middleware(['auth', 'role:admin'])->delete('/admin/customers/{user}', [AdminDashboardController::class, 'deleteCustomer']);
Route::middleware(['auth', 'role:seller'])->get('/seller/beranda', [SellerDashboardController::class, 'beranda']);
Route::middleware(['auth', 'role:seller'])->get('/seller/data-sayuran', [SellerDashboardController::class, 'dataSayuran']);
Route::middleware(['auth', 'role:seller'])->post('/seller/data-sayuran', [SellerDashboardController::class, 'storeSayuran']);
Route::middleware(['auth', 'role:seller'])->patch('/seller/data-sayuran/{product}', [SellerDashboardController::class, 'updateSayuran']);
Route::middleware(['auth', 'role:seller'])->delete('/seller/data-sayuran/{product}', [SellerDashboardController::class, 'deleteSayuran']);
Route::middleware(['auth', 'role:seller'])->get('/seller/data-ongkir', [SellerDashboardController::class, 'dataOngkir']);
Route::middleware(['auth', 'role:seller'])->post('/seller/data-ongkir', [SellerDashboardController::class, 'storeOngkir']);
Route::middleware(['auth', 'role:seller'])->patch('/seller/data-ongkir/{shippingRate}', [SellerDashboardController::class, 'updateOngkir']);
Route::middleware(['auth', 'role:seller'])->delete('/seller/data-ongkir/{shippingRate}', [SellerDashboardController::class, 'deleteOngkir']);
Route::middleware(['auth', 'role:seller'])->get('/seller/pesanan', [SellerDashboardController::class, 'pesanan']);
Route::middleware(['auth', 'role:seller'])->get('/seller/konfirmasi-pesanan', [SellerDashboardController::class, 'konfirmasiPesanan']);
Route::middleware(['auth', 'role:seller'])->post('/seller/konfirmasi-pesanan/{orderItem}', [SellerDashboardController::class, 'confirmPesanan']);
Route::middleware(['auth', 'role:seller'])->get('/seller/laporan', [SellerDashboardController::class, 'laporan']);
Route::middleware(['auth', 'role:customer'])->get('/dashboard', [CustomerDashboardController::class, 'index']);
