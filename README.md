# Lumiere Beauty Clinic — Web Application

An academic group project to develop a web-based management application for a beauty clinic. The application brings together treatment information, customer bookings, payment confirmation, promotions, and a membership points system.

> **Project context:** This is a group project. The repository contains the application source code for project context; the **My Individual Contribution** section below identifies the parts personally developed by Angellica Ivana.

## Project Overview

Lumiere Beauty Clinic is a Laravel-based web application designed to support customer interactions and clinic operations. Customers can explore treatments, register or log in, submit bookings, review payment instructions, and view their membership points. Administrative users can manage selected clinic operations through an admin area.

## Key Features

- Customer registration, login, and account access.
- Treatment catalogue and treatment booking flow.
- Payment instruction and payment confirmation workflow.
- Admin-side booking status management.
- Promotion listing and management.
- Homepage membership tier information.
- Customer **My Points** page with current membership level and point transaction history.
- Membership point calculation and membership-level synchronization.

## My Individual Contribution — Membership Module

I was responsible for developing the membership-related parts of the group application:

1. **Homepage Membership Section**
   - Developed the membership section on the homepage.
   - Presented the four membership tiers: Bronze, Silver, Gold, and Platinum, with their point thresholds and benefit descriptions.

2. **My Points Page**
   - Developed the customer-facing My Points page.
   - Displayed the current membership level, accumulated points, and paginated point transaction history.

3. **Backend Membership Functionality**
   - Implemented membership point calculation and point transaction recording.
   - Connected point awarding to the booking payment status flow.
   - Added a duplicate-award check so the same booking does not generate an additional earning transaction.
   - Implemented point expiry handling and membership-level synchronization based on active points.

### Membership Rules Reflected in the Source Code

| Membership level | Minimum points |
|---|---:|
| Bronze | 0 |
| Silver | 500 |
| Gold | 1,500 |
| Platinum | 3,000 |

- Points are awarded when a booking's payment status is updated to `paid`.
- The point calculation in `MembershipService` is based on `floor(total_price / 10,000)`, with a minimum of 1 point.
- Earned points are assigned an expiry date one year after the earning date.
- The membership level is synchronized using the customer's active point balance.

## Technology Stack

- **Backend:** PHP 8.1+, Laravel 10
- **Database:** MySQL
- **Frontend:** Laravel Blade, HTML, CSS, JavaScript
- **Build tools:** Composer, npm, Vite

## Relevant Source Files

| Area | Relevant files |
|---|---|
| Homepage membership section | `resources/views/home.blade.php` |
| My Points page | `resources/views/points/index.blade.php` |
| My Points controller | `app/Http/Controllers/PointController.php` |
| Membership business logic | `app/Services/MembershipService.php` |
| Membership model | `app/Models/MembershipLevel.php` |
| Point transaction model | `app/Models/PointTransaction.php` |
| User membership relationship | `app/Models/User.php` |
| Membership database structure | `database/migrations/` |
| Membership tier seed data | `database/seeders/MembershipLevelSeeder.php` |
| Booking-to-points integration | `app/Http/Controllers/Admin/BookingController.php` |

## Project Structure

```text
app/
  Http/Controllers/
  Models/
  Services/
bootstrap/
config/
database/
  migrations/
  seeders/
public/
  assets/
resources/
  views/
routes/
tests/
```

## Run Locally

### Requirements

- PHP 8.1 or later
- Composer
- MySQL
- Node.js and npm

### Installation

1. Clone the repository and open the project directory.

   ```bash
   git clone <repository-url>
   cd <project-directory>
   ```

2. Install PHP dependencies.

   ```bash
   composer install
   ```

3. Create the local environment file.

   **macOS / Linux**
   ```bash
   cp .env.example .env
   ```

   **Windows PowerShell**
   ```powershell
   Copy-Item .env.example .env
   ```

4. Create a MySQL database, for example `lumiere_beauty`, then update the database settings in `.env`.

5. Generate the Laravel application key.

   ```bash
   php artisan key:generate
   ```

6. (Optional) Configure a local admin account in `.env` before running the seeders:

   ```dotenv
   LUMIERE_ADMIN_NAME="Lumiere Admin"
   LUMIERE_ADMIN_EMAIL=your-admin-email@example.com
   LUMIERE_ADMIN_PHONE=
   LUMIERE_ADMIN_PASSWORD=use-a-strong-local-password
   ```

   The admin seeder is skipped if the email or password is not configured. Do not commit your actual `.env` file or share real credentials.

7. Run database migrations and seeders.

   ```bash
   php artisan migrate --seed
   ```

8. Install frontend dependencies and build assets.

   ```bash
   npm install
   npm run build
   ```

9. Start the local development server.

   ```bash
   php artisan serve
   ```

   Open the local URL shown by Artisan, usually `http://127.0.0.1:8000`.

## Demo and Security Notes

- This repository is prepared for **academic demonstration and portfolio review**, not production deployment.
- The QRIS image and bank/e-wallet details included in the application are **demo placeholders for payment-flow simulation only**. They are not real payment instructions.
- No `.env` file, application key, runtime log, session data, compiled cache, or old SQL dump is included in this repository package.
- Configure local credentials in your own `.env` file. Never commit passwords, API keys, database credentials, customer data, or payment credentials.
- The application was developed as a group project. Please obtain agreement from the project team before publishing the full source code publicly.

## Project Status

Academic project. The source code is provided for demonstration of the application structure and the membership module contribution.
