<div class="card border border-base-300">
    <div class="card-body bg-base-200 text-1xl">
        <h4 class="card-title">{{ $user->name }}</h4>
    </div>
    <figure>
        {{-- ユーザのメールアドレスをもとにGravatarを取得して表示 --}}
        <img src="{{ Gravatar::get($user->email, ['size' => 250]) }}" alt="">
    </figure>
</div>
{{-- フォロー／アンフォローボタン --}}
@include('user_follow.follow_button')
