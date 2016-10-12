<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use EnumTrait;

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
    static public function forName($nameId)
    {
        $comments = Comment::whereNameId($nameId)
            ->with('user')
            ->orderBy('comment_on')
            ->orderBy('updated_at')
            ->orderBy('id')
            ->get();

        $grouped = array();

        foreach ($comments as $comment) {
            $grouped[$comment->comment_on][] = $comment;
        }

        return $grouped;
    }
}
