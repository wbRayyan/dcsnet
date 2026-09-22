# DCSnet — Dealer & Customer Service Network

A BMW-inspired Workshop Management REST API built with Laravel 11, MySQL, and Laravel Sanctum.

## Tech Stack

- **Backend:** Laravel 11 (PHP)
- **Database:** MySQL
- **Authentication:** Laravel Sanctum (Token-based)
- **Tools:** Composer, Artisan CLI

## Features

- Customer registration and login (JWT-style tokens)
- Token-based authentication and authorization
- Customers can only access their own vehicles
- Full vehicle management (CRUD)
- Service job creation and tracking
- Mechanic assignment with availability management
- Job status progression: `pending → in_progress → completed`
- Filter jobs by status

## API Endpoints

### Auth (Public)
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/register` | Register a new customer |
| POST | `/api/login` | Login and receive token |
| POST | `/api/logout` | Logout (token required) |

### Cars (Protected)
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/cars` | Get your cars |
| POST | `/api/cars` | Add a car |
| GET | `/api/cars/{id}` | Get specific car |
| PUT | `/api/cars/{id}` | Update car |
| DELETE | `/api/cars/{id}` | Delete car |

### Mechanics (Protected)
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/mechanics` | Get all mechanics |
| POST | `/api/mechanics` | Add mechanic |
| GET | `/api/mechanics/{id}` | Get specific mechanic |
| PUT | `/api/mechanics/{id}` | Update mechanic |
| DELETE | `/api/mechanics/{id}` | Delete mechanic |

### Service Jobs (Protected)
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/service-jobs` | Get all your jobs |
| GET | `/api/service-jobs?status=pending` | Filter by status |
| POST | `/api/service-jobs` | Create service job |
| GET | `/api/service-jobs/{id}` | Get specific job |
| PATCH | `/api/service-jobs/{id}/assign` | Assign mechanic |
| PATCH | `/api/service-jobs/{id}/status` | Update job status |

## Getting Started

### Requirements
- PHP 8.2+
- Composer
- MySQL

### Installation

1. Clone the repository:
```bash
git clone https://github.com/wbRayyan/dcsnet.git
cd dcsnet
```

2. Install dependencies:
```bash
composer install
```

3. Copy environment file:
```bash
cp .env.example .env
```

4. Configure database in `.env`:
```env
DB_DATABASE=dcsnet
DB_USERNAME=root
DB_PASSWORD=
```

5. Generate app key:
```bash
php artisan key:generate
```

6. Run migrations:
```bash
php artisan migrate
```

7. Start server:
```bash
php artisan serve
```

## Example Flow

1. Register as customer
2. Login → receive token
3. Add your BMW to the system
4. Create a service job for your car
5. Assign an available mechanic
6. Track job status: pending → in_progress → completed

## Author

**Rayan Bhatti**
- GitHub: [@wbRayyan](https://github.com/wbRayyan)
- LinkedIn: [linkedin.com/in/wb-rayan-bhatti](https://linkedin.com/in/wb-rayan-bhatti)