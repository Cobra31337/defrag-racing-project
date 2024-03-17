<?php

namespace App\Http\Controllers\Tournaments;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Tournament;
use App\Models\Organizer;

use App\Rules\YouTubeUrl;

use App\Http\Controllers\Controller;

use App\Models\Round;

use Carbon\Carbon;

class RoundController extends Controller {
    public function index (Tournament $tournament) {
        $tournament->load('rounds');

        return Inertia::render('Tournaments/Management/Rounds/Index')
                ->with('tournament', $tournament);
    }

    public function create(Tournament $tournament) {
        return Inertia::render('Tournaments/Management/Rounds/Create')
                ->with('tournament', $tournament);
    }

    public function store(Request $request, Tournament $tournament) {
        $request->validate([
            'name'          =>      'required|string|max:255',
            'author'        =>      'required|string|max:255',
            'image'         =>      'required|image',
            'start_date'    =>      'required|date',
            'end_date'      =>      'required|date'
        ]);

        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $now = Carbon::now();

        if ($start_date->lt($now)) {
            return redirect()->route('tournaments.rounds.manage', $tournament)->withDanger('Start date must be in the future');
        }

        if ($end_date->lt($start_date)) {
            return redirect()->route('tournaments.rounds.manage', $tournament)->withDanger('End date must be after the start date');
        }

        if (isset($request->weapons) && isset($request->weapons['include'])) {
            $weapons = implode(',', $request->weapons['include']);
        } else {
            $weapons = '';
        }

        if (isset($request->items) && isset($request->items['include'])) {
            $items = implode(',', $request->items['include']);
        } else {
            $items = '';
        }

        if (isset($request->functions) && isset($request->functions['include'])) {
            $functions = implode(',', $request->functions['include']);
        } else {
            $functions = '';
        }

        $round = $tournament->rounds()->create([
            'name'          =>      $request->name,
            'author'        =>      $request->author,
            'start_date'    =>      $start_date,
            'end_date'      =>      $end_date,
            'image'         =>      $request->file('image')->store('tournaments/rounds', 'public'),
            'weapons'       =>      $weapons,
            'items'         =>      $items,
            'functions'     =>      $functions
        ]);

        return redirect()->route('tournaments.rounds.manage', $tournament);
    }

    public function edit(Tournament $tournament, Round $round) {
        return Inertia::render('Tournaments/Management/Rounds/Edit')
                ->with('tournament', $tournament)
                ->with('round', $round);
    }

    public function update(Request $request, Tournament $tournament, Round $round) {
        $request->validate([
            'name'          =>      'required|string|max:255',
            'start_date'    =>      'required|date',
            'end_date'      =>      'required|date',
            'author'        =>      'required|string|max:255',
        ]);

        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $now = Carbon::now();

        if ($start_date->lt($now)) {
            return redirect()->back()->withDanger('Start date must be in the future');
        }

        if ($end_date->lt($start_date)) {
            return redirect()->back()->withDanger('End date must be after the start date');
        }

        if ($request->file('image')) {
            $image = $request->file('image')->store('tournaments/rounds', 'public');
        } else {
            $image = $round->image;
        }



        if (isset($request->weapons) && isset($request->weapons['include'])) {
            $weapons = implode(',', $request->weapons['include']);
        } else {
            $weapons = '';
        }

        if (isset($request->items) && isset($request->items['include'])) {
            $items = implode(',', $request->items['include']);
        } else {
            $items = '';
        }

        if (isset($request->functions) && isset($request->functions['include'])) {
            $functions = implode(',', $request->functions['include']);
        } else {
            $functions = '';
        }

        $round->update([
            'name'          =>      $request->name,
            'start_date'    =>      $start_date,
            'end_date'      =>      $end_date,
            'image'         =>      $image,
            'weapons'       =>      $weapons,
            'items'         =>      $items,
            'functions'     =>      $functions,
            'author'        =>      $request->author
        ]);

        return redirect()->route('tournaments.rounds.manage', $tournament)->withSuccess('Round edited successfully.');
    }

    public function destroy(Tournament $tournament, Round $round) {
        $round->delete();

        return redirect()->route('tournaments.rounds.manage', $tournament)->withSuccess('Round deleted successfully !');
    }
}
