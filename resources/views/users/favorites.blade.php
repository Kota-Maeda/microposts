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
                        <a>User name:</a>{{ $user->content }}
                        {{ $user->name }} </p>
                        {{ $favorites->content }}
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@endif