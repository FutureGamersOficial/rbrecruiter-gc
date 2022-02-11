<?php


namespace App\Services;


use App\Application;
use App\Comment;
use Illuminate\Support\Facades\Auth;

class CommentService
{

    public function addComment(Application $application, $comment): Comment {
        return Comment::create([
            'authorID' => Auth::user()->id,
            'applicationID' => $application->id,
            'text' => $comment,
        ]);
    }

    public function deleteComment(Comment $comment): ?bool
    {
        return $comment->delete();
    }

}
