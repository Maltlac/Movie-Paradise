<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ActeurController;
use App\Http\Controllers\StreamingController;
use App\Http\Controllers\panneauCtrlController;

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
    return view('home');
});

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('Home.show');

Route::get('/test', [HomeController::class, 'test'])->name('test.show');

/**
 * this part is for the streaming vues
 */
Route::get('/streaming', [StreamingController::class, 'index'])->name('streaming.index');
Route::get('/films', [FilmController::class, 'voirfilms'])->name('films.index');
Route::get('/film/{film}', [FilmController::class, 'voirfilm'])->name('film.show');


/**
 * this one is for the bio of the cast and crew
 */
Route::get('/bio/{bio}/type/{type}', [ActeurController::class, 'showBio'])->name('Acteurs.showBio');
/**
 * this one is for the E-tickets
 */

 
 /**
  * routes for the admin service
  */

  
  Route::group(['middleware' => ['auth', 'admin']], function() {
    Route::get('/panneauCtrl', [panneauCtrlController::class, 'index'])->name('panneauCtrl.index');
    Route::get('/ajoutFilm', [panneauCtrlController::class, 'ajoutFilm'])->name('panneauCtrl.ajoutFilm');
    Route::get('/search', [panneauCtrlController::class, 'searchBarFilm'])->name('searchBarFilm.index');
    Route::post('/ajoutFilm', [panneauCtrlController::class, 'storeFilm'])->name('storeFilm.store');


});
    
  
                     

//Route::get('/search','film@searchBarFilm');


