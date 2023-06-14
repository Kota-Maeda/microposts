<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
{
    //ユーザーをフォローするアクション
    public function store($id)
    {
        // 認証済みのユーザ（閲覧者）が、idのユーザをフォローする
        \Auth::user()->folow($id);
        //前のURLへリダイレクトさせる
        return back;
    }
    
    //ユーザをアンフォローするアクション
    public function destroy($id)
    {
        //認証済みのユーザ(閲覧者)が、idのユーザをアンフォローする
        \Auth::user()->unfollow($id);
        //前のURLへリダイレクトさせる
        return back();
    }
}
