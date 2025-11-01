# Khedmaty — Maintenance System

Copyright (c) 2025 AbedHamdy

All rights reserved.

This project and its contents (code, documentation, assets) are proprietary and may not be copied, modified, redistributed, or published in any form without the prior written permission of the copyright holder.

## Overview
Khedmaty (Smart Home) is a comprehensive home automation and management system built with Laravel. The system allows homeowners to manage their smart devices, schedule maintenance, and connect with qualified technicians for repairs and installations.

## Features

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

- **User Authentication**
  - Separate portals for homeowners and technicians
  - Secure login and registration system
  - Password recovery functionality

- **Device Management**
  - Add and manage smart home devices
  - Monitor device status and health
  - View device history and usage statistics

- **Technician Services**
  - Browse qualified technicians by category
  - Schedule maintenance appointments
  - Real-time technician tracking
  - Rate and review service quality

- **Smart Home Automation**
  - Device scheduling and automation
  - Energy usage monitoring
  - Custom automation rules
  - Remote device control

## Technology Stack
- **Backend**: Laravel 10.x
- **Frontend**: Blade Templates, TailwindCSS
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **Real-time Features**: Laravel WebSockets
- **Payment Processing**: Stripe Integration

## Installation

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL

### Setup Instructions
1. Clone the repository
```bash
git clone https://github.com/AbedHamdy/Khedmaty.git
cd Smart-Home
```

2. Install PHP dependencies
```bash
composer install
```

3. Install JavaScript dependencies
```bash
npm install
```

4. Create environment file
```bash
cp .env.example .env
```

5. Generate application key
```bash
php artisan key:generate
```

6. Configure database settings in `.env` file
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run database migrations and seeders
```bash
php artisan migrate --seed
```

8. Build frontend assets
```bash
npm run build
```

9. Start the development server
```bash
php artisan serve
```

## Project Structure
```
Khedmaty/
├── app/                    # Application core code
│   ├── Http/              # Controllers and Middleware
│   ├── Models/            # Eloquent models
│   └── Services/          # Business logic services
├── database/              # Database migrations and seeders
├── resources/             # Frontend assets and views
│   ├── css/              # Stylesheets
│   ├── js/               # JavaScript files
│   └── views/            # Blade templates
├── routes/                # Application routes
└── tests/                # Test files
```

## API Documentation
The system provides a RESTful API for device integration and third-party services. Documentation can be found in the `docs/api` directory.

### Available Endpoints
- `/api/devices` - Device management
- `/api/technicians` - Technician services
- `/api/appointments` - Appointment scheduling
- `/api/users` - User management

## Security
- All user passwords are hashed using bcrypt
- CSRF protection enabled for all forms
- API authentication using Laravel Sanctum
- Input validation and sanitization
- XSS protection

## Testing
Run the test suite using:
```bash
php artisan test
```

## Contributing
1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License
Copyright (c) 2025 AbedHamdy

All rights reserved.

This project and its contents (code, documentation, assets) are proprietary and may not be copied, modified, redistributed, or published in any form without the prior written permission of the copyright holder.

This repository is for viewing only. Copying, modifying, or redistributing the content is not permitted without written permission.

## Support
For support, please email abdooooohamdy@gmail.com or open an issue in the GitHub repository.

## Authors
- Abed Hamdy - Initial work and maintenance
