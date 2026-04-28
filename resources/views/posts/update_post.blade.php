<div class="gap-4">
    <a href={{ url()->previous() }}>Back</a>

    <form method="POST" action={{ '/post/' . $post->id . '/updating' }}>
        @csrf
        @method('PUT')

        <h1>Buat Post</h1>

        <textarea name="text_content">{{ $post->text_content }}</textarea>

        <button type="submit">Submit</button>
    </form>
</div>
