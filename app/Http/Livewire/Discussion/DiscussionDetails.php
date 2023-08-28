<?php

namespace App\Http\Livewire\Discussion;

use App\Core\NotificationConstants;
use App\Core\PointsConstants;
use App\Jobs\CalculateUserPointsJob;
use App\Jobs\DispatchNotificationsJob;
use App\Models\Comment;
use App\Models\Discussion;
use App\Models\Like;
use Filament\Facades\Filament;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Livewire\Component;

class DiscussionDetails extends Component implements HasForms
{
    use InteractsWithForms;

    public Discussion $discussion;
    public int $likes = 0;
    public int $comments = 0;
    public bool $showComments = false;
    public Comment|null $comment = null;
    public bool $edit = false;
    public $selectedComment = null;

    protected $listeners = [
        'commentSaved',
        'doDeleteComment',
        'discussionEdited',
        'updateDiscussionCanceled',
        'doDeleteDiscussion'
    ];

    public function mount(): void
    {
        $this->form->fill();
        $this->initDetails();
    }

    public function render()
    {
        if (!$this->discussion) {
            $this->skipRender();
        }
        return view('livewire.discussion.discussion-details');
    }

    protected function getFormSchema(): array
    {
        return [
            Textarea::make('content')
                ->label(trans('forumium.comment_content'))
                ->required()
                ->rows(2)
                ->placeholder(trans('forumium.type_your_comment_here'))
                ->helperText( trans('forumium.you_can_write_a_comment_containing_up_to_char', ['value' => $i=300]))
                ->maxLength($i)
        ];
    }

    public function addComment(): void
    {
        $this->comment = new Comment();
        $this->form->fill();
    }

    public function editComment(Comment $comment): void
    {
        $this->comment = $comment;
        $this->form->fill([
            'content' => $comment->content
        ]);
    }

    public function cancelComment(): void
    {
        $this->comment = null;
        $this->form->fill();
    }

    public function deleteComment(int $comment): void
    {
        Notification::make()
            ->warning()
            ->title(trans('forumium.delete_confirmation'))
            ->body(trans('forumium.are_you_sure_you_want_to_delete_this_comment'))
            ->actions([
                Action::make('confirm')
                    ->label(trans('forumium.confirm'))
                    ->color('danger')
                    ->button()
                    ->close()
                    ->emit('doDeleteComment', ['comment' => $comment]),

                Action::make('cancel')
                    ->label(trans('forumium.cancel'))
                    ->close()
            ])
            ->persistent()
            ->send();
    }

    public function doDeleteComment(int $comment): void
    {
        $source = Comment::where('id', $comment)->first();
        if ($source) {
            $source->delete();
            $this->emit('commentSaved');

            dispatch(new CalculateUserPointsJob(user: $source->user, source: $source, type: PointsConstants::COMMENT_DELETED->value));
        }
    }

    public function saveComment(): void
    {
        $data = $this->form->getState();
        $isCreation = false;

        $this->comment->content = $data['content'];
        if (!$this->comment->id) {
            $this->comment->user_id = auth()->user()->id;
            $this->comment->source_id = $this->discussion->id;
            $this->comment->source_type = Discussion::class;

            $isCreation = true;
        }
        $this->comment->save();
        $this->emit('commentSaved');
        Filament::notify('success', trans('forumium.comment_successfully_saved'));

        if ($isCreation) {
            dispatch(new CalculateUserPointsJob(user: auth()->user(), source: $this->comment, type: PointsConstants::NEW_COMMENT->value));
            dispatch(new DispatchNotificationsJob(auth()->user(), NotificationConstants::POST_IN_DISCUSSION->value, $this->discussion));
            dispatch(new DispatchNotificationsJob(auth()->user(), NotificationConstants::MY_POSTS_COMMENTED->value, $this->comment));
        }
    }

    public function commentSaved(): void
    {
        $this->cancelComment();
        $this->discussion->refresh();
        $this->initDetails();
    }

    private function initDetails(): void
    {
        $this->likes = $this->discussion->likes()->count();
        $this->comments = $this->discussion->comments()->count();
    }

    public function toggleLike(): void
    {
        $like = Like::where('user_id', auth()->user()->id)->where('source_id', $this->discussion->id)->where('source_type', Discussion::class)->first();
        if ($like) {
            $pointsType = PointsConstants::DISCUSSION_DISLIKED->value;
            $source = $like;

            $like->delete();
        } else {
            $pointsType = PointsConstants::DISCUSSION_LIKED->value;
            $source = Like::create([
                'user_id' => auth()->user()->id,
                'source_id' => $this->discussion->id,
                'source_type' => Discussion::class
            ]);
            dispatch(new DispatchNotificationsJob(auth()->user(), NotificationConstants::MY_POSTS_LIKED->value, $source));
        }
        $this->discussion->refresh();
        $this->initDetails();
        $this->emit('likesUpdated', $source->source_id);

        dispatch(new CalculateUserPointsJob(user: $source->source->user, source: $source, type: $pointsType));
    }

    public function toggleCommentLike(int $comment): void
    {
        $like = Like::where('user_id', auth()->user()->id)->where('source_id', $comment)->where('source_type', Comment::class)->first();
        if ($like) {
            $pointsType = PointsConstants::COMMENT_DISLIKED->value;
            $source = $like;

            $like->delete();
        } else {
            $pointsType = PointsConstants::COMMENT_LIKED->value;
            $source = Like::create([
                'user_id' => auth()->user()->id,
                'source_id' => $comment,
                'source_type' => Comment::class
            ]);
            dispatch(new DispatchNotificationsJob(auth()->user(), NotificationConstants::MY_POSTS_LIKED->value, $source));
        }
        $this->discussion->refresh();
        $this->emit('likesUpdated', $source->source_id);

        dispatch(new CalculateUserPointsJob(user: $source->source->user, source: $source, type: $pointsType));
    }

    public function toggleComments(): void
    {
        $this->showComments = !$this->showComments;
        if ($this->showComments) {
            $this->dispatchBrowserEvent('discussionCommentsLoaded');
        }
    }

    public function editDiscussion(): void
    {
        $this->edit = true;
    }

    public function discussionEdited(): void
    {
        $this->discussion->refresh();
        $this->edit = false;
    }

    public function updateDiscussionCanceled(): void
    {
        $this->edit = false;
    }

    public function deleteDiscussion(): void
    {
        Notification::make()
            ->warning()
            ->title(trans('forumium.delete_confirmation'))
            ->body(trans('forumium.are_you_sure_you_want_to_delete_this_discussion'))
            ->actions([
                Action::make('confirm')
                    ->label(trans('forumium.confirm'))
                    ->color('danger')
                    ->button()
                    ->close()
                    ->emit('doDeleteDiscussion', ['discussion' => $this->discussion->id]),

                Action::make('cancel')
                    ->label(trans('forumium.cancel'))
                    ->close()
            ])
            ->persistent()
            ->send();
    }

    public function doDeleteDiscussion(int $discussion): void
    {
        $source = Discussion::where('id', $discussion)->first();
        if ($source) {
            $source->delete();
            Filament::notify('success', trans('forumium.discussion_deleted_successfully'), true);
            dispatch(new CalculateUserPointsJob(user: $source->user, source: $source, type: PointsConstants::DISCUSSION_DELETED->value));
            $this->redirect(route('home'));
        }
    }

    public function selectComment(int $comment)
    {
        $this->selectedComment = $this->discussion->comments()->where('id', $comment)->first();
        $this->dispatchBrowserEvent('discussionCommentSelected', [
            'id' => $comment
        ]);
    }
}
