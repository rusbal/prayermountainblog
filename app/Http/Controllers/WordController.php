<?php

namespace App\Http\Controllers;

use App\Name;

use App\Http\Requests;
use DirectoryIterator;
use App\ViewHelper;

class WordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wordDirectory = 'downloads/MSWord';
        $documentFiles = [];

        if (file_exists($wordDirectory)) {
            $dir = new DirectoryIterator(public_path($wordDirectory));
            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot()) {
                    $documentFiles[] = ViewHelper::getFileInfo($fileinfo->getFilename());
                }
            }
        }

        $documentFiles = array_reverse($documentFiles);

        return view('docs', compact('documentFiles'));
    }

    /**
     * Private
     */
}

