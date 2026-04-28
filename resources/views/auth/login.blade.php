<div class="p-6">
    <h1>Login</h1>

    <form method="POST" action="/login">
        @csrf

        <div>
            <label for="login">Username atau Email</label>
            <input id="login" name="login" type="text" value="{{ old('login') }}" required>
            @error('login') <div>{{ $message }}</div> @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
            @error('password') <div>{{ $message }}</div> @enderror
        </div>

        <button type="submit">Login</button>
    </form>
</div>
