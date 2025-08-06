<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PeriodeAcademiqueController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BulletinController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('index');

// Authentification
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');



Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Routes Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Gestion des utilisateurs
        Route::get('/user/{id}', [AdminController::class, 'showUser'])->name('users.show');
        Route::post('/user/{id}/approve', [AdminController::class, 'approveUser'])->name('users.approve');
        Route::post('/user/{id}/deactivate', [AdminController::class, 'deactivateUser'])->name('users.deactivate');
        Route::post('/user/{id}/reject', [AdminController::class, 'rejectUser'])->name('users.reject');

        Route::get('/users', [AdminController::class, 'listUsers'])->name('users.index');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

        Route::get('/approvals', [AdminController::class, 'pendingUsers'])->name('users.pending');
        Route::get('/active-users', [AdminController::class, 'activeUsers'])->name('users.active');

        // Années scolaires
        Route::get('annees-scolaires', [AdminController::class, 'anneesScolaires'])->name('annees.index');
        Route::get('annees-scolaires/create', [AdminController::class, 'createAnnee'])->name('annees.create');
        Route::post('annees-scolaires', [AdminController::class, 'storeAnnee'])->name('annees.store');
        Route::get('annees-scolaires/{id}/edit', [AdminController::class, 'editAnnee'])->name('annees.edit');
        Route::put('annees-scolaires/{id}', [AdminController::class, 'updateAnnee'])->name('annees.update');
        Route::delete('annees-scolaires/{id}', [AdminController::class, 'destroyAnnee'])->name('annees.delete');

        // Périodes académiques
        Route::get('periodes', [PeriodeAcademiqueController::class, 'index'])->name('periodes.index');
        Route::get('periodes/create', [PeriodeAcademiqueController::class, 'create'])->name('periodes.create');
        Route::post('periodes', [PeriodeAcademiqueController::class, 'store'])->name('periodes.store');
        Route::get('periodes/{id}/edit', [PeriodeAcademiqueController::class, 'edit'])->name('periodes.edit');
        Route::put('periodes/{id}', [PeriodeAcademiqueController::class, 'update'])->name('periodes.update');
        Route::delete('periodes/{id}', [PeriodeAcademiqueController::class, 'destroy'])->name('periodes.destroy');

        // Affectation classes/matières
        Route::get('professeurs/{professeur}/affectation', [AdminController::class, 'affectation'])->name('professeurs.affectation');
        Route::post('professeurs/{professeur}/affectation', [AdminController::class, 'storeAffectation'])->name('professeurs.affectation.store');
        Route::get('/professeurs/{id}/edit-affectation', [AdminController::class, 'editAffectation'])->name('professeurs.affectation.edit');
        Route::put('/professeurs/{id}/update-affectation', [AdminController::class, 'updateAffectation'])->name('professeurs.affectation.update');

        // Affectation élèves
        Route::get('affectations/annees', [AdminController::class, 'affectationAnnees'])->name('affectation.annees');
        Route::get('affectations/{annee}/classes', [AdminController::class, 'affectationClasses'])->name('affectation.classes');
        Route::get('affectations/{annee}/{classe}/eleves', [AdminController::class, 'affectationEleves'])->name('affectation.eleves');
        Route::post('affectations/assign', [AdminController::class, 'assignerElevesClasse'])->name('affectation.assigner');

        // Migration
        Route::get('/classes', [AdminController::class, 'showClasses'])->name('classes');
        Route::get('/classes/{anneeId}/{classeId}/eleves', [AdminController::class, 'showEleves'])->name('classes.eleves');
        Route::get('/classes/{anneeId}/{classeId}/migration', [AdminController::class, 'migrationPage'])->name('classes.migration');
        Route::post('/classes/{anneeId}/{classeId}/migrer', [AdminController::class, 'migrerEleves'])->name('classes.migrer');

        Route::get('/migration/{anneeId}/{classeId}', [ProfesseurController::class, 'listeElevesAMigrer'])->name('migration.index');
        Route::post('/migration/calcule/{anneeId}/{classeId}', [ProfesseurController::class, 'calculerMoyenneAnnuelle'])->name('migration.calcule');
        Route::get('/migration/{anneeId}/{classeId}/admis/pdf', [ProfesseurController::class, 'exportAdmisPDF'])->name('migration.export.admis');
        Route::get('/migration/{anneeId}/{classeId}/refuses/pdf', [ProfesseurController::class, 'exportRefusesPDF'])->name('migration.export.refuses');

        // Résultats
        Route::get('/resultats', [AdminController::class, 'showResultats'])->name('resultats');
        Route::get('/resultats/{anneeId}', [AdminController::class, 'showClassesForAnnee'])->name('resultats.classes');
        Route::get('/resultats/{anneeId}/{classeId}', [AdminController::class, 'showElevesForResultats'])->name('resultats.eleves');

          // Routes pour les réclamations admin
        Route::prefix('reclamations')->group(function () {
            Route::get('/', [ReclamationController::class, 'adminIndex'])->name('reclamations.admin');
            Route::post('/unlock/{reclamation}', [ReclamationController::class, 'unlockNote'])->name('reclamations.unlock');
        });
    });

    // Ressources principales
    Route::resource('classes', ClasseController::class);
    Route::resource('professeurs', ProfesseurController::class);

    // Affectation des classes aux professeurs
    Route::post('/professeurs/{professeur}/affecter-classes', [ProfesseurController::class, 'affecterClasses'])->name('professeurs.affecter-classes');

    // Matières d'une classe
    Route::get('/api/classes/{classe}/matieres', [ClasseController::class, 'getMatieres'])->name('classes.matieres');

    // Routes Professeur
    Route::prefix('professeur')->name('professeur.')->group(function () {
        Route::get('/dashboard', [ProfesseurController::class, 'dashboard'])->name('dashboard');
        Route::get('/classes/{anneeId}', [ProfesseurController::class, 'mesClasses'])->name('classes');
        Route::get('/classe/{anneeId}/{classeId}/eleves', [ProfesseurController::class, 'elevesParClasse'])->name('classe.eleves');
        Route::get('/statistiques/{anneeId}/{classeId}', [ProfesseurController::class, 'showStatistics'])->name('statistiques.show');
        Route::post('/notes/enregistrer', [ProfesseurController::class, 'saisirNotes'])->name('notes.enregistrer');
    });

    // Bulletins
    Route::get('/bulletins', [BulletinController::class, 'index'])->name('bulletin.index');
    Route::get('/bulletins/{annee_academique_id}', [BulletinController::class, 'show'])->name('bulletin.show');
    Route::get('/bulletin/{annee_academique_id}/download', [BulletinController::class, 'downloadBulletin'])->name('bulletin.download');

    // Modification profil
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/editadmin', [UserController::class, 'admineditProfile'])->name('profile.admin.edit');
    Route::put('/profile/updateadmin', [UserController::class, 'adminupdateProfile'])->name('profile.admin.update');
    Route::get('/profile/editeleve', [BulletinController::class, 'editProfileleve'])->name('profile.editeleve');

    // Routes pour les réclamations
    Route::prefix('reclamations')->group(function () {
        Route::get('/', [ReclamationController::class, 'professeurIndex'])->name('reclamations.professeur');
        Route::get('/create/{eleve}', [ReclamationController::class, 'create'])->name('reclamations.create');
        Route::post('/store', [ReclamationController::class, 'store'])->name('reclamations.store');
        Route::get('professeur/reclamations/suivi/{eleve_id?}', [ReclamationController::class, 'suiviReclamations'])->name('reclamations.suivi');

    });

});
