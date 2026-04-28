<div class="p-6">
    <h1>Register</h1>

    <form method="POST" action="/register">
        @csrf

        <div>
            <label for="name">Nama</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required>
            @error('name') <div>{{ $message }}</div> @enderror
        </div>

        <div>
            <label for="username">Username</label>
            <input id="username" name="username" type="text" value="{{ old('username') }}" required>
            @error('username') <div>{{ $message }}</div> @enderror
        </div>

        <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required>
            @error('email') <div>{{ $message }}</div> @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
            @error('password') <div>{{ $message }}</div> @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required>
        </div>

        <button type="submit">Register</button>
    </form>
</div>
