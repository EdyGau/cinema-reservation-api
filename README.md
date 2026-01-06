# 🎬 Cinema Reservation API

Professional REST API for cinema seat reservations built with **Symfony 6.4** and **API Platform 3**.

---

## ✨ Features

- **JWT Authentication** – Secure access control using `LexikJWTAuthenticationBundle`
- **Automated Documentation** – Interactive Swagger UI with JWT support
- **Business Logic Layer** – Dedicated services for seat availability and hall geometry validation
- **Data Integrity** – Transactional reservation process with database-level unique constraints
- **Testing** – Comprehensive unit and integration test suites

---

## 🛠 Requirements

- **PHP 8.3**
- **Composer**
- **SQLite** (default database)

---

## 🚀 Quick Start (Makefile)

If you have `make` installed, you can set up the entire project with a single command:

    make setup

This command installs dependencies, generates JWT keys, and prepares both dev and test databases with fixtures.

---

## ⚙ Manual Installation

1. Install dependencies:

   composer install

2. Generate JWT keys:

   php bin/console lexik:jwt:generate-keypair

3. Setup database:

   php bin/console doctrine:database:create
   php bin/console doctrine:schema:update --force
   php bin/console doctrine:fixtures:load --no-interaction

4. Prepare test environment:

   php bin/console doctrine:schema:update --env=test --force

---

## 🧪 Testing

Run the automated test suite:

    make test

or

    php bin/phpunit

---

## 🔑 Authentication & Usage

### Obtain JWT Token

Endpoint: POST /api/v1/login_check

Payload:

    {
      "email": "pracownik@kino.pl",
      "password": "admin123"
    }

---

### Authorize in Swagger UI

1. Open /api/v1 in your browser
2. Click Authorize
3. Enter:

   Bearer <your_token>

---