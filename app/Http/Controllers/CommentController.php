<?php

/*
 * Copyright © 2020 Miguel Nogueira
 *
 *   This file is part of Raspberry Staff Manager.
 *
 *     Raspberry Staff Manager is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     Raspberry Staff Manager is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with Raspberry Staff Manager.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Http\Controllers;

use App\Application;
use App\Comment;
use App\Http\Requests\NewCommentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'text' => $request->comment,
        ]);

        if ($comment) {
            $request->session()->flash('success', __('Comment posted! (:'));
        } else {
            $request->session()->flash('error', __('Something went wrong while posting your comment!'));
        }

        return redirect()->back();
    }

    public function delete(Request $request, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();
        $request->session()->flash('success', __('Comment deleted!'));

        return redirect()->back();
    }
}
