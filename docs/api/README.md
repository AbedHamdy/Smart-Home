# Khedmaty — API Documentation (v1)

Base URL: `https://your-domain.com/api/v1/`

This document describes the RESTful API for Khedmaty (version v1). It is written in English for discussion and review. Keep this file in `docs/` (e.g., `docs/API.md`) and generate machine-readable spec (OpenAPI) for client generation and testing.

---

## Authentication
All protected endpoints require a Bearer token in the `Authorization` header:

Header example:
```
Authorization: Bearer {token}
```

Login endpoint (returns token and user info)
```
POST /api/v1/auth/login
Content-Type: application/json

Request body:
{
  "email": "user@example.com",
  "password": "password"
}

Response (200):
{
  "token": "eyJhbGciOiJI...",
  "user": {
    "id": 1,
    "name": "User Name",
    "email": "user@example.com",
    "role": "homeowner"
  },
  "expires_in": 3600
}
```

Notes:
- Describe token expiry and refresh mechanism (if any) here.
- If using Laravel Sanctum, document cookie vs token-based flows and CSRF requirements.

---

## Devices

### List Devices
```
GET /api/v1/devices
Headers: Authorization: Bearer {token}
```
Response (200):
```json
{
  "devices": [
    {
      "id": 1,
      "name": "Living Room Light",
      "type": "light",
      "status": "online",
      "last_reading": "2025-11-01T12:00:00Z",
      "room": "living_room",
      "model": "Philips Hue"
    }
  ],
  "meta": {
    "page": 1,
    "per_page": 20,
    "total": 1
  }
}
```
Support query params for pagination, filtering and sorting (e.g., `?page=1&per_page=20&status=online&type=light`).

### Add Device
```
POST /api/v1/devices
Headers: Authorization: Bearer {token}
Content-Type: application/json

Request body:
{
  "name": "Kitchen Light",
  "type": "light",
  "room": "kitchen",
  "model": "Philips Hue"
}
```
Response (201):
```json
{
  "device": {
    "id": 12,
    "name": "Kitchen Light",
    "type": "light",
    "room": "kitchen",
    "model": "Philips Hue",
    "status": "offline",
    "created_at": "2025-11-01T12:10:00Z"
  }
}
```

---

## Technicians

### List Technicians
```
GET /api/v1/technicians
Headers: Authorization: Bearer {token}
Query params:
- category (string) — filter by expertise
- rating (number) — minimum rating
- available (true|false)
- page, per_page
```
Response (200):
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
  ],
  "meta": {...}
}
```

### Book Appointment
```
POST /api/v1/appointments
Headers: Authorization: Bearer {token}
Content-Type: application/json

Request body:
{
  "technician_id": 1,
  "service_type": "repair",
  "description": "AC not cooling",
  "preferred_date": "2025-11-15",
  "preferred_time": "14:00"
}
```
Response (201):
```json
{
  "appointment": {
    "id": 101,
    "technician_id": 1,
    "user_id": 10,
    "service_type": "repair",
    "status": "pending",
    "scheduled_at": "2025-11-15T14:00:00Z"
  }
}
```

---

## Error Responses
Common HTTP status codes:
- 200 OK — success
- 201 Created — resource created
- 400 Bad Request — invalid input
- 401 Unauthorized — missing/invalid token
- 403 Forbidden — insufficient permissions
- 404 Not Found — resource not found
- 422 Unprocessable Entity — validation errors
- 500 Internal Server Error — server error

Example error (422):
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

Document validation rules for each endpoint (required fields, formats, max lengths).

---

## Rate Limiting
- Default limit: 60 requests per minute per user (adjustable).
- Response headers:
  - `X-RateLimit-Limit`: 60
  - `X-RateLimit-Remaining`: 57
  - `X-RateLimit-Reset`: 1698835200  (epoch timestamp)
- On limit exceeded: return 429 Too Many Requests with informative body.

---

## Versioning
- API prefix: `/api/v1/`
- Keep version in URL. Add changelog section when breaking changes occur.
- Consider supporting Accept header negotiation if needed.

---

## Testing & Credentials
Test credentials (for dev/staging only):
- Email: `test@example.com`
- Password: `password`

Security note: Do NOT commit real credentials to the repository or expose production test accounts. Remove or rotate these before public releases.

---

## Examples (cURL)

Login and list devices:
```bash
# Login
curl -X POST https://your-domain.com/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password"}'

# Use token returned in next requests:
curl -X GET https://your-domain.com/api/v1/devices \
  -H "Authorization: Bearer eyJhbGci..." \
  -H "Accept: application/json"
```

---

## Pagination, Filtering & Sorting (recommendation)
- Use `page` and `per_page` for pagination; include `meta` object in responses.
- Filtering: accept query params like `?type=light&status=online`.
- Sorting: `?sort=created_at` or `?sort=-rating` (prefix `-` for DESC).

---

## Schema & Documentation Suggestions
- Produce an OpenAPI (Swagger) YAML/JSON spec covering:
  - Paths, parameters, request/response schemas, security schemes
  - Response examples for success and common errors
- Generate interactive docs (Swagger UI or Redoc) and a Postman collection.
- Consider using tools:
  - scribe (Laravel) to auto-generate API docs from routes/controllers
  - swagger-lume or L5-Swagger for Laravel OpenAPI
  - laravel-apidoc-generator

---

## Security Recommendations
- Use HTTPS and secure WebSockets (wss://).
- Use short-lived tokens and refresh flow.
- Enforce role-based authorization for sensitive endpoints (device control, scheduling).
- Rate-limit authentication endpoints strongly to mitigate brute force.
- Log audit trail for device commands and technician bookings.

---

## Next actions (for discussion)
- Run `php artisan route:list --path=api` and paste the real route list here to finalize endpoints.
- Create an OpenAPI spec and Postman collection for testing.
- Remove or replace any real test credentials before publishing docs.
- Decide whether API docs will be public or kept in a private docs site.

---
