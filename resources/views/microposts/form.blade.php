@if (Auth::id() == $user->id)
    <div class="mt-4">
        <form method="POST" action="{{ route('microposts.store') }}">
            @csrf
            <table>
                <tr>
                    <td><img src="{{ Gravatar::get($user->email, ['size' => 50]) }}" alt=""></td>
                    <td>　いまどうしてる？</td>
                </tr>
            </table>
            </form>
            <div class="form-control mt-4" style="padding: 10px;">
                <textarea rows="5" name="content" class="input input-bordered" style="height:100px;"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block normal-case background=green;">投稿</button>
        </form>
    </div>
@endif