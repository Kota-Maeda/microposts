<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FavoritesController extends Controller
{
    //$idの投稿をお気に入りするアクション
    public function store($id)
    {
        //認証済みユーザが$idの投稿をお気に入りにする
        \Auth::user()->favorite($id);
        //前のURLへリダイレクトさせる
        return back();
    }
    
    //$idの投稿のお気に入りを外す
    public function destroy($id)
    {
        //認証済みユーザがidの投稿のお気に入りを外す
        \Auth::user()->unfavorite($id);
        //前のURLへリダイレクトさせる
        return back();
    }
    
        
    //お気に入りの数をカウントする
    public function CountFavotites()
    {
        $this->loadCount('favorites', 'favoriting', 'favoritedBy');
    }
    
    public function favorites($id)
    {
        $posts = User::findOrFail($id);
        
        //関係するモデルの件数をロード
        $posts->leadRelationshipCounts();
        
        //お気に入り一覧を取得
        $favoritings = $posts->favoritings()->paginate(10);
        
        return view('favorites.favorite',['posts' => $posts]);
    }
    
    /*
    public function index()
    {
        $data = [];
        if(\Auth::check()){ //認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿一覧を作成日時の降順で取得
            $microposts = $user->favoriting()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'user' => $user,
                'microposts' => $microposts,
                ];
        }
        
        //dashboardビューでそれらを表示
        return view('dashboard', $data);
    }
    */
    
}
