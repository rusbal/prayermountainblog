<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Gate;
use Auth;
use App\Http\Requests;

use App\Name;
use App\Comment;
use App\User;
use App\Revision;


class RevisionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', array('except' => 'index'));
    }

    public function index(Name $name)
    {
        $revision = $name->latestRevision;

        return $this->viewEdit($name, $revision);
    }

    public function edit(Name $name, Revision $revision)
    {
        return $this->viewEdit($name, $revision);
    }

    public function update(Name $name, Revision $revision, Request $request)
    {
        $isNewRevision = $request->revision_title != '';

        if ($isNewRevision) {
            return $this->saveNewRevision($name, $request);
        } else {
            return $this->updateRevision($revision, $request);
        }
    }

    public function destroy(Name $name, Revision $revision)
    {
        if (Gate::denies('update-revision', $revision)) {
            abort(403, 'Sorry, you cannot delete the revision of other authors.');
        }

        $revision->delete();

        if ($this->deleteNameIfOrphaned($name)) {
            return redirect()->route('names')->with('status', "<b>Name '{$revision->name}:{$revision->revision_title}'</b> was successfully deleted.");
        }

        return redirect()->action(
            'RevisionController@index', [$name->id]
        )->with('status', "Revision '{$revision->revision_title}' was successfully deleted.");
    }

    public function editAuthorRevision($nameId, $authorId)
    {
        $revision = User::latestRevisionOnName($authorId, $nameId);

        return redirect()->action( 'RevisionController@edit', [$nameId, $revision->id]);
    }

    /**
     * Private
     */
    private function deleteNameIfOrphaned($name)
    {
        if (is_null($name->latestRevision)) {
            $name->delete();
            return true;
        }
        return false;
    }

    private function saveNewRevision($name, $request)
    {
        $message = 'Saved to revision: ' . $request->get('revision_title');
        $revision = $name->createRevision($request->all());

        return redirect()->action(
            'RevisionController@edit', [$name->id, $revision->id]
        )->with('status', $message);
    }

    private function updateRevision($revision, $request)
    {
        if (Gate::denies('update-revision', $revision)) {
            abort(403, 'Sorry, you cannot update the revision of other authors.');
        }

        $message = 'Updated revision: ' . $revision->revision_title;

        /**
         * Keep revision_title by not including it on mass assigned replacement.
         */
        $revision->update(
            $this->removeRevisionTitle($request->all())
        );

        return redirect()->back()->with('status', $message); 
    }

    private function removeRevisionTitle($arr)
    {
        unset($arr['revision_title']);
        return $arr;
    }

    private function viewEdit($name, $revision)
    {
        $authors = Revision::authorsOnNameId($name->id);
        $isOwner = Auth::user()->id == $revision->user_id;
        $comments = Comment::forName($name->id);

        return view('revision.edit', compact('name', 'revision', 'authors', 'isOwner', 'comments'));
    }
}
