# php-laravel-hotbook

**HOTBOOK** is a full-stack, dual-interface (Customer and Hotel Owner) hotel booking platform developed using **Laravel 12** and the **Google Places API**.

This project showcases a **hybrid architecture** that combines a "Partner Hotel" model (local MySQL database) with a "Global Search" model (live API). The platform also features full localization support for **English**, **Turkish**, and **Spanish**.

![HOTBOOK Homepage Screenshot](https.../screenshot1.jpg) ---

##  Key Features

### Customer Interface (Frontend)
* **Hybrid Search:** Users can search for hotels worldwide (via the live **Google Places API**) based on their search query (e.g., "hotels in Tokyo") or browse "Partner Hotels" (from the local **MySQL** database) if no search is performed.
* **Smart Sorting:** Search results can be sorted by Rating or Popularity (Total Review Count).
* **Google Autocomplete:** Search bars provide hotel and location suggestions as the user types.
* **Dynamic Detail Page:** When a user clicks a hotel, the system checks its `place_id` against the local database:
    * **Partner Hotel:** Displays the partner's price, custom description, a 10-photo gallery, Google reviews, and a **"Book Now" form**.
    * **Non-Partner Hotel:** Displays only Google API data (photos, reviews) and a **"This hotel is not listed with us"** notice.
* **Booking System:** Customers can create booking requests for Partner Hotels, which are saved with a `status='pending'`.
* **Customer Dashboard:** Customers (`/my-bookings`) can track their booking status (Pending, Approved, Rejected) in real-time.

### Hotel Owner Interface (Admin Panel)
* **Role-Based Access Control (RBAC):** The `/admin` routes are protected by **Middleware**, accessible only to users with the `role='hotel_owner'`.
* **Smart Hotel Onboarding:** Hotel owners use **Google Places Autocomplete** on the "Add New Hotel" page to find their property.
* **Auto-Fill Form:** Upon selection, the form is auto-populated with rich data from the Google API (`name`, `address`, 10 photos, 5 reviews, `phone`, `website`, etc.).
* **Full CRUD Functionality:** Owners add their own `description` and `price_per_night` to the API data and can update/delete their listings.
* **Booking Management:** Owners view incoming bookings (`/admin/bookings`) for *their hotels only* and can **Approve** or **Reject** them (providing a reason for rejection).
* **Dynamic Statistics:** The admin dashboard displays real-time stats for Total Hotels, Pending Reservations, and Total Earnings (from approved bookings).

###  Localization
* The site fully supports **English**, **Turkish**, and **Spanish**.
* Language selection is managed by a Session-based **Middleware**.
* All text (in `.blade.php` files and Controllers) is managed via Laravel's JSON (`__('...')`) translation system.

###  API Security
* **Proxy Route:** All hotel photos (`<img>` tags) are served through a PHP "proxy" route (`HotelImageController`) to hide the API key. The key is never exposed to the client-side.
* **JS Key Restriction:** The API key required for JavaScript (Autocomplete) is secured via **"HTTP Referrer"** restrictions in the Google Cloud Console.

---

##  Tech Stack

* **Backend:** PHP 8.4, Laravel 12
* **Frontend:** Blade Templates, Bootstrap 5, JavaScript (ES6+), jQuery, Owl Carousel
* **Database:** MySQL
* **APIs:** Google Places API (Text Search, Place Details, Autocomplete)
* **Auth:** Laravel Breeze (Customized with Roles and Phone Number)

---

##  Installation

1.  Clone the repository:
    ```bash
    git clone [https://github.com/YOUR-USERNAME/php-laravel-hotbook.git](https://github.com/YOUR-USERNAME/php-laravel-hotbook.git)
    ```
2.  Navigate into the project directory:
    ```bash
    cd php-laravel-hotbook
    ```
3.  Install dependencies:
    ```bash
    composer install
    npm install && npm run build
    ```
4.  Copy the environment file:
    ```bash
    cp .env.example .env
    ```
5.  Generate the application key:
    ```bash
    php artisan key:generate
    ```
6.  Open the `.env` file and configure your database credentials (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
7.  Add your Google API Key to the `.env` file:
    ```env
    GOOGLE_PLACES_API_KEY=YOUR_GOOGLE_API_KEY_HERE
    ```
8.  Run the database migrations:
    ```bash
    php artisan migrate
    ```
9.  Start the server:
    ```bash
    php artisan serve
    ```
