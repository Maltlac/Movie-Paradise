<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\profilController;
use App\Http\Controllers\saisonController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\contactController;
use App\Http\Controllers\ebilletController;
use App\Http\Controllers\episodeController;
use App\Http\Controllers\PersonnesController;
use App\Http\Controllers\StreamingController;
use App\Http\Controllers\commantaireController;
use App\Http\Controllers\panneauCtrlController;
use App\Http\Controllers\Auth\ForgotPasswordController;


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


Route::get('/', [StreamingController::class, 'index']);


Auth::routes();

Route::get('/test', [HomeController::class, 'test'])->name('test.show');

    ///PassWord route
    Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

    ///// contact form route
    Route::get('/contact', [contactController::class, 'contactForm'])->name('contact-form');
    Route::post('/contact-form', [ContactController::class, 'storeContactForm'])->name('contact-form.store');

    //////ebillets route
    Route::get('/home/ebillet', [ebilletController::class, 'home'])->name('ebillet.home');
    Route::get('/salle/cinema/{cinema}/', [ebilletController::class, 'regionCinema']);
    Route::get('/salle/cinema/seance/{url}', [ebilletController::class, 'seanceCinema'])->name("seance.cinema");
    Route::post('/biller/reserver', [ebilletController::class, 'reservationEbillet'])->name("reserver.billet");
 

    /**
     * Profil route
     */
    Route::get('/profil/Commentaire', [profilController::class, 'profilComments'])->name("profil.commentaire");
    Route::get('/profil/artiste', [profilController::class, 'profilArtiste'])->name("profil.Artiste");
    Route::get('/profil/film', [profilController::class, 'profilFilm'])->name("profil.film");
    Route::get('/profil/cinema', [profilController::class, 'profilCinema'])->name("profil.cinema");
    Route::get('/profil/parametre', [profilController::class, 'profilParametre'])->name("profil.parametre");
    Route::post('/update/profil',[profilController::class, 'updateProfil'])->name("update.profil");

    Route::get('/edit/commentaire/{commentaire}', [commantaireController::class, 'showComInfo'])->name('commentaire.show');
    Route::post('/update/commentaire',[commantaireController::class,'updateCommentaire']);
    Route::get('/delete/commentaire/{commentaire}',[commantaireController::class,'deleteCommentaire'])->name('delCommentaire');


    /**
     * this part is for the streaming vues
     */

    ////Streaming 
    Route::get('/streaming', [StreamingController::class, 'index'])->name('streaming.index');
    Route::get('/searchStreaming', [StreamingController::class, 'searchStreaming']);
    Route::get('autocomplete', [StreamingController::class, 'search']);
    Route::get('/p/{p}/categ/{categ}/year/{year}', [StreamingController::class, 'searchCateg']);
    Route::get('/searchCategVars', [StreamingController::class, 'searchCategVars']);
    ///Films
    Route::get('/films', [FilmController::class, 'voirfilms'])->name('films.index');
    Route::get('/film/{film}', [FilmController::class, 'voirfilm'])->name("voir.film");
    Route::post('/PostCommentFilm/{idFilm}',[commantaireController::class,'postCommentMovie']);
    Route::post('/ajoutMalisteFilm',[FilmController::class,'ajoutMalisteFilm'])->name('ajoutMalisteFilm.post');
    Route::post('/suppMalisteFilm',[FilmController::class,'suppMalisteFilm'])->name('suppMalisteFilm.Delete');
    ////Series
    Route::get('/serie/{serie}', [SeriesController::class, 'voirSerie'])->name("voir.serie");
    Route::get('/serie/{serie}/saison/{saison}', [saisonController::class, 'voirSaison']);
    Route::get('/serie/{serie}/saison/{saison}/episode/{episode}', [episodeController::class, 'voirEpisode']);
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

        Route::get('/Statistique', [panneauCtrlController::class, 'stats']);
        ///Films
        Route::post('/ajoutFilm', [panneauCtrlController::class, 'storeFilm'])->name('storeFilm.store');
        Route::get('/ajoutFilm', [panneauCtrlController::class, 'ajoutFilm'])->name('panneauCtrl.ajoutFilm');
        Route::get('/searchFilm', [panneauCtrlController::class, 'searchBarFilm'])->name('searchBarFilm.index');
        Route::get('/gererFilm', [panneauCtrlController::class, 'gererFilm'])->name('gererFilm.index');
        Route::get('/edit/film/{film}', [FilmController::class, 'showFilmInfo'])->name('film.show');
        Route::post('/panneauCtrl/update/film',[FilmController::class,'updateFilm']);
        Route::get('/panneauCtrl/delete/film/{film}',[FilmController::class,'deleteFilm'])->name('delFilm');
        
        ////Series
        Route::post('/ajoutSerie', [panneauCtrlController::class, 'storeSerie'])->name('storeSerie.store');
        Route::get('/ajoutSerie', [panneauCtrlController::class, 'ajoutSerie'])->name('panneauCtrl.ajoutSerie');
        Route::get('/searchSerie', [panneauCtrlController::class, 'searchBarSerie'])->name('searchBarSerie.index');
        
        Route::get('/gererSeries', [panneauCtrlController::class, 'gererSeries']);
        Route::get('/gererSeries/saison/{serie}', [panneauCtrlController::class, 'gererSeriesSaison']);
        Route::get('/gererSeries/saison/{serie}/episodes/{saison}', [panneauCtrlController::class, 'gererSeriesSaisonEpisode']);

        Route::get('/edit/Serie/{Serie}', [SeriesController::class, 'showSerieInfo'])->name('serie.show');
        Route::post('/panneauCtrl/update/serie',[SeriesController::class,'updateSerie']);
        Route::get('/panneauCtrl/delete/serie/{Serie}',[SeriesController::class,'deleteSerie'])->name('delSerie');

        ///saisons
        Route::get('/edit/saison/{saison}', [saisonController::class, 'showSaisonInfo'])->name('saison.show');
        Route::post('/panneauCtrl/update/saison',[saisonController::class,'updateSaison']);
        Route::get('/panneauCtrl/delete/saison/{saison}',[saisonController::class,'deleteSaison'])->name('delSaison');
        Route::post('/panneauCtrl/ajout/saison',[saisonController::class,'ajoutSaison'])->name('ajoutSaison');

        ////episodes
        Route::get('/edit/episode/{episode}', [episodeController::class, 'showEpisodeInfo'])->name('episode.show');
        Route::post('/panneauCtrl/update/episode',[episodeController::class,'updateEpisode']);
        Route::get('/panneauCtrl/delete/episode/{episode}',[episodeController::class,'deleteEpisode'])->name('delEpisode');
        Route::post('/panneauCtrl/ajout/episode',[episodeController::class,'ajoutEpisode'])->name('ajoutEpisode');
    });
    

