# Laravel Orders API with Service and Repository Pattern

## Overview

This API allows you to change the status of an order to 'paid' and update the user's points based on the order total.


## Setup
1. Clone repo: `git clone <url>`
2. Install dependencies: `composer install`
3. Generate app key: `php artisan key:generate`
5. Run migrations and seeders: `php artisan migrate --seed`
6. Start server: `php artisan serve`
7. Generate Swagger docs: `php artisan l5-swagger:generate`

## App Structure
  - `Controllers/OrderController.php`: Handles API requests.
  - `Services/)rderService.php`: Business logic.
  - `Repositories/OrderRepository.php`: Database queries.
  - `Models/User.php && Order.php`: Eloquent model.
  - `Requests/*`:OrderPayRequest Validation for CRUD and search.

## Endpoints

### Pay for an Order

- **URL**: `POST /api/orders/{order_id}/pay`

- **Response** (Success):
    ```json
    {
        "order": {
            "id": "order_id",
            "user_id": "user_id",
            "total_price": "order_total",
            "status": "paid"
        },
        "new_points": "user_points"
    }
