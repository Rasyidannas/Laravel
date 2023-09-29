<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Jobs\ThrottledMail;
use App\Mail\CommentPostedMarkdown;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUsersAboutComment
{
    /**
     * Handle the event.
     */
    public function handle(CommentPosted $event): void
    {
        ThrottledMail::dispatch(new CommentPostedMarkdown($event->comment), $event->comment->commentable->user)
            ->onQueue('low');

        NotifyUsersPostWasCommented::dispatch($event->comment)
            ->onQueue('high');
    }
}
