# Laravel 11 with a Docker PHP Image

A demo repo for deploying a Laravel PHP application on [Render](https://render.com) using Docker. You can follow the getting started tutorial [here](https://render.com/docs/deploy-php-laravel-docker).

## Deployment

1. [Create](https://dashboard.render.com/new/database) a new PostgreSQL database on Render and copy the internal DB URL to use below.

2. Fork this repo to your own GitHub account.

3. Create a new **Web Service** on Render, and give Render's GitHub app permission to access your new repo.

4. Select `Docker` for the environment, and add the following environment variable under the _Advanced_ section:

    | Key             | Value                                                             |
    | --------------- | ----------------------------------------------------------------- |
    | `APP_KEY`       | Copy the output of `php artisan key:generate --show`              |
    | `DATABASE_URL`  | The **internal database url** for the database you created above. |
    | `DB_CONNECTION` | `pgsql`                                                           |

Certainly! Here's a comprehensive README tailored for your Laravel-based API project hosted on Render:

---

# 🐾 HNG i13 Stage 0 – Dynamic Profile API

Welcome to my submission for HNG i13 Stage 0! This project showcases a simple Laravel-based API endpoint that returns my profile information along with a dynamic cat fact fetched from an external API.

## 📍 Live Endpoint

You can access the live API endpoint here:

👉 [https://hng-13-stage0.onrender.com/api/me](https://hng-13-stage0.onrender.com/api/me)

## 🛠️ Technologies Used

-   **Backend Framework**: Laravel 11
-   **Containerization**: Docker
-   **Hosting Platform**: Render
-   **External API**: Cat Facts API ([https://catfact.ninja/fact](https://catfact.ninja/fact))
-   **Programming Language**: PHP

## 🧩 API Endpoint

### `GET /api/me`

#### Response

```json
{
    "status": "success",
    "user": {
        "email": "youremail@example.com",
        "name": "Your Full Name",
        "stack": "Laravel/PHP"
    },
    "timestamp": "2025-10-18T12:45:32.567Z",
    "fact": "Cats sleep for 70% of their lives."
}
```

#### Fields

-   **status**: Always `"success"`.
-   **user**: Object containing:

    -   **email**: Your personal email address.
    -   **name**: Your full name.
    -   **stack**: Your backend technology stack (e.g., "Laravel/PHP").

-   **timestamp**: Current UTC time in ISO 8601 format.
-   **fact**: A random cat fact fetched from the Cat Facts API.

## 🚀 Deployment Guide

### 1. Fork the Example Repository

Start by forking the official Render example repository:

👉 [https://github.com/render-examples/php-laravel-docker](https://github.com/render-examples/php-laravel-docker)

### 2. Clone Your Fork Locally

Clone your forked repository to your local machine:

```bash
git clone https://github.com/yourusername/php-laravel-docker.git
cd php-laravel-docker
```

### 3. Implement the `/api/me` Endpoint

Edit the `routes/api.php` file to include the following route:

```php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

Route::get('/me', function () {
    try {
        $response = Http::timeout(5)->get('https://catfact.ninja/fact');
        $catFact = $response->successful()
            ? $response->json('fact')
            : 'Could not fetch cat fact at the moment.';
    } catch (\Exception $e) {
        $catFact = 'Error fetching cat fact: ' . $e->getMessage();
    }

    return response()->json([
        'status' => 'success',
        'user' => [
            'email' => 'youremail@example.com',
            'name' => 'Your Full Name',
            'stack' => 'Laravel/PHP',
        ],
        'timestamp' => Carbon::now('UTC')->toISOString(),
        'fact' => $catFact,
    ]);
});
```

### 4. Force HTTPS in Production

To ensure all URLs use HTTPS in the production environment, update the `AppServiceProvider`:

```php
namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(UrlGenerator $url)
    {
        if (env('APP_ENV') === 'production') {
            $url->forceScheme('https');
        }
    }
}
```

### 5. Generate the Application Key

Run the following command to generate the application key:

```bash
php artisan key:generate --show
```

Copy the generated key for use in the next step.

### 6. Deploy to Render

1. Go to [Render](https://render.com) and create a new Web Service.

2. Connect your GitHub account and select the forked repository.

3. Choose Docker as the runtime.

4. Under "Environment Variables", add the following:

    - `APP_KEY`: The key generated in the previous step.
    - `APP_ENV`: `production`
    - `APP_DEBUG`: `false`

5. Click "Create Web Service" to deploy your application.

Render will automatically build and deploy your Laravel application.

## 📝 Submission Details

-   **Live Endpoint**: [https://hng-13-stage0.onrender.com/api/me](https://hng-13-stage0.onrender.com/api/me)
-   **GitHub Repository**: [https://github.com/samthatcode/php-laravel-docker](https://github.com/samthatcode/php-laravel-docker)
-   **Full Name**: Your Full Name
-   **Email**: [youremail@example.com](mailto:version.control.dev@gmail.com)
-   **Stack**: Laravel/PHP

## 📸 Screenshots

![API Response Screenshot](./screenshots/api_response.png)

## 📚 Learnings

This project enhanced my understanding of:

-   Building RESTful APIs with Laravel.
-   Integrating external APIs to fetch dynamic data.
-   Deploying PHP applications using Docker.
-   Hosting applications on Render.

## 📢 Social Media Post

Check out my detailed post on this project:

👉 [DevTo](https://dev.to/version_control_dev/dynamic-profile-api-1b6n)
👉 [Twitter](https://twitter.com/samthatcode)

Feel free to reach out for collaborations or discussions!

---

Let me know if you need further assistance or modifications to this README!

That's it! Your Laravel 11 app will be live on your Render URL as soon as the build finishes. You can test it out by registering and logging in.
