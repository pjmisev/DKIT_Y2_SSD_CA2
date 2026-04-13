# Hoops Club — Basketball Manager

A web-based basketball club management system built with Laravel 12. It allows club administrators to manage players, coaches, management staff, and events, while giving regular members a read-only view of club information.

---

## Project Overview

Hoops Club is a full-stack CRUD application designed for a basketball club. An admin user controls all data entry, while authenticated non-admin users can browse the roster and schedule.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 12 |
| Auth scaffolding | Laravel Breeze |
| Frontend | Blade + Tailwind CSS (via Vite) |
| Database | MySQL |
| Dev environment | Laravel Sail (Docker) |

---

## Setup and Installation

### Prerequisites

- PHP 8.2+
- Composer
- Node.js 18+ and npm
- MySQL (or use SQLite for quick local setup)

### Standard local setup

```bash
# 1. Clone the repository
git clone <repo-url>
cd basketball-manager

# 2. Install PHP dependencies
composer install

# 3. Copy and configure the environment file
cp .env.example .env
php artisan key:generate

# 4. Configure your database in .env
#    For SQLite (easiest for local dev):
#      DB_CONNECTION=sqlite
#      # Leave DB_DATABASE blank or point it to database/database.sqlite
#    For MySQL:
#      DB_CONNECTION=mysql
#      DB_DATABASE=basketball_manager
#      DB_USERNAME=root
#      DB_PASSWORD=

# 5. Run migrations
php artisan migrate

# 6. Install frontend dependencies and build assets
npm install
npm run build
```

Alternatively, run the all-in-one setup script defined in `composer.json`:

```bash
composer run setup
```

### Running the development server

```bash
composer run dev
```

This starts the Laravel dev server, Vite HMR, queue worker, and log watcher concurrently.

### Docker / Laravel Sail

```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
```

### Running tests

```bash
composer run test
# or
php artisan test
```

---

## Creating an Admin User

There is no seeder for admin users. After running migrations, register a new account through `/register`, then update the user's role directly:

```bash
php artisan tinker
>>> \App\Models\User::where('email', 'your@email.com')->update(['role' => 'admin']);
```

---

## Implemented Features

### Authentication
- Register, login, logout via Laravel Breeze
- Password reset by email
- Email verification support
- "Remember me" on login

### Role-based access control
- Two roles: `admin` and `user`
- Custom `AdminMiddleware` enforces admin-only routes
- All create / edit / delete actions restricted to admins
- Authenticated non-admin users can view all records
- Some pages (players, coaches, events index) are also accessible publicly without login

### Player management
- Full CRUD (admin only for write operations)
- Fields: name, email, jersey number, position, team, nationality, dominant hand, height, weight, health status, salary, date of birth, notes
- Profile photo upload
- Health status values: `fit`, `injured`, `recovering`, `suspended`
- Positions: Point Guard, Shooting Guard, Small Forward, Power Forward, Center
- Players can optionally be linked to a user account

### Coach management
- Full CRUD (admin only for write operations)
- Fields: name, email, role, team, nationality, date of birth, salary, notes
- Profile photo upload
- Coach roles: Head Coach, Assistant Coach, Strength & Conditioning Coach, Skills Coach, Video Analyst
- Coaches can optionally be linked to a user account

### Management staff
- Full CRUD (admin only for write operations)
- Fields: name, email, role, team, nationality, date of birth, salary, notes
- Profile photo upload
- Roles: General Manager, Team Manager, Director of Basketball Operations, President, Scout, Medical Staff, Administrative Staff
- Staff can optionally be linked to a user account

### Event / game scheduling
- Full CRUD (admin only for write operations)
- Fields: name, description, start time, end time, location
- Upcoming events shown on the public welcome page

### Admin dashboard
- Overview of all users
- Admin can create, edit, and delete user accounts
- Accessible at `/admin`

### User profile
- Authenticated users can update their name, email, and password
- Account deletion supported

### Public welcome page
- Displays live stats: player count, coach count, total events, next event date
- Lists upcoming games with location and time
- No login required

---

## Assumptions

- A single admin manages the club; there is no self-service registration flow for becoming an admin.
- Player, coach, and management images are stored as file paths in the database and served from the `public/storage` disk. Running `php artisan storage:link` is required if uploads are used.
- The application is designed for a single club, not multi-tenancy.
- Email-based password reset requires a working mail driver configured in `.env` (e.g. Mailtrap for development).

---

## Known Limitations and Issues

- **No image upload enforcement** — the image field accepts a filename string but there is no server-side file upload handling in the current controllers; images must be managed manually or the feature extended.
- **No pagination** — index pages (players, coaches, etc.) load all records at once, which may become slow for large rosters.