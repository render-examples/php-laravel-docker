# Laravel 5.8 with a Docker PHP Image

A demo repo for deploying a Laravel PHP application on [Render](https://render.com) using Docker. You can follow the getting started tutorial [here](https://render.com/docs/deploy-php-laravel-docker).


## Deployment

1. [Create](https://dashboard.render.com/new/database) a new PostgreSQL database on Render and copy the internal DB URL to use below.

2. Fork this repo to your own GitHub account.

3. Create a new **Web Service** on Render, and give Render's GitHub app permission to access your new repo.

4. Select `Docker` for the environment, and add the following environment variable under the *Advanced* section:

   | Key             | Value           |
   | --------------- | --------------- |
   | `DATABASE_URL`  | The **internal connection string** for the database you created above. |
   | `DB_CONNECTION`  | `pgsql` |
   | `APP_KEY`  | Copy the output of `php artisan key:generate --show` |

That's it! Your Laravel 5.8 app will be live on your Render URL as soon as the build finishes. You can test it out by registering and logging in.
