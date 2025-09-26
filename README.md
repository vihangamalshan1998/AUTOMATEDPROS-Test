# Project Management System (PMS) - Laravel API

## Setup
1. Clone & install:
git clone <repo>
cd pm-system
composer install
npm install
npm run build
cp .env.example .env
php artisan key:generate

markdown
Copy code
2. Configure DB in `.env`.
3. Run migrations & seed:
php artisan migrate --seed

markdown
Copy code
4. Serve:
php artisan serve

markdown
Copy code

## Seeded data
- Users: 3 admins, 3 managers, 5 users
- Projects: 5
- Tasks: 10
- Comments: 10

## API
Use Postman collection `PMSystem.postman_collection.json`. Authenticate with `/api/login`, set header:
Authorization: Bearer <token>
Content-Type: application/json

makefile
Copy code

Endpoints: (see collection)
POST /api/register, POST /api/login, POST /api/logout, GET /api/me
GET /api/projects, GET /api/projects/{id}
POST /api/projects (admin), PUT/DELETE /api/projects/{id} (admin)
GET /api/projects/{id}/tasks, POST /api/projects/{id}/tasks (manager)
PUT /api/tasks/{id} (manager/assignee), DELETE /api/tasks/{id} (manager)
POST /api/tasks/{id}/comments, GET /api/tasks/{id}/comments

makefile
Copy code

## Tests
Run:
php artisan test

markdown
Copy code

## Notes
- Queues: set `QUEUE_CONNECTION=database` and run `php artisan queue:work` to process email jobs.
- Caching: projects list cached for 60s per filter page.
10. Final checklist before submission
Ensure app/Providers/RouteServiceProvider.php exists (default) and routes loaded.

Ensure app/Http/Kernel.php contains role & log.request in $routeMiddleware.

Ensure User has HasApiTokens.

composer dump-autoload and clear caches:

bash
Copy code
composer dump-autoload
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan optimize:clear
Run migrations and seed: php artisan migrate --seed

Run tests: php artisan test

Export Postman collection file and include README.md in your submission zip.
