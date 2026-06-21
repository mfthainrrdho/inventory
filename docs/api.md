# API Documentation - Inventory System

## Base URL
`/api/v1`

## Authentication
- Register & Login tidak butuh token
- Endpoint protected gunakan `Authorization: Bearer {token}`

## Endpoints

### Auth
- **POST** `/api/v1/register`
- **POST** `/api/v1/login`

### Items
- **GET** `/api/v1/items`
- **POST** `/api/v1/items`
- **GET** `/api/v1/items/{id}`
- **PUT** `/api/v1/items/{id}`
- **DELETE** `/api/v1/items/{id}`

### Categories (sama struktur)

**Response Success:**
```json
{
  "success": true,
  "message": "Success",
  "data": { ... }
}

**Response Error:**
{
    "success": false,
    "message": "Item not Found",
    "errors": []
}