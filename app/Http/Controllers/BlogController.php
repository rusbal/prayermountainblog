<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Name;
use App\Http\Requests;

class BlogController extends Controller
{
    public function index()
    {
        $published = Name::published()->with('latestRevision')->get();

        return view('blog.index', compact('published'));
    }
}
