@extends('layouts.app')

@section('content')
    <div class="sm:grid sm:grid-cols-3 sm:gap-10">
        <aside class="mt-4">
            {{-- ユーザ情報 --}}
            @include('users.card')
        </aside>
        <div class="mt-4">
            @if (isset($favorites))
                <ul class="list-none">
                    @foreach ($favoritess as $micropost)
                    <div>
                        {{ $favoriting->name }}
                    </div>
                    @endforeach
                </ul>
                {{-- ページネーションのリンク --}}
                {{ $microposts->links() }}
            @endif
        </div>
    </div>
@endsection