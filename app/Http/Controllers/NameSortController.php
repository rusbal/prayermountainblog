<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Name;
use App\Http\Requests;

class NameSortController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request)
    {
        // $this->validate($request, 
        //     [ 'order'  => 'required|sort10' ], 
        //     [ 'sort10' => 'Invalid input for sorting.' ]
        // );

        if ($request->ajax()) {
            $result = Name::updateSort($request->order);

            if ($result === false) {
                return response()->json([ 'order' => 'Processing error.' ], 422);
            }

            return response()->json([ 'order' => $result ], 200);
        }
    }
}
