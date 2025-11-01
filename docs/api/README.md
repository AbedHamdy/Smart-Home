# Smart Home API Documentation

## Authentication
All API routes except authentication endpoints require a valid Bearer token in the Authorization header.

### Login
```http
POST /api/auth/login
```

Request body:
```json
{
    "email": "user@example.com",
    "password": "password"
}
```

Response:
```json
{
    "token": "Bearer token",
    "user": {
        "id": 1,
        "name": "User Name",
        "email": "user@example.com",
        "role": "homeowner"
    }
}
```

## Devices

### List Devices
```http
GET /api/devices
```

Response:
```json
{
    "devices": [
        {
            "id": 1,
            "name": "Living Room Light",
            "type": "light",
            "status": "online",
            "last_reading": "2025-11-01T12:00:00Z"
        }
    ]
}
```

### Add Device
```http
POST /api/devices
```

Request body:
```json
{
    "name": "Kitchen Light",
    "type": "light",
    "room": "kitchen",
    "model": "Phillips Hue"
}
```

## Technicians

### List Technicians
```http
GET /api/technicians
```

Query parameters:
- `category`: Filter by expertise category
- `rating`: Filter by minimum rating
- `available`: Filter by availability (true/false)

Response:
```json
{
    "technicians": [
        {
            "id": 1,
            "name": "John Doe",
            "specialization": "Electrical",
            "rating": 4.8,
            "available": true
        }
    ]
}
```

### Book Appointment
```http
POST /api/appointments
```

Request body:
```json
{
    "technician_id": 1,
    "service_type": "repair",
    "description": "AC not cooling",
    "preferred_date": "2025-11-15",
    "preferred_time": "14:00"
}
```

## Error Responses
All endpoints may return the following error responses:

- 400 Bad Request: Invalid input
- 401 Unauthorized: Missing or invalid token
- 403 Forbidden: Insufficient permissions
- 404 Not Found: Resource not found
- 422 Unprocessable Entity: Validation errors
- 500 Server Error: Internal server error

Example error response:
```json
{
    "error": {
        "message": "The given data was invalid.",
        "errors": {
            "email": ["The email field is required."]
        }
    }
}
```

## Rate Limiting
API requests are limited to 60 per minute per user. The following headers are included in responses:
- X-RateLimit-Limit
- X-RateLimit-Remaining
- X-RateLimit-Reset

## Versioning
Current API version: v1
Include the version in the URL: `/api/v1/`

## Testing
Test credentials:
- Email: test@example.com
- Password: password

## Support
For API support, contact api-support@smarthome.com