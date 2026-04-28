<div class="gap-4">
    <a href={{ url()->previous() }}>Back</a>

    @if (session('success'))
        <div style="padding: 20px; background-color: #4CAF50; color: white; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="/new/creating">
        @csrf

        <h1>Buat Post</h1>

        <textarea name="text_content"></textarea>

        <button type="submit">Submit</button>
    </form>
</div>
