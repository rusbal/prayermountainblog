<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Name;
use App\Http\Requests;

class BlogController extends Controller
{
    public function index()
    {
        $published = Name::published()->first();

        return redirect('/article/' . $published->id);
    }

    public function view($articleId)
    {
        $published = Name::whereId($articleId)->with('latestRevision')->get();

        return view('blog.index', compact('published'));
    }
}
