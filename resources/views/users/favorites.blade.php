

@if (isset($favorite))
    <ul class="list-none">
        @foreach ($favorite as $favorites)
            <li class="flex items-center gap-x-2 mb-4">
                {{-- ユーザのメールアドレスをもとにGravatarを取得して表示 --}}
                <div class="avatar">
                    <div class="w-12 rounded">
                        <img src="{{ Gravatar::get($user->email) }}" alt="" />
                    </div>
                </div>
                <div>
                    <div>
                        <a class="link link-hover text-info" href="{{ route('users.show', $user->name) }}">{{ $user->name }}</a>
                        <span class="text-muted text-gray-500">{{ $favorites->created_at }}に投稿されました</span>
                        {{-- ユーザ詳細ページへのリンク --}}
                    </div>
                    <div>
                        {{ $favorites->content }}
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@endif