<div class="p-6 flex flex-col gap-2">
    <a href="/new">New Post</a>

    @guest
    <a href="/login">Login</a>
    <a href="/register">Register</a>
    @endguest

    @auth
        <form method="POST" action="/logout">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @endauth

    <hr>

    @foreach ($posts as $post)
        <p>{{ $post->text_content }}</p>
        <a href={{ '/post/' . $post->id }}>Lihat</a>
    @endforeach
</div>
