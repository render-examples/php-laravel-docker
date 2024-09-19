<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Services\FixtureService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon; //  date comparison

class FixtureController extends Controller
{
protected $fixtureService;

    public function __construct(FixtureService $fixtureService)
    {
        $this->fixtureService = $fixtureService;
    }

     // List all fixtures or get from API and store in DB
    public function index()
    {
        $existingFixtures = Fixture::count();

        if ($existingFixtures > 0) {
            return $this->updateFixtures();
        } else {
            return $this->fetchAndStoreFixtures();
        }
    }

    private function updateFixtures() {

        //get fixtures with no data that the match date and hour has passed
        $fixturesToUpdate = Fixture::whereNull('teams_home_goals')
        ->where(function($query) {
            $query->where('date', '<', Carbon::now('UTC')->toDateString())
                ->orWhere(function($query) {
                    $query->where('date', Carbon::now('UTC')->toDateString())
                    ->where('time', '<', Carbon::now('UTC')->toTimeString());
                });
        })
        ->get();

        $updatedFixtures = [];

        foreach ($fixturesToUpdate as $fixture) {
            // Fetch updated data from the external API using fixtureId
            $apiData = $this->fixtureService->getFixtureById($fixture->fixtureId);

            // Check if the API has response
            if (!empty($apiData['response'])) {
                $fixtureData = $apiData['response'][0];

                //Update the fixture if the Matched is finished
                if($fixtureData['fixture']['status']['long']==="Match Finished"){
                    $fixture->update([
                        'teams_home_goals' => $fixtureData['goals']['home'],
                        'teams_away_goals' => $fixtureData['goals']['away'],
                    ]);

                    $updatedFixtures[] = $fixture;
                }
            }
        }

        $allFixtures = Fixture::all();

        return response()->json([
            'updatedFixtures' => $updatedFixtures,
            'allFixtures' => $allFixtures
        ]);
    }

    private function fetchAndStoreFixtures() {
    //There is no fixtures on the database
        $apiData = Cache::remember('fixtures_league_34_season_2026', 60 * 60 * 24, function () {
            return $this->fixtureService->getFixturesByLeagueAndSeason('34', '2026');
        });

        $updatedFixtures = [];

        foreach ($apiData['response'] as $fixtureData) {
            $fixture = Fixture::create([
                'fixtureId' => $fixtureData['fixture']['id'],
                'date' => date('Y-m-d', strtotime($fixtureData['fixture']['date'])),
                'time' => date('H:i', strtotime($fixtureData['fixture']['date'])),
                'place' => $fixtureData['fixture']['venue']['name'],
                'city' => $fixtureData['fixture']['venue']['city'],
                'teams_home_name' => $fixtureData['teams']['home']['name'],
                'teams_home_logo' => $fixtureData['teams']['home']['logo'],
                'teams_home_goals' => $fixtureData['goals']['home'],
                'teams_away_name' => $fixtureData['teams']['away']['name'],
                'teams_away_logo' => $fixtureData['teams']['away']['logo'],
                'teams_away_goals' => $fixtureData['goals']['away'],
            ]);

            $updatedFixtures[] = $fixture;
        }

        return response()->json(['updatedFixtures' => $updatedFixtures]);

    }
}
