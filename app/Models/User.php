<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Micropost;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    // この投稿を所有するユーザ(Userモデルとの関係を定義)
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
    
    // このユーザに関係するモデルの件数をロードする
    public function loadRelationshipCounts()
    {
        $this->loadCount('microposts');
    }
    
    // このユーザがフォロー中のユーザ（Userモデルとの関係を定義
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }
    
    // このユーザがフォロー中のユーザ（Userモデルとの関係を定義
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }

    
    // $userIdで指定されたユーザをフォローする
    public function follow($userId)
    {
        $exist = $this->is_following($userId);
        $its_me = $this->id == $userId;
        
        if ($exist || $its_me) {
            return false;
        } else {
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    //$userIdで指定されたユーザをアンフォローする
    public function unfollow($userId)
    {
        $exist = $this->is_following($userId);
        $its_me = $this->id == $userId;
        
        if($exist && !$its_me) {
            $this->followings()->detach($userId);
            return true;
        }
        else{
            return false;
        }
    }
    
    // 指定された$userIdのユーザをこのユーザがフォロー中であるか調べる。フォロー中ならtrueを返す。
    public function is_following($userId)
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    /*
    public function leadRelationshipCounts()
    {
        $this->loadCount(['microposts', 'followings', 'followers']);
    }
    */
    // このユーザとフォロー中のユーザの投稿に絞り込む
    public function feed_microposts()
    {
        //このユーザがフォロー中のユーザのidを取得して配列にする
        $userIds = $this->followings()->pluck('users.id')->toArray();
        //このユーザのidも配列に追加
        //それらのユーザが所有する投稿に絞り込む
        return Micropost::whereIn('user_id', $userIds);
    }
    
        
    //このユーザがお気に入りにしている投稿
    public function favoriting()
    {
        return $this->belongsToMany(Micropost::class, 'favorites', 'user_id', 'micropost_id')->withTimestamps();
    }
    
    //この投稿をお気に入りにしているユーザ
    public function favoritedBy()
    {
        return $this->belongsToMany(Micropost::class, 'favorites', 'micropost_id', 'user_id')->withTimestamps();
    }
    
    // $micropostIdで指定された投稿をお気に入りに追加する
    public function favorite($micropostId)
    {
        $exist = $this->is_favoriting($micropostId);
        //$its_me = $this->id == $micropostId;
        
        if($exist){
            return false;
        }else {
            $this->favoriting()->attach($micropostId);
            return true;
        }
    }
    
    // $micropostIdで指定された投稿をお気に入りから削除する
    public function unfavorite($micropostId)
    {
        $exist = $this->is_favoriting($micropostId);
        //$its_me = $this->id == $userId;
        
        if($exist){
            $this->favoriting()->detach($micropostId);
            return true;
        } else{
            return false;
        }
    }

    // 指定された$micropostIdの投稿がユーザのお気に入りかどうか調べる　
    public function is_favoriting($micropostId)
    {
        return $this->favoriting()->where('micropost_id', $micropostId)->exists();
    }
        
    public function leadRelationshipCounts()
    {
        $this->loadCount(['microposts', 'followings', 'followers', 'favoriting', 'favoritedBy']);
    }
    /*
    public function feed_favorites($userId)
    {
        
        $userFavorites = $this->favoritings()->where('user_id', $userId)->toArray();
        
        return $userFavorites;
    }
    
     // 指定された$micropostIdの投稿がユーザのお気に入りかどうか調べる　
    public function is_favoriting($micropostId)
    {
        $userFavorites = feed_favorites($micropost);
        return $this->favoriting()->where('micropost_id', $micropostId)->exists();
    }
    */
    
}