<?php
/**
 * Plain Object: ViewHelper
 */

namespace App;

use Auth;
use App\User;

class ViewHelper
{
    public function initGlobalJsVars($name)
    {
        $array = array(
            'csrfToken' => csrf_token(), 
            'user'      => Auth::user(),
        );

        if (isset($name)) {
            $array['name'] = $name;
        }

        echo "
            window.Laravel = " . json_encode($array) . "
        ";
    }

    public function latestActivity($revision)
    {
        $action = ($revision->created_at == $revision->updated_at ? 'created' : 'updated');

        return "{$revision->updated_at->format('d.M hA')} $action by {$this->coloredAuthorName($revision)}";
    }

    static public function getFileInfo($filePath)
    {
        $initials = current(explode('-', $filePath, 2));
        $parts    = explode('.', $filePath);
        $created_at = $parts[count($parts) - 2];
        
        $fileInfo = array(
            'user'     => User::whereInitials($initials)->first(),
            'filepath' => $filePath,
            'time_elapsed' => \Carbon\Carbon::createFromTimestamp($created_at)->diffForHumans(),
            'is_newly_created' => ((time() - $created_at) / 60) < 2,
        );

        return $fileInfo;
    }

    public function revisionCount($nameId, $userIds)
    {
        return Revision::whereNameId($nameId)->whereIn('user_id', $userIds)->withCount('user')->get();
    }

    public function statusToBootstrap($status, $prefix = '')
    {
        $array = array(
            'Not started' => 'default',
            'Started'     => 'warning',
            'In progress' => 'info',
            'For review'  => 'success',
            'Reviewed'    => 'danger',
            'Published'   => 'primary',
        );
        return $prefix . $array[$status];
    }

    public function coloredStatusClass($status, $prefix = 'btn-')
    {
        return $this->statusToBootstrap($status, $prefix);
    }

    public function coloredStatus($status)
    {
        return '<span class="label label-' . $this->statusToBootstrap($status) . '">' . $status . '</span>';
    }

    public function statusButtonSelection($currentStatus, $class)
    {
        return '
            <div id="' . $class . '" class="btn-group">
                <button type="button" class="btn '. $this->coloredStatusClass($currentStatus) .' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Status: <b>' . $currentStatus . '</b> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    ' . $this->statusLiSelection( Name::getEnumValuesExcept('status', $currentStatus), $class) . '
                </ul>
            </div>
        ';
    }

    public function statusLiSelection($statuses, $class)
    {
        $html = '';
        foreach ($statuses as $status) {
            $html .= '
                <li><a href="#" onclick="return false" class="' . $class . '">' . $status . '</a></li>';
        }
        return $html;
    }

    public function listComments($comment_on, $data, $class = 'hidden', $style = 'warning')
    {
        $hidden = $class == 'hidden' ? ' style="display:none" ' : '';
        $authUserId = Auth::user()->id;

        $lis = '';
        if ($data) {
            foreach ($data as $datum) {

                $closeBtn = ($authUserId == $datum->user->id)
                    ? '<span aria-hidden="true">&times;</span>'
                    : '<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>';

                $lis .= '
                    <!-- One Comment -->
                    <li class="list-group-item list-group-item-warning" data-id="'. $datum->id .'" ' . $hidden . '>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">' . $closeBtn . '</button>
                        <span class="label" style="background:' . $datum->user->color . '">' . $datum->user->initials . '</span>
                        <small>'. nl2br($datum->comment) .'</small>
                    </li>';
            }
        }

        $addCommentForm = '
                <!-- Comment Entry Form -->
                <li class="list-group-item list-group-item-warning clearfix">
                    <span class="label" style="background:' . Auth::user()->color . '">' . Auth::user()->initials . '</span>
                    <div class="pull-right">
                        <small class="message hidden"> Processing... </small>
                        <button class="btn btn-xs btn-warning add-comment-btn">Add Comment</button>
                    </div>
                    <textarea class="form-paper-control" data-comment-on="' . $comment_on . '" style="display:none"></textarea>
                </li>';

        return '
            <ul class="list-group comments" ' . $hidden . '>' . $lis . $addCommentForm . '</ul>';
    }

    public function seeCommentButton($comments, $style = 'default')
    {
        $count = count($comments);

        return '
            <button type="button" class="btn btn-' . $style . ' btn-xs see-comment-button" data-count="' . $count . '">
                ' . ($count == 0 ? 'Comment' : $count . ' Comments') . '
            </button>';
    }

    /**
     * Private
     */
    private function coloredAuthorName($revision)
    {
        $user = $revision->user;

        return "<span style='color:{$user->color}'> {$user->name} </span>";
    }
}

