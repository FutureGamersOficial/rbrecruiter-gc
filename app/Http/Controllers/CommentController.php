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
        $this->authorize('create', Comment::class);
        
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
        $this->authorize('delete', $comment);

        $comment->delete();
        $request->session()->flash('success', 'Comment deleted!');

        return redirect()->back();

    }

}
