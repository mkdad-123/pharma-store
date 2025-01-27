
# Pharma Store – Pharmacy Management System

Pharma Store is a **multi-user pharmacy management system** designed to simplify the process of ordering medicines and managing pharmacy operations. The system supports medicine ordering, inventory management, user role management, and order tracking.

---

## Features

- **Medicine Ordering**: Easily order medicines from the pharmacy.
- **Inventory Management**: Track and manage medicine stock levels.
- **User Role Management**: Assign roles to users and control their permissions.
- **Order Tracking**: Monitor the status of orders in real-time.
- **Real-Time Notifications**: Receive instant updates using Pusher.
- **Reporting & Analytics**: Generate reports for sales, inventory, and orders.

---

## Technologies

- **Backend**: Laravel, PHP, MVC.
- **Frontend**: Blade, HTML, CSS, JavaScript.
- **Database**: MySQL.
- **APIs**: RESTful APIs for seamless integration.
- **Tools**: Git, GitHub, Postman, Pusher.
- **Techniques**: OOP, Design Patterns (Service Layer, Repository, Dependency Injection).

---

## Packages Used

This project uses the following Laravel packages:

- **barryvdh/laravel-dompdf**: For generating PDFs.
- **guzzlehttp/guzzle**: For making HTTP requests.
- **laravel/sanctum**: For API authentication.
- **laravel/scout**: For full-text search.
- **laravel/socialite**: For social media authentication.
- **pusher/pusher-php-server**: For real-time notifications.
- **spatie/laravel-query-builder**: For building complex queries.
- **stripe/stripe-php**: For payment processing.
- **tymon/jwt-auth**: For JWT authentication.

---

## How to Run the Project

### Prerequisites

Before running the project, ensure you have the following installed:
- PHP (>= 8.2)
- Composer
- MySQL
- Git
- Node.js (optional, if using frontend assets)

### Installation Steps

1. **Clone the repository**:
   ```bash
   git clone https://github.com/mkdad-123/pharma-store.git
   cd pharma-store
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Set up the `.env` file**:
    - Copy the `.env.example` file to `.env`:
      ```bash
      cp .env.example .env
      ```
    - Update the `.env` file with your database credentials:
      ```plaintext
      DB_DATABASE=your_database_name
      DB_USERNAME=your_database_user
      DB_PASSWORD=your_database_password
      ```

4. **Generate an application key**:
   ```bash
   php artisan key:generate
   ```

5. **Set up JWT Secret**:
   If you're using JWT for authentication, generate the JWT secret key:
   ```bash
   php artisan jwt:secret
   ```

6. **Set up Pusher**:
    - Obtain your Pusher credentials from the [Pusher Dashboard](https://dashboard.pusher.com/).
    - Update the `.env` file with your Pusher credentials:
      ```plaintext
      PUSHER_APP_ID=your-pusher-app-id
      PUSHER_APP_KEY=your-pusher-app-key
      PUSHER_APP_SECRET=your-pusher-app-secret
      PUSHER_APP_CLUSTER=your-pusher-app-cluster
      ```

7. **Run migrations and seed the database**:
   ```bash
   php artisan migrate --seed
   ```

8. **Start the development server**:
   ```bash
   php artisan serve
   ```

9. **Access the application**:
   Open your browser and navigate to `http://localhost:8000`.

---

## Additional Package Setup

This project uses several Laravel packages that may require additional setup. Below are the instructions for each package:

### 1. **Laravel DomPDF (barryvdh/laravel-dompdf)**
- No additional setup is required. Ensure you have the `dompdf/dompdf` dependency installed.

### 2. **Laravel Sanctum (laravel/sanctum)**
- No additional setup is required.

### 3. **Laravel Scout (laravel/scout)**
- Configure your search driver in the `.env` file:
  ```plaintext
  SCOUT_DRIVER=database 
  ```

### 4. **Laravel Socialite (laravel/socialite)**
- Configure your social media keys in the `.env` file if using social login.

### 5. **Stripe (stripe/stripe-php)**
- Obtain your Stripe keys from the [Stripe Dashboard](https://dashboard.stripe.com/).
- Update the `.env` file with your Stripe credentials:
  ```plaintext
  STRIPE_KEY=your-stripe-key
  STRIPE_SECRET=your-stripe-secret
  ```

---

## Documentation

For detailed documentation, including the **Software Requirements Specification (SRS)**, please refer to the [Documentation Folder](/docs).

---

## Contributing

If you'd like to contribute to this project, please follow these steps:
1. Fork the repository.
2. Create a new branch (`git checkout -b feature/YourFeatureName`).
3. Commit your changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature/YourFeatureName`).
5. Open a pull request.

---


## Contact

If you have any questions or feedback, feel free to reach out:
- **Email**: makdad.taleb@gmail.com
- **GitHub**: [mkdad-123](https://github.com/mkdad-123)

