
    @if (Auth::user()->is_favoriting($micropost->id))
        {{--  お気に入り外すボタンのフォーム --}}
        <form method="POST" action="{{ route('favorites.unfavorite', $micropost->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-error btn-block normal-case" onclick="return confirm('id = {{ $micropost->id }} の お気に入りを外します。よろしいですか？')">お気に入りを外すあああああ</button>
        </form>
    @else
        {{-- お気に入りボタンのフォーム --}}
        <form method="POST" action="{{ route('favorites.favorite', $micropost->id) }}">
            @csrf
            <button type="submit" class="btn btn-primary btn-block normal-case">お気に入り</button>
        </form>
    @endif

