# Auth Feature Changes

## Files Updated
- app/Http/Controllers/AuthController.php
  - Added register, login, and logout actions.
  - Login supports username or email.
  - Session regeneration on login and session invalidation on logout.

- app/Models/User.php
  - Added username to mass-assignable attributes.

- routes/web.php
  - Added routes for register, login, and logout.

- resources/views/auth/register.blade.php
  - Added simple register form with name, username, email, password, and confirm password.

- resources/views/auth/login.blade.php
  - Added simple login form with username/email and password.
