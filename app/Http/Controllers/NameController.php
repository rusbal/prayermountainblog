<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\NameFormRequest;

use Auth;
use App\Name;
use App\Revision;
use App\User;
use App\ViewHelper;

class NameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', array('except' => 'index'));
    }

    public function index()
    {
        $names = Name::with('latestRevision')->ordered();
        $users = User::colors();
        $revision_count = Revision::revisionUserCount();

        return view('names.index', compact('names', 'users', 'revision_count'));
    }

    public function create()
    {
        return view('names.create');
    }

    public function store(NameFormRequest $request)
    {
        $name = Name::createAndInitRevision($request->get('name'));

        return redirect('/names/new')->with('status', 'Newly added: ' . $request->get('name')); 
    }

    public function setStatus(Name $name, Request $request)
    {
        $name->status = $request->status;

        if ($name->save()) {

            $helper = new ViewHelper;

            return response()->json([ 
                'status' => $request->status,
                'html'   => $helper->statusButtonSelection($request->status, 'update-status')
            ], 200);
        }

        return response()->json([ 'order' => 'Processing error.' ], 422);
    }
}
