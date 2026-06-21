# API Documentation - Inventory System

## Base URL
`/api/v1`

## Authentication
- Register & Login tidak butuh token
- Endpoint protected gunakan `Authorization: Bearer {token}`

## Endpoints

### Auth
- **POST** `/api/v1/register` - Register user baru
- **POST** `/api/v1/login` - Login user

---

### Items

#### GET `/api/v1/items` - Get All Items (with optional category filter)

**Description:**  
Mendapatkan semua data item. Endpoint ini mendukung filter opsional berdasarkan `category_id`.

**Query Parameters:**
- `category_id` (integer, **optional**) — ID kategori untuk memfilter items. Jika tidak dikirim, akan mengembalikan semua items.

**Headers:**  
`Authorization: Bearer {token}` (jika endpoint protected)

**Contoh Request:**
GET /api/v1/items
GET /api/v1/items?category_id=3

**Contoh Response Sukses:**
```json
{
  "success": true,
  "data": [ ... ],
  "message": "Items retrieved successfully"
}