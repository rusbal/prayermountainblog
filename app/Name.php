<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Name extends Model
{
    use EnumTrait;

    protected $guarded = ['id'];

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->get();
    }

    public function scopePublished($query)
    {
        return $query->whereStatus('Published');
    }

    public function revisions()
    {
        return $this->hasMany(Revision::class);
    }

    public function latestRevision()
    {
        return $this->hasOne(Revision::class)
            ->orderBy('updated_at', 'desc')
            ->orderBy('id', 'desc');
    }

    public function createRevision($data)
    {
        $data['user_id'] = \Auth::user()->id;

        return $this->revisions()->create($data);
    }

    /**
     * Static
     */
    static public function createAndInitRevision($name = null)
    {
        if (!$name) {
            return;
        }

        parent::create([])->init_revision($name);
    }

    static public function updateSort($nameIds)
    {
        DB::beginTransaction();
        $order_arr = Name::saveOrderArray($nameIds);

        if ($order_arr === false) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return $order_arr;
    }

    /**
     * Private
     */
    static private function saveOrderArray($nameIds)
    {
        $order_arr = [];
        $order = Name::whereIn('order', $nameIds)->min('order');

        foreach ($nameIds as $id) {
            $success = Name::whereId($id)->update(['order' => $order]);

            if (!$success) {
                return false;
            }

            $order_arr[] = $order;
            $order += 1;
        }
        return $order_arr;
    }

    private function init_revision($name)
    {
        $data = array(
            'revision_title'   => 'First Draft',
            'name'             => $name,
            'verse'            => '',
            'meaning_function' => '',
            'identical_titles' => '',
            'significance'     => '',
            'responsibility'   => '',
            'user_id'          => \Auth::user()->id,
        );
        return $this->revisions()->create($data);
    }
}
