<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# 📰 Laravel News Aggregator

A modern Laravel-based **News Aggregation Platform** that automatically fetches, normalizes, and displays articles from multiple external sources — including **NewsAPI**, **The Guardian**, and **The New York Times (NYT)**.

## 🚀 Overview

This project demonstrates strong Laravel backend architecture — integrating external APIs, data normalization, database design, and RESTful endpoints for frontend consumption.

It includes:
<<<<<<< HEAD

-   Automated news fetching from 3 major APIs.
-   Normalized data structure with **Authors**, **Categories**, and **Sources** tables.
-   Search and filter API endpoints.
-   Minimal Blade front-end to preview recent articles.
=======
- Automated news fetching from 3 major APIs.
- Normalized data structure with **Authors**, **Categories**, and **Sources** tables.
- Search and filter API endpoints.
- Minimal Blade front-end to preview recent articles.
>>>>>>> 6e4d82ca13803003b43fa964fb2da43855eebd11

---

## 🧱 Features

✅ Fetches articles from:
<<<<<<< HEAD

-   [NewsAPI.org](https://newsapi.org)
-   [The Guardian Open Platform](https://open-platform.theguardian.com/)
-   [The New York Times API](https://developer.nytimes.com/)

✅ Normalized database:

-   `articles` table linked with `authors`, `categories`, and `sources`.

✅ API Endpoints:

-   `GET /api/v1/articles` → fetch all or search by keyword.
-   `GET /api/v1/articles/{id}` → get a single article.
-   `GET /api/v1/sources` → list all available news sources.

✅ Optional Authenticated Routes:

-   `GET /api/v1/me/preferences`
-   `POST /api/v1/me/preferences`

✅ Simple Blade UI:

-   Displays the latest fetched articles on `welcome.blade.php`.
=======
- [NewsAPI.org](https://newsapi.org)
- [The Guardian Open Platform](https://open-platform.theguardian.com/)
- [The New York Times API](https://developer.nytimes.com/)

✅ Normalized database:
- `articles` table linked with `authors`, `categories`, and `sources`.

✅ API Endpoints:
- `GET /api/v1/articles` → fetch all or search by keyword.
- `GET /api/v1/articles/{id}` → get a single article.
- `GET /api/v1/sources` → list all available news sources.

✅ Optional Authenticated Routes:
- `GET /api/v1/me/preferences`
- `POST /api/v1/me/preferences`

✅ Simple Blade UI:
- Displays the latest fetched articles on `welcome.blade.php`.
>>>>>>> 6e4d82ca13803003b43fa964fb2da43855eebd11

---

## 🧩 Tech Stack

<<<<<<< HEAD
-   **Backend:** Laravel 12.x (PHP 8.2)
-   **Database:** MySQL
-   **HTTP Client:** Laravel HTTP Facade
-   **Auth:** Laravel Sanctum
-   **Environment:** XAMPP (Localhost)
=======
- **Backend:** Laravel 12.x (PHP 8.2)
- **Database:** MySQL
- **HTTP Client:** Laravel HTTP Facade
- **Auth:** Laravel Sanctum
- **Environment:** XAMPP (Localhost)
>>>>>>> 6e4d82ca13803003b43fa964fb2da43855eebd11

---

## ⚙️ Setup Instructions

### 1️⃣ Clone the repository
<<<<<<< HEAD

````bash
=======
```bash
>>>>>>> 6e4d82ca13803003b43fa964fb2da43855eebd11
git clone https://github.com/isaacagbugolo/news-aggregator.git
cd news-aggregator

2️⃣ Install dependencies
composer install

3️⃣ Configure environment
Duplicate .env.example → .env and update:
APP_NAME="News Aggregator"
APP_URL=http://localhost/news-aggregator/public

NEWSAPI_KEY=your_newsapi_key_here
GUARDIAN_API_KEY=your_guardian_key_here
NYT_KEY=your_nyt_key_here

php artisan key:generate
php artisan migrate
php artisan news:fetch-all

6️⃣ Serve locally
php artisan serve

Then visit:
http://localhost:8000

or if you’re using XAMPP:
http://localhost/news-aggregator/public

🌐 API Examples
| Endpoint                                | Method | Description                        |
| --------------------------------------- | ------ | ---------------------------------- |
| `/api/v1/articles`                      | GET    | List all or search by `?q=keyword` |
| `/api/v1/articles/{id}`                 | GET    | Get article details                |
| `/api/v1/sources`                       | GET    | List all sources                   |
| `/api/v1/articles?category=Technology`  | GET    | Filter by category                 |
| `/api/v1/articles?sources=nyt,guardian` | GET    | Filter by source                   |

<<<<<<< HEAD
### Database Setup

This project uses Laravel migrations to create all tables automatically.

- **Option 1 (Recommended):** Import the SQL backup file located in `/database_backup/news_aggregator.sql` into your MySQL database.
- **Option 2:** Create a new database and run migrations:
  ```bash
  php artisan migrate


=======
>>>>>>> 6e4d82ca13803003b43fa964fb2da43855eebd11
👨‍💻 Author

Isaac Agbugolo
💼 Laravel Developer
🌐 LinkedIn
<<<<<<< HEAD
````
=======
>>>>>>> 6e4d82ca13803003b43fa964fb2da43855eebd11
