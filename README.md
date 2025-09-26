# Project Management System (PMS) - Laravel API

## Setup

1. **Clone & Install**

```bash
git clone <repository_url>
cd pm-system
composer install
npm install
npm run build
cp .env.example .env
php artisan key:generate
```

2. **Configure Database**

* Edit `.env` file and set your database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

3. **Run Migrations & Seed Data**

```bash
php artisan migrate --seed
```

4. **Serve the Application**

```bash
php artisan serve
```

---

## Seeded Data

* **Users:** 3 Admins, 3 Managers, 5 Users
* **Projects:** 5
* **Tasks:** 10
* **Comments:** 10

---

## API

Use the Postman collection `PMSystem.postman_collection.json`.

### Authentication

* **Login:** `POST /api/login`
* **Register:** `POST /api/register`
* **Logout:** `POST /api/logout`
* **Current User:** `GET /api/me`

> **Headers for authenticated requests:**
> `Authorization: Bearer <token>`
> `Content-Type: application/json`

### Endpoints

* **Projects**

  * `GET /api/projects`
  * `GET /api/projects/{id}`
  * `POST /api/projects` (Admin only)
  * `PUT /api/projects/{id}` (Admin only)
  * `DELETE /api/projects/{id}` (Admin only)

* **Tasks**

  * `GET /api/projects/{id}/tasks`
  * `POST /api/projects/{id}/tasks` (Manager only)
  * `PUT /api/tasks/{id}` (Manager / Assignee)
  * `DELETE /api/tasks/{id}` (Manager only)

* **Comments**

  * `GET /api/tasks/{id}/comments`
  * `POST /api/tasks/{id}/comments`

---

## Running Tests

```bash
php artisan test
```

---

## Notes

* **Queues:** Set `QUEUE_CONNECTION=database` in `.env` and run:

```bash
php artisan queue:work
```

to process email jobs.

* **Caching:** Projects list cached for 60s per filter page.

* **Middleware:** Ensure `app/Http/Kernel.php` contains `role` & `log.request` in `$routeMiddleware`.

* **User Model:** Ensure `HasApiTokens` trait is used.

* **Clear & Optimize Cache**

```bash
composer dump-autoload
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan optimize:clear
```

* **Migrate & Seed**

```bash
php artisan migrate --seed
```

---

## Submission Checklist

* Ensure `app/Providers/RouteServiceProvider.php` exists and routes are loaded.
* Include `PMSystem.postman_collection.json` and this `README.md` in your submission zip.
