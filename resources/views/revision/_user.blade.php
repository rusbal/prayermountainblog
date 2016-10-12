@inject('helper', 'App\ViewHelper')

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="well well-sm clearfix">
                <div class="pull-left">
                    Revision: <strong id="revision-title">{{ $revision->revision_title }}</strong><br>
                    <small>{!! $helper->latestActivity($revision) !!}</small>
                </div>

                <div class="pull-right">
                    @foreach ($authors as $authorRevisions)

                        <!-- Single button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="color:{{ $authorRevisions[0]->user->color }}"> 
                                {{ $authorRevisions[0]->user->name }} <span class="caret"></span>
                            </button>

                            <ul class="dropdown-menu">

                            @foreach ($authorRevisions as $key => $revision)
                                @if ($key == 1) <li role="separator" class="divider"></li> @endif
                                <li> 
                                    <a href="{{ route('revision', [$revision->name_id, $revision->id]) }}">
                                        @if ($loop->first) <b> @endif {{ $revision->revision_title }} @if ($loop->first) </b> @endif
                                        <small style="color:{{ $revision->user->color }}">{{ $revision->updated_at->diffForHumans() }}</small></a>
                                </li>
                            @endforeach

                            </ul>
                        </div>
                        
                    @endforeach

                    <div class="btn-group buttons-group">

                    @if ($isOwner)
                        <button type="button" class="btn btn-primary disabled" id="menu-submit-save">Save</button>
                        <button type="button" class="btn btn-primary dropdown-toggle disabled" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" onclick="return false" class="submit-new-revision">Save as new revision</a></li>
                        </ul>
                    @else
                        <button type="button" class="btn btn-primary disabled submit-new-revision">Save as new revision</button>
                    @endif

                    </div>

                    {!! $helper->statusButtonSelection($name->status, 'update-status') !!} 
                </div>
            </div>
        </div>
    </div>
