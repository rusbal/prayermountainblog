<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $guarded = ['id'];

    public function parent_name()
    {
        return $this->belongsTo('App\Name');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Static
     */
    static public function authorsOnNameId($nameId, $limit = 6)
    {
        $authors = [];

        $authorIds = Revision::select('user_id')->whereNameId($nameId)->pluck('user_id')->unique();

        foreach ($authorIds as $authorId) {
            $authors[] = Revision::with('user')
                ->whereNameId($nameId)
                ->whereUserId($authorId)
                ->orderBy('updated_at', 'desc')
                ->orderBy('id', 'desc')
                ->limit($limit)->get();
        }

        return $authors;
    }

    static public function revisionUserCount()
    {
        $name_revisions = [];

        $revisions = Revision::select(\DB::raw('name_id, user_id, count(*) as count'))->groupBy(['name_id', 'user_id'])->get();

        foreach ($revisions as $revision) {
            $name_id = $revision->name_id;
            $user_id = $revision->user_id;
            $count   = $revision->count;

            if (!isset($name_revisions[$name_id])) {
                $name_revisions[$name_id] = [];
            }
            $name_revisions[$name_id][$user_id] = $count;
        }

        return $name_revisions;
    }
}
