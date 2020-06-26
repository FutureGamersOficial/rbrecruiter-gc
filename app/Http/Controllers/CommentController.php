<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\NewCommentRequest;

use App\Comment;
use App\Application;
use App\Notifications\NewComment;
use App\User;

class CommentController extends Controller
{

    public function index()
    {
        //
    }

    public function insert(NewCommentRequest $request, Application $application)
    {
        // Type hinting makes laravel automatically validate everything

        $comment = Comment::create([
            'authorID' => Auth::user()->id,
            'applicationID' => $application->id,
            'text' => $request->comment
        ]);

        if ($comment)
        {

            foreach (User::all() as $user)
            {
              if ($user->isStaffMember())
              {
                $user->notify(new NewComment($comment, $application));
              }
            }

            $request->session()->flash('success', 'Comment posted! (:');
        }
        else
        {
            $request->session()->flash('error', 'Something went wrong while posting your comment!');
        }

        return redirect()->back();

    }

    public function delete(Request $request, Comment $comment)
    {
        if (Auth::user()->is($comment->user) || Auth::user()->hasRole('admin'))
        {
            $comment->delete();
            $request->session()->flash('success', 'Comment deleted!');
        }

        $request->session()->flash('error', 'You do not have permission to delete this comment!');

        return redirect()->back();

    }

}
