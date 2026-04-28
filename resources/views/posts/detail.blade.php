<div class="p-6">
    <a href={{ url()->previous() }}>Back</a>

    <p>{{ $post->text_content }}</p>

    <hr>

    <a href={{ '/post/' . $post->id . '/update' }}>Update</a>

    <form action={{ '/post/' . $post->id }} method="POST" onsubmit="return confirm('Yakin hapus post ini?');">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
</div>
