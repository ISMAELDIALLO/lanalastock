<?php
use Illuminate\Support\Facades\DB;
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

/*Route::get('/home', function () {
    return view('index');
})->name('home');*/
Route::resource('familleArticle','familleArticleController');
Route::resource('article','articleController');
Route::resource('categorieFournisseur','CategorieFournisseurController');
Route::resource('fournisseur','FournisseurController');
Route::resource('commande','CommandeController');
Route::resource('ligneDeCommande','ligneDeCommandeController');
Route::resource('temporaire','tableTemporaireController');
Route::resource('stock','stockController');
Route::resource('utilisateur','utilisateurController');
Route::resource('motif','MotifController');
Route::resource('service','ServiceController');
Route::resource('temporaireDemande','TemporaireDemandeController');
Route::resource('detailDemande','DetailDemandeController');
Route::resource('demande','DemandeController');
Route::resource('parametre','parametreController');
Route::resource('sortieStock','SortieStockController');
Route::resource('detailSortieStock','DetailSortieStockController');
Route::resource('statutDemande','StatutDemandeController');
Route::resource('resetDemande','ResetDemandeController');
Route::resource('temporaireReception','TemporaireReceptionController');
Route::resource('detailReception','DetailReceptionController');
Route::resource('reception','ReceptionController');
Route::resource('message','MessageController');
Route::resource('role','RoleController');
Route::resource('societe','SocieteController');
Route::resource('compte','CompteController');
Route::resource('detailCompte','DetailCompteController');
Route::resource('inventaire','InventaireController');
Route::resource('detailInventaire','DetailInventaireController');
Route::resource('menu','MenuController');
Route::resource('sousMenu','SousMenuController');
Route::resource('abilitation','AbilitationController');
Route::resource('detailProformat','DetailproformatController');
//Route::resource('temporaireProformat','TemporaireProformatController');
Route::resource('proformat','ProformatController');
Route::resource('traiteFacture','TraiteFactureProformat');
Route::resource('superCategorie','SuperCategorieArticleController');
Route::resource('cotation','CotationController');
Route::resource('detailCotation','DetailCotationController');
Route::resource('temporaireCotation','TemporaireCotationController');
Route::resource('acount','AcountController');
Route::resource('contrat','ContratController');

//La route qui ramene la vue aApprovisionner
Route::get('/aApprovisionner', 'stockController@aApprovisionner')->name('aApprovisionner');

Route::get('/listeDerniereCotation', 'CommandeController@listeDerniereCotation')->name('derniereCotation');


Route::get('/commande_specifique', 'CommandeController@listCommandeSpecifique')->name('commandeSpecifique');

Route::get('/creationBonApayer1', 'DetailReceptionController@creationBonApayer1')->name('creationBonApayer1');
Route::post('/creationBonApayer', 'DetailReceptionController@creationBonApayer')->name('creationBonApayer');
Route::get('/creationBonApayer', 'DetailReceptionController@creationBonApayer')->name('creationBonApayer');
Route::get('/commandes_en_attente_de_validation', 'CommandeController@commandeEnAttenteDeValidation')->name('commandeEnAttenteDeValidation');


Route::get('/regetterProformat/{id}', 'TraiteFactureProformat@rejettrerProformat')->name('rejettrerProformat');

Route::get('/cration_de_la_commande/{id}', 'ligneDeCommandeController@createCommande')->name('bonDeCommande');

Route::get('/condition_de_payement_de_la_commande/{id}', 'CommandeController@conditionPayement')->name('conditionPayement');

//Routes pour l'importation d'une liste en excel
Route::get('export', 'articleController@exportFile')->name('export');

Route::get('downloadExcel', 'articleController@downloadExcel')->name('downloadExcel');

Auth::routes();

Route::get('/home', function () {
    if (auth()->user()){
        $demandes= nonConsult();
        return view('pagePrincipal',compact('demandes'));
    }else{
        return redirect()->route('login');
    }
})->name('home');

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
//Route::get('/login', '\App\Http\Controllers\Auth\LoginController@showLoginForm');

//
Route::get('/cout_par_societe', 'StatistiqueController@coutsParService')->name('coutsParService');
Route::get('/cout_par_societe_print', 'StatistiqueController@printCouts')->name('printCouts');
Route::get('/cout_entre_deux_dates', 'StatistiqueController@rechercher')->name('rechercher');

Route::get('/pdfExport_commande/{id}', 'CommandeController@pdfExport')->name('pdfCommande');
