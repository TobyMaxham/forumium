<?php

namespace App\Http\Livewire\Discussion;

use App\Core\NotificationConstants;
use App\Core\PointsConstants;
use App\Jobs\CalculateUserPointsJob;
use App\Jobs\DispatchNotificationsJob;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Reply;
use Filament\Facades\Filament;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Livewire\Component;

class ReplyDetails extends Component implements HasForms
{
    use InteractsWithForms;

    public Reply $reply;
    public int $likes = 0;
    public int $comments = 0;
    public bool $edit = false;
    public bool $showComments = false;
    public Comment|null $comment = null;
    public $selectedComment = null;

    protected $listeners = [
        'doDelete',
        'doDeleteReplyComment',
        'replyCommentSaved'
    ];

    public function mount(): void
    {
        $this->initDetails();
    }

    public function render()
    {
        return view('livewire.discussion.reply-details');
    }

    private function initDetails(): void
    {
        $this->likes = $this->reply->likes()->count();
        $this->comments = $this->reply->comments()->count();
    }

    public function toggleLike(): void
    {
        $like = Like::where('user_id', auth()->user()->id)->where('source_id', $this->reply->id)->where('source_type', Reply::class)->first();
        if ($like) {
            $pointsType = PointsConstants::REPLY_DISLIKED->value;
            $source = $like;

            $like->delete();
        } else {
            $pointsType = PointsConstants::REPLY_LIKED->value;
            $source = Like::create([
                'user_id' => auth()->user()->id,
                'source_id' => $this->reply->id,
                'source_type' => Reply::class
            ]);
            dispatch(new DispatchNotificationsJob(auth()->user(), NotificationConstants::MY_POSTS_LIKED->value, $source));
        }
        $this->reply->refresh();
        $this->initDetails();
        $this->emit('likesUpdated', $source->source_id);

        dispatch(new CalculateUserPointsJob(user: $source->source->user, source: $source, type: $pointsType));
    }

    public function delete(): void
    {
        Notification::make()
            ->warning()
            ->title(trans('forumium.delete_confirmation'))
            ->body(trans('forumium.are_you_sure_you_want_to_delete_this_reply'))
            ->actions([
                Action::make('confirm')
                    ->label(trans('forumium.confirm'))
                    ->color('danger')
                    ->button()
                    ->close()
                    ->emit('doDelete', ['reply' => $this->reply->id]),

                Action::make('cancel')
                    ->label(trans('forumium.cancel'))
                    ->close()
            ])
            ->persistent()
            ->send();
    }

    public function doDelete(int $reply): void
    {
        $source = Reply::where('id', $reply)->first();
        if ($source) {
            $source->delete();
            $this->emit('replyDeleted');
            dispatch(new CalculateUserPointsJob(user: $source->user, source: $source, type: PointsConstants::REPLY_DELETED->value));
        }
    }

    public function edit(): void
    {
        $this->edit = true;
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
                    ->emit('doDeleteReplyComment', ['comment' => $comment]),

                Action::make('cancel')
                    ->label(trans('forumium.cancel'))
                    ->close()
            ])
            ->persistent()
            ->send();
    }

    public function doDeleteReplyComment(int $comment): void
    {
        $source = Comment::where('id', $comment)->first();
        if ($source) {
            $source->delete();
            $this->emit('replyCommentSaved');
            dispatch(new CalculateUserPointsJob(user: $source->user, source: $source, type: PointsConstants::COMMENT_DELETED->value));
        }
    }

    public function saveComment(): void
    {
        $data = $this->form->getState();
        $this->comment->content = $data['content'];
        $isCreation = false;

        if (!$this->comment->id) {
            $this->comment->user_id = auth()->user()->id;
            $this->comment->source_id = $this->reply->id;
            $this->comment->source_type = Reply::class;

            $isCreation = true;
        }
        $this->comment->save();
        $this->emit('replyCommentSaved', $this->reply->id);
        Filament::notify('success', trans('forumium.comment_successfully_saved'));

        if ($isCreation) {
            dispatch(new CalculateUserPointsJob(user: auth()->user(), source: $this->comment, type: PointsConstants::NEW_COMMENT->value));
            dispatch(new DispatchNotificationsJob(auth()->user(), NotificationConstants::MY_POSTS_COMMENTED->value, $this->comment));
        }
    }

    public function commentSaved(): void
    {
        $this->cancelComment();
        $this->reply->refresh();
        $this->initDetails();
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
        $this->reply->refresh();
        $this->emit('likesUpdated', $source->source_id);

        dispatch(new CalculateUserPointsJob(user: $source->source->user, source: $source, type: $pointsType));
    }

    public function toggleComments(): void
    {
        $this->showComments = !$this->showComments;
        if ($this->showComments) {
            $this->dispatchBrowserEvent('replyCommentsLoaded');
        }
    }

    public function replyCommentSaved(): void
    {
        $this->reply->refresh();
    }

    public function toggleBestFlag(): void
    {
        $this->reply->is_best = !$this->reply->is_best;
        $this->reply->save();
        $this->reply->refresh();

        $pointsType = $this->reply->is_best ? PointsConstants::BEST_REPLY : PointsConstants::BEST_REPLY_REMOVED;
        dispatch(new CalculateUserPointsJob(user: $this->reply->user, source: $this->reply, type: $pointsType));

        if ($this->reply->is_best) {
            dispatch(new DispatchNotificationsJob(auth()->user(), NotificationConstants::MY_REPLY_BEST_ANSWER->value, $this->reply));
        }
    }

    public function selectComment(int $comment)
    {
        $this->selectedComment = $this->reply->comments()->where('id', $comment)->first();
        $this->dispatchBrowserEvent('replyCommentSelected', [
            'id' => $comment
        ]);
    }
}
