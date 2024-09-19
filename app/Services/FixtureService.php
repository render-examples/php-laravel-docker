<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FixtureService
{
    private $apiKey;
    private $apiHost;

    public function __construct()
    {
        $this->apiKey = env('FOOTBALL_API_KEY');
        $this->apiHost = 'v3.football.api-sports.io';
    }

    public function getFixtureById($fixtureId)
    {
        try{
            $response = Http::withHeaders([
            'x-rapidapi-key' => $this->apiKey,
            'x-rapidapi-host' => $this->apiHost
            ])->get("https://v3.football.api-sports.io/fixtures", [
                'id' => $fixtureId,
            ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                throw new \Exception('Error fetching fixture data');
            }

        } catch (\Exception $e) {
            \Log::error("Failed to get fixture data: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch fixture data'], 500);
        }
    }

    public function getFixturesByLeagueAndSeason($league, $season)
    {
        try{
            $response = Http::withHeaders([
            'x-rapidapi-key' => $this->apiKey,
            'x-rapidapi-host' => $this->apiHost
            ])->get('https://v3.football.api-sports.io/fixtures', [
                'league' => $league,
                'season' => $season,
            ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                throw new \Exception('Error fetching fixtures by league and season');
            }

        } catch (\Exception $e) {
            \Log::error("Failed to get fixtures by league and season: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch fixtures by league and season'], 500);
        }

    }
}
