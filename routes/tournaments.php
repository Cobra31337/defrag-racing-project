<?php

use App\Http\Controllers\TournamentsController;
use App\Http\Controllers\TournamentManagementController;
use App\Http\Controllers\Tournaments\DonationController;
use App\Http\Controllers\Tournaments\FaqController;
use App\Http\Controllers\Tournaments\RoundController;
use App\Http\Controllers\Tournaments\SuggestionController;
use App\Http\Controllers\Tournaments\StreamerController;
use App\Http\Controllers\Tournaments\RelatedTournamentController;
use App\Http\Controllers\Tournaments\TeamController;
use App\Http\Controllers\Tournaments\RoundMapController;

Route::get('/tournaments', [TournamentsController::class, 'index'])->name('tournaments.index');
Route::get('/tournaments/{tournament}', [TournamentsController::class, 'show'])->name('tournaments.show');
Route::get('/tournaments/{tournament}/rules', [TournamentsController::class, 'rules'])->name('tournaments.rules');
Route::get('/tournaments/{tournament}/donations', [TournamentsController::class, 'donations'])->name('tournaments.donations');
Route::get('/tournaments/{tournament}/faqs', [TournamentsController::class, 'faqs'])->name('tournaments.faqs');

Route::prefix('/tournaments/{tournament}/teams')->group(function () {
    Route::get('/index', [TeamController::class, 'index'])->name('tournaments.teams.index');
    Route::get('/manage', [TeamController::class, 'manage'])->name('tournaments.teams.manage');
    Route::get('/create', [TeamController::class, 'create'])->name('tournaments.teams.create');
    Route::post('/create', [TeamController::class, 'store'])->name('tournaments.teams.store');
    Route::get('/leave', [TeamController::class, 'leave'])->name('tournaments.teams.leave');
    Route::post('/invite', [TeamController::class, 'invite'])->name('tournaments.teams.invite');

    Route::post('/{invitation}/accept', [TeamController::class, 'accept'])->name('tournaments.teams.accept');
    Route::post('/{invitation}/reject', [TeamController::class, 'reject'])->name('tournaments.teams.reject');
});

Route::get('/tournaments/manage/tournament/create', [TournamentManagementController::class, 'create'])->name('tournaments.create');
Route::post('/tournaments/manage/tournament/create', [TournamentManagementController::class, 'store'])->name('tournaments.store');

Route::post('/tournaments/{tournament}/suggestions/create', [SuggestionController::class, 'store'])->name('tournaments.suggestions.store');

Route::middleware(['tournaments.management'])->prefix('/tournaments/manage')->group(function () {
    Route::get('{tournament}', [TournamentManagementController::class, 'manage'])->name('tournaments.manage');

    Route::get('{tournament}/suggestions', [SuggestionController::class, 'index'])->name('tournaments.suggestions.index');
    Route::get('{tournament}/suggestions/{suggestion}/delete', [SuggestionController::class, 'destroy'])->name('tournaments.suggestions.destroy');

    Route::get('{tournament}/edit', [TournamentManagementController::class, 'edit'])->name('tournaments.edit');
    Route::post('{tournament}/edit', [TournamentManagementController::class, 'update'])->name('tournaments.update');
    
    Route::get('{tournament}/donations', [DonationController::class, 'index'])->name('tournaments.donations.manage');
    Route::get('{tournament}/donations/create', [DonationController::class, 'create'])->name('tournaments.donations.create');
    Route::post('{tournament}/donations/store', [DonationController::class, 'store'])->name('tournaments.donations.store');
    Route::get('{tournament}/donations/{donation}/edit', [DonationController::class, 'edit'])->name('tournaments.donations.edit');
    Route::post('{tournament}/donations/{donation}/update', [DonationController::class, 'update'])->name('tournaments.donations.update');
    Route::get('{tournament}/donations/{donation}', [DonationController::class, 'destroy'])->name('tournaments.donations.destroy');


    Route::get('{tournament}/faqs', [FaqController::class, 'index'])->name('tournaments.faqs.manage');
    Route::get('{tournament}/faqs/create', [FaqController::class, 'create'])->name('tournaments.faqs.create');
    Route::post('{tournament}/faqs/store', [FaqController::class, 'store'])->name('tournaments.faqs.store');
    Route::get('{tournament}/faqs/{faq}/edit', [FaqController::class, 'edit'])->name('tournaments.faqs.edit');
    Route::post('{tournament}/faqs/{faq}/update', [FaqController::class, 'update'])->name('tournaments.faqs.update');
    Route::get('{tournament}/faqs/{faq}', [FaqController::class, 'destroy'])->name('tournaments.faqs.destroy');

    
    Route::get('{tournament}/streamers', [StreamerController::class, 'index'])->name('tournaments.streamers.manage');
    Route::get('{tournament}/streamers/create', [StreamerController::class, 'create'])->name('tournaments.streamers.create');
    Route::post('{tournament}/streamers/store', [StreamerController::class, 'store'])->name('tournaments.streamers.store');
    Route::get('{tournament}/streamers/{streamer}/edit', [StreamerController::class, 'edit'])->name('tournaments.streamers.edit');
    Route::post('{tournament}/streamers/{streamer}/update', [StreamerController::class, 'update'])->name('tournaments.streamers.update');
    Route::get('{tournament}/streamers/{streamer}', [StreamerController::class, 'destroy'])->name('tournaments.streamers.destroy');

    
    Route::get('{tournament}/related', [RelatedTournamentController::class, 'index'])->name('tournaments.related.manage');
    Route::get('{tournament}/related/create', [RelatedTournamentController::class, 'create'])->name('tournaments.related.create');
    Route::post('{tournament}/related/store', [RelatedTournamentController::class, 'store'])->name('tournaments.related.store');
    Route::get('{tournament}/related/{relatedTournament}/edit', [RelatedTournamentController::class, 'edit'])->name('tournaments.related.edit');
    Route::post('{tournament}/related/{relatedTournament}/update', [RelatedTournamentController::class, 'update'])->name('tournaments.related.update');
    Route::get('{tournament}/related/{relatedTournament}', [RelatedTournamentController::class, 'destroy'])->name('tournaments.related.destroy');


    Route::get('{tournament}/rounds', [RoundController::class, 'index'])->name('tournaments.rounds.manage');
    Route::get('{tournament}/rounds/create', [RoundController::class, 'create'])->name('tournaments.rounds.create');
    Route::post('{tournament}/rounds/store', [RoundController::class, 'store'])->name('tournaments.rounds.store');
    Route::get('{tournament}/rounds/{round}/edit', [RoundController::class, 'edit'])->name('tournaments.rounds.edit');
    Route::post('{tournament}/rounds/{round}/update', [RoundController::class, 'update'])->name('tournaments.rounds.update');
    Route::post('{tournament}/rounds/{round}', [RoundController::class, 'destroy'])->name('tournaments.rounds.destroy');

    Route::get('{tournament}/rounds/{round}/maps', [RoundMapController::class, 'index'])->name('tournaments.rounds.maps.index');
    Route::get('{tournament}/rounds/{round}/maps/create', [RoundMapController::class, 'create'])->name('tournaments.rounds.maps.create');
    Route::post('{tournament}/rounds/{round}/maps/create', [RoundMapController::class, 'store'])->name('tournaments.rounds.maps.store');
    Route::get('{tournament}/rounds/{round}/maps/{map}/delete', [RoundMapController::class, 'destroy'])->name('tournaments.rounds.maps.destroy');
});