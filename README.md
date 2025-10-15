# Contact Grove — README

A tiny Laravel app with a Livewire contact form, file upload, spam guards, queued email, and an admin table to browse submissions.

Demo: http://66.29.134.61/

---

## Prerequisites

Pick **one** setup:

**A) With Sail (recommended for dev)**

* Docker Desktop

**B) Local stack**

* PHP ≥ 8.2, Composer
* Node ≥ 18 and npm
* SQLite (or MySQL/Postgres)
* A **working SMTP** (or local Mailpit)

---

## 1) Install & configure
https://github.com/discodancerd/contact-grove-test

```bash
# clone
git clone https://github.com/discodancerd/contact-grove-test.git contact-grove-test
cd contact-grove-test

# env
cp .env.testing .env
```

### The app is database-agnostic (use SQLite for quick start)

```bash
touch database/database.sqlite
```

Edit **.env**:

```
APP_ENV=local
```


---

## 2) Dependencies & build

**Local (no Sail):**

```bash
composer install
php artisan key:generate
npm install
npm run build
```


---

## 3) Migrate & seed

```bash
php artisan migrate
php artisan db:seed
php artisan db:seed --class=ContactSubmissionSeeder
```

---

## 4) Run the app

**Local PHP server:**

```bash
php artisan serve
# http://127.0.0.1:8000
```

**Sail:**

```bash
./vendor/bin/sail up -d
# http://localhost
```

---

## 5) Queue worker (for queued mail)

Enable mail queuing in **.env** if needed:

```
QUEUE_MAIL=true
```

### Mail SMTP

Use **working SMTP** creds (can provide securely those used at http://66.29.134.61/ upon request). In **.env** set:

```
MAIL_MAILER=smtp
MAIL_HOST=your.smtp.host
MAIL_PORT=587
MAIL_USERNAME=your_user
MAIL_PASSWORD=your_pass
MAIL_FROM_ADDRESS=no-reply@example.test
MAIL_FROM_NAME="Contact"

# address that receives notifications
NOTIFY_ADDRESS=you@yourdomain.com
```

Then run a worker:

**Local:**

```bash
php artisan queue:work
```

**Sail:**

```bash
./vendor/bin/sail artisan queue:work
```

> If you change `.env`, restart the worker.

---

## 6) Where to find things

Through navigation menu or:

* **Contact form:** `GET /`
* **Submissions list (admin):** `GET /admin/messages`
  Visit: `http://localhost/admin/messages`

Attachments are stored under `storage/app/private/contact-attachments`.

---

## 7) Running tests

### One-time test DB setup (SQLite)

Create/migrate a test DB (name 'testing' when prompted):

```bash
php artisan migrate --env=testing
```


### Run tests

```bash
php artisan test
# or inside Sail:
# ./vendor/bin/sail artisan test
```

---

## 8) Decisions (why these tools)

* **Livewire** – Server-driven interactivity for the form & admin table without a SPA build. Simple, fast to iterate.
* **Alpine.js** – Tiny sprinkles of JS where needed; pairs well with Livewire.
* **daisyUI** – Tailwind component lib for quick styling without hand-rolling UI.
* **Sail** – One-command Docker dev environment; keeps local setup consistent.
* **SMTP** – Abstracted via Laravel mailer; supports local dev and real SMTP easily.
* **Queue for mail** – Keeps the request snappy and makes retries/backoff easy in production.


---

### That’s it

Clone → configure `.env` → install deps → build → migrate/seed → run → (optional) start queue worker → open the routes above.

Further considerations: As next steps, set up a lightweight CI/CD pipeline (e.g., GitHub Actions) that runs Pint for style checks, PHPStan with Larastan for static analysis (start with a baseline, then ratchet to level: max), and the test suite against a dedicated testing database; adopt stricter typing across the codebase (declare(strict_types=1);, explicit parameter and return types, DTOs where helpful) and annotate collections so analysis stays precise; add convenient Composer scripts (lint, lint:fix, analyze, test) and optional pre-commit hooks to keep feedback fast locally; finally, make PRs block on green style, analysis, and tests to maintain quality as the project grows.
