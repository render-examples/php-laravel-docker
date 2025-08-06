<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DownloadController extends Controller
{
    public function download(): StreamedResponse
    {
        $filePath = 'public/files/file1.pdf';
        $fileName = 'document-officiel.pdf';

        return Storage::download($filePath, $fileName);
    }
}
