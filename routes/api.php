<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/me', function () {
    try {
        // Fetch cat fact
        $response = Http::timeout(5)->get('https://catfact.ninja/fact');

        if ($response->successful()) {
            $cat_fact = $response->json('fact');
        } else {
            $cat_fact = "Could not fetch cat fact at the moment.";
        }
    } catch (\Exception $e) {
        $cat_fact = "Error fetching cat fact: " . $e->getMessage();
    }

    return response()->json([
        'status' => 'success',
        'user' => [
            'email' => 'version.control.dev@gmail.com',
            'name' => 'Samuel Osho',
            'stack' => 'Laravel/PHP',
        ],
        'timestamp' => Carbon::now('UTC')->toISOString(),
        'fact' => $cat_fact,
    ]);
});
