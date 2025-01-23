<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\PersonnesController;
use App\Http\Controllers\StreamingController;
use App\Http\Controllers\commantaireController;
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

 ////Streaming 
 Route::get('/streaming', [StreamingController::class, 'index'])->name('streaming.index');
 Route::get('/searchStreaming', [StreamingController::class, 'searchStreaming']);
 Route::get('autocomplete', [StreamingController::class, 'search']);
 Route::get('/p/{p}/categ/{categ}/year/{year}', [StreamingController::class, 'searchCateg']);
 Route::post('/searchCategVars', [StreamingController::class, 'searchCategVars']);
 ///Films
 Route::get('/films', [FilmController::class, 'voirfilms'])->name('films.index');
 Route::get('/film/{film}', [FilmController::class, 'voirfilm'])->name('film.show');
 Route::post('/PostCommentFilm/{idFilm}',[commantaireController::class,'postCommentMovie']);
 Route::post('/ajoutMalisteFilm',[FilmController::class,'ajoutMalisteFilm'])->name('ajoutMalisteFilm.post');
 Route::post('/suppMalisteFilm',[FilmController::class,'suppMalisteFilm'])->name('suppMalisteFilm.Delete');
 ////Series
Route::get('/serie/{serie}', [SeriesController::class, 'voirSerie'])->name('series.show');
Route::get('/serie/{serie}/saison/{saison}', [SeriesController::class, 'voirSaison'])->name('saison.show');
Route::get('/serie/{serie}/saison/{saison}/episode/{episode}', [SeriesController::class, 'voirEpisode'])->name('episode.show');
Route::post('/postCommentSerie/{idSeries}',[commantaireController::class,'postCommentSerie']);
Route::post('/ajoutMalisteSerie',[SeriesController::class,'ajoutMalisteSerie'])->name('ajoutMalisteSerie.post');
Route::post('/suppMalisteSerie',[SeriesController::class,'suppMalisteSerie'])->name('suppMalisteSerie.Delete');

/**
 * this one is for the bio of the cast and crew
 */
Route::get('/bio/{bio}', [PersonnesController::class, 'showBio'])->name('personnes.showBio');
Route::post('/ajoutMalistePersonne',[PersonnesController::class,'ajoutMalistePersonne'])->name('ajoutMalistePersonne.post');
Route::post('/suppMalistePersonne',[PersonnesController::class,'suppMalistePersonne'])->name('suppMalistePersonne.Delete');
/**
 * this one is for the E-tickets
 */

 
 /**
  * routes for the admin service
  */

  
    Route::group(['middleware' => ['auth', 'admin']], function() {
    Route::get('/panneauCtrl', [panneauCtrlController::class, 'index'])->name('panneauCtrl.index');

    ///Films
    Route::post('/ajoutFilm', [panneauCtrlController::class, 'storeFilm'])->name('storeFilm.store');
    Route::get('/ajoutFilm', [panneauCtrlController::class, 'ajoutFilm'])->name('panneauCtrl.ajoutFilm');
    Route::get('/searchFilm', [panneauCtrlController::class, 'searchBarFilm'])->name('searchBarFilm.index');
    Route::get('/gererFilm', [panneauCtrlController::class, 'gererFilm'])->name('gererFilm.index');

    
    ////Series
    Route::post('/ajoutSerie', [panneauCtrlController::class, 'storeSerie'])->name('storeSerie.store');
    Route::get('/ajoutSerie', [panneauCtrlController::class, 'ajoutSerie'])->name('panneauCtrl.ajoutSerie');
    Route::get('/searchSerie', [panneauCtrlController::class, 'searchBarSerie'])->name('searchBarSerie.index');

    


});
    


