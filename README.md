# Laravel Post CRUD API with Authentication

## API Endpoints

### Authentication Endpoints (Public)

#### Register

- **URL:** `POST /api/v1/auth/register`
- **Headers:** `Content-Type: application/json`
- **Body:**

```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

- **Response:** 201 Created

```json
{
    "message": "User registered successfully",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "created_at": "2026-01-19T10:00:00.000000Z",
        "updated_at": "2026-01-19T10:00:00.000000Z"
    },
    "token": "auth_token_here"
}
```

#### Login

- **URL:** `POST /api/v1/auth/login`
- **Headers:** `Content-Type: application/json`
- **Body:**

```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

- **Response:** 200 OK

```json
{
    "message": "User logged in successfully",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "created_at": "2026-01-19T10:00:00.000000Z",
        "updated_at": "2026-01-19T10:00:00.000000Z"
    },
    "token": "auth_token_here"
}
```

### Protected Endpoints (Require Authentication)

#### Get Current User

- **URL:** `GET /api/v1/user`
- **Headers:** `Authorization: Bearer {token}`
- **Response:** 200 OK (User object)

#### Logout

- **URL:** `POST /api/v1/auth/logout`
- **Headers:** `Authorization: Bearer {token}`
- **Response:** 200 OK

```json
{
    "message": "User logged out successfully"
}
```

### Post CRUD Endpoints (Require Authentication)

#### Get All User Posts

- **URL:** `GET /api/v1/posts`
- **Headers:** `Authorization: Bearer {token}`
- **Response:** 200 OK (Array of posts)

#### Create Post

- **URL:** `POST /api/v1/posts`
- **Headers:**
    - `Authorization: Bearer {token}`
    - `Content-Type: application/json`
- **Body:**

```json
{
    "title": "Post Title",
    "content": "Post content here..."
}
```

- **Response:** 201 Created

```json
{
    "id": 1,
    "user_id": 1,
    "title": "Post Title",
    "content": "Post content here...",
    "created_at": "2026-01-19T10:00:00.000000Z",
    "updated_at": "2026-01-19T10:00:00.000000Z"
}
```

#### Get Single Post

- **URL:** `GET /api/v1/posts/{id}`
- **Headers:** `Authorization: Bearer {token}`
- **Response:** 200 OK (Post object)
- **Note:** User can only view their own posts (authorization policy enforced)

#### Update Post

- **URL:** `PUT|PATCH /api/v1/posts/{id}`
- **Headers:**
    - `Authorization: Bearer {token}`
    - `Content-Type: application/json`
- **Body:**

```json
{
    "title": "Updated Title",
    "content": "Updated content..."
}
```

- **Response:** 200 OK (Updated post object)
- **Note:** User can only update their own posts (authorization policy enforced)

#### Delete Post

- **URL:** `DELETE /api/v1/posts/{id}`
- **Headers:** `Authorization: Bearer {token}`
- **Response:** 204 No Content
- **Note:** User can only delete their own posts (authorization policy enforced)

## Validation Rules

### Register

- `name`: Required, string, max 255 characters
- `email`: Required, email format, must be unique
- `password`: Required, string, minimum 8 characters, must be confirmed

### Login

- `email`: Required, email format
- `password`: Required, string

### Create/Update Post

- `title`: Required, string, max 255 characters
- `content`: Required, string

## Authentication

All protected endpoints require an `Authorization` header with a Bearer token:

```
Authorization: Bearer {token}
```

The token is obtained from the `/api/v1/auth/register` or `/api/v1/auth/login` endpoints.

## Features

-  User authentication using Laravel Sanctum
-  Post CRUD operations
-  Request validation on all endpoints
-  Authorization policies (users can only manage their own posts)
-  API versioning (v1)
-  Proper HTTP response codes and JSON responses
-  MySQL database integration
