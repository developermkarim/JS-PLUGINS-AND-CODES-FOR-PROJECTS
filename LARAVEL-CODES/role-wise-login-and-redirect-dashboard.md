## Role Management
---
Certainly! To create a role-wise login system in Laravel with distinct dashboards for each role, you can follow these steps:

### Step 1: Set Up Database Tables

Create a migration to add a 'role' column to the `users` table. Also, create tables for distinct dashboards if needed.

```bash
php artisan make:migration add_role_to_users_table --table=users
```

Modify the migration file:

```php
// database/migrations/YYYY_MM_DD_add_role_to_users_table.php

public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('role')->default('user'); // Default role is 'user'
    });
}
```

Run the migration:

```bash
php artisan migrate
```

### Step 2: Create Middleware

Create a middleware to check user roles.

```bash
php artisan make:middleware CheckRole
```

Modify the middleware file:

```php
// app/Http/Middleware/CheckRole.php

public function handle($request, Closure $next, ...$roles)
{
    if (!in_array(auth()->user()->role, $roles)) {
        return redirect('/home')->with('error', 'You do not have access and authorization here.');
    }

    return $next($request);
}
```

### Step 3: Register Middleware

Register the middleware in `app/Http/Kernel.php`:

```php
// app/Http/Kernel.php

protected $routeMiddleware = [
    // ...
    'role' => \App\Http\Middleware\CheckRole::class,
];
```

### Step 4: Create Controllers

Create controllers for different roles and their dashboards:

```bash
php artisan make:controller AdminController
php artisan make:controller AgentController
php artisan make:controller ProducerController
php artisan make:controller UserController
```

### Step 5: Define Routes

Define routes in `routes/web.php`:

```php
// routes/web.php

Route::middleware(['auth', 'role:admin,agent,producer'])->group(function () {
    Route::get('/admin/dashboard', 'AdminController@dashboard');
    Route::get('/agent/dashboard', 'AgentController@dashboard');
    Route::get('/producer/dashboard', 'ProducerController@dashboard');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', 'UserController@dashboard');
});
```

### Step 6: Create Controllers Logic

Implement logic in each controller's dashboard method:

```php
// app/Http/Controllers/AdminController.php

public function dashboard()
{
    return view('admin.dashboard');
}
```

Repeat this for `AgentController`, `ProducerController`, and `UserController`.

### Step 7: Update LoginController

Modify the `LoginController` to redirect users based on their roles after successful login:

```php
// app/Http/Controllers/Auth/LoginController.php

protected $redirectTo = '/home'; // Change this to the default dashboard

protected function authenticated(Request $request, $user)
{
    if ($user->role == 'admin') {
        return redirect('/admin/dashboard');
    } elseif ($user->role == 'agent') {
        return redirect('/agent/dashboard');
    } elseif ($user->role == 'producer') {
        return redirect('/producer/dashboard');
    } elseif ($user->role == 'user') {
        return redirect('/user/dashboard');
    }
}
```

### Step 8: Create Views

Create views for each dashboard in the respective `resources/views` folder.

### Step 9: Test

Test the role-wise login system by registering users with different roles and logging in with their credentials.

This setup ensures that users are redirected to their respective dashboards based on their roles and denies access if they try to access other dashboards.

Feel free to customize the views, routes, and controllers according to your specific needs.

## **My Custom Role Management With Breeze Package**
Certainly! You can achieve a role-wise login and dashboard system in Laravel using Laravel Breeze. Here's a step-by-step guide:

### Step 1: Install Laravel Breeze

If you haven't already, install Laravel Breeze:

```bash
composer require laravel/breeze --dev
```

Then, scaffold the authentication views and controllers:

```bash
php artisan breeze:install
```

### Step 2: Database Setup

Make sure your database is configured in the `.env` file, and run the migrations:

```bash
php artisan migrate
```

### Step 3: User Model

Modify the `User` model (`app/Models/User.php`) to include a `role` attribute:

```php
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
```

### Step 4: Middleware

Create a middleware for role-based redirection. Run the following command:

```bash
php artisan make:middleware RedirectIfNotRole
```

In the generated `RedirectIfNotRole.php` file, modify the `handle` method:

```php
public function handle($request, Closure $next, ...$roles)
{
    if (!in_array(auth()->user()->role, $roles)) {
        return redirect('/home')->with('error', 'You do not have access to this page.');
    }

    return $next($request);
}
```
OR

```PHP
    public function handle(Request $request, Closure $next, $role): Response
    {
        if ($request->user()->role !== $role) {
            return redirect('user/dashboard')->with('error', 'You do not have access and authorization here.');;
        }
        return $next($request);
    }
```

### Step 5: Route Middleware

In `app/Http/Kernel.php`, add the middleware to the `$routeMiddleware` array:

```php
protected $routeMiddleware = [
    // ...
    'role' => \App\Http\Middleware\RedirectIfNotRole::class,
];
```

### Step 6: Define Routes

Define your routes in `web.php`:

```php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

Route::middleware(['auth', 'role:admin|agent|producer'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Add other admin, agent, and producer routes here
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    // Add other user routes here
});
```

### Step 7: Controllers

Create controllers for each role (`AdminController` and `UserController`). In the controllers, define methods for the respective dashboards.

### Step 8: Redirect After Login

Modify `LoginController.php` to redirect users based on their roles:

```php
protected function redirectTo()
{
    if (auth()->user()->role === 'admin') {
        return route('admin.dashboard');
    } elseif (auth()->user()->role === 'user') {
        return route('user.dashboard');
    }

OR
    switch (auth()->user()->role) {
        case 'admin':
            return route('admin.dashboard');
        case 'agent':
            return route('agent.dashboard');
        case 'producer':
            return route('producer.dashboard');
        case 'user':
            return route('user.dashboard');
        default:
            return '/';
    }

    // Add similar conditions for other roles
}

// This modification checks the user's role and redirects them to the corresponding dashboard route.
```

Modify `AuthenticatedSessionController.php` to redirect users based on their roles:

```php
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

    /* This is for Just showing the Login Username  */
        $id = Auth::user()->id;
        $adminData = User::find($id);
        $username = $adminData->name;

        $request->session()->regenerate();

        $notification = [
            'message' => "User $username Login Successfully",
            'alert-type' => 'info',
        ];
/*         return redirect()->intended(RouteServiceProvider::HOME); */
        $url = '';
        if ($request->user()->role === 'admin') {
            $url = 'admin/dashboard';
        }elseif ($request->user()->role === 'agent') {
            $url = 'agent/dashboard';
        }elseif ($request->user()->role  === 'user') {
            $url = 'user/dashboard';
        }
        return redirect()->intended($url)->with($notification);
    }
```

### Step 9: Modify `RedirectIfAuthenticated` Middleware

Open the `RedirectIfAuthenticated.php` middleware file located in the `app/Http/Middleware` directory. In the `handle` method, modify the redirection logic:

```php
public function handle($request, Closure $next, $guard = null)
{
    if (Auth::guard($guard)->check()) {
        switch (auth()->user()->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'agent':
                return redirect()->route('agent.dashboard'); // Add similar conditions for other roles
            case 'producer':
                return redirect()->route('producer.dashboard');
            case 'user':
                return redirect()->route('user.dashboard');
            default:
                return redirect('/home'); // Add a default fallback route if needed
        }
    }

    return $next($request);
}

/* Or The Codes below */

public function handle(Request $request, Closure $next, string ...$guards): Response
{
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {

            if(Auth::guard($guard)){

             if(Auth::check() && Auth::user()->role == 'user'){
                return redirect('dashboard');
                }
                if(Auth::check() && Auth::user()->role == 'agent'){
                    return redirect('agent/dashboard');
                }
                if (Auth::check() && Auth::user()->role == 'admin') {
                    return redirect('admin/dashboard');
                }
            }

     //  return redirect(RouteServiceProvider::HOME);

        }

        return $next($request);
}

```

### Step 10: Usage

Now, users will be redirected to their respective dashboards upon login. Unauthorized access attempts will be blocked, and users will see the error message.

### Best Practices:

- Use Laravel's built-in features whenever possible.
- Keep your routes and controllers organized.
- Validate and sanitize user inputs.
- Consider using a package like Spatie Laravel Permission if your requirements become more complex.

This guide should help you create a professional role-wise login and dashboard system in Laravel using Laravel Breeze. Customize it based on your specific needs.

## Separate Login Page For Different Role
---
Certainly! To have separate login pages for users and admins and to handle login attempts appropriately, you can customize the login process in Laravel. Here's how you can achieve this:

### Step 1: Create Separate Login Controllers

Create separate controllers for user and admin logins:

```bash
php artisan make:controller UserLoginController
php artisan make:controller AdminLoginController
```

### Step 2: Update Routes

In your `web.php` file, update the routes to use the appropriate controllers for user and admin logins:

```php
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\AdminLoginController;

Route::middleware('guest')->group(function () {
    Route::view('/user/login', 'auth.login', ['url' => 'user'])->name('user.login');
    Route::post('/user/login', [UserLoginController::class, 'login']);

    Route::view('/admin/login', 'auth.login', ['url' => 'admin'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'login']);
});
```

### Step 3: Customize Login Views

Update your login views (located in `resources/views/auth/login.blade.php`) to include a hidden field indicating whether it's a user or admin login:

```html
<form method="POST" action="{{ url("$url/login") }}">
    @csrf

    <input type="hidden" name="user_type" value="{{ $url }}">

    <!-- Your other form fields -->

    <button type="submit">
        {{ __('Login') }}
    </button>
</form>
```

### Step 4: Update Login Controllers

In your `UserLoginController.php` and `AdminLoginController.php`, customize the login logic:

```php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
    // Your existing code

    public function login(Request $request)
    {
        $this->validate($request, [
            // Your validation rules
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if ($request->input('user_type') === 'user') {
                return redirect()->route('user.dashboard');
            } else {
                Auth::logout();
                return redirect()->route('user.login')->with('error', 'Invalid login credentials for admin.');
            }
        }

        return redirect()->route('user.login')->with('error', 'Invalid login credentials.');
    }
}
```

Repeat a similar process for the `AdminLoginController.php`.

### Step 5: Additional Configuration

Make sure your `UserLoginController` and `AdminLoginController` extend `AuthController` or implement necessary login traits based on your Laravel version.

### Best Practices:

- Always validate and sanitize user inputs.
- Use Laravel's built-in features for authentication.
- Keep your code organized and follow Laravel conventions.

This setup ensures that admins attempting to log in through the user login page receive an appropriate error message, and users are redirected to their dashboard after a successful login. Customize the logic as needed for your application.