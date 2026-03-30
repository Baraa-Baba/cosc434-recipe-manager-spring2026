# COSC 434 – Advanced Web Programming | Recipe Manager Application

**Name:** Baraa Baba  
**Course:** COSC 434 – Advanced Web Programming  
**Semester:** Spring 2026

## Project Overview

This is a comprehensive Laravel Recipe Management Application demonstrating modern web development practices including middleware, RESTful APIs, and asynchronous frontend interactions.

---

## Lab Session 6: Protecting Routes with Middleware ✅

### Overview

Implemented route protection through custom middleware to separate public recipe viewing from authenticated management operations.

### Implementation Summary

- **Custom Middleware:** Created `app/Http/Middleware/EnsureUserIsLoggedIn.php` to check session state
- **Demo Authentication:** Implemented `/login-demo` and `/logout-demo` routes that toggle session flag `logged_in`
- **Route Protection:** Applied `demo.auth` middleware to create, edit, update, and delete operations
- **Public Access:** Index and show routes remain open to all visitors
- **User Feedback:** Flash messages for login/logout success and access denied scenarios
- **UI Integration:** Demo login/logout controls in header, conditional visibility of management links

### Key Files

- `app/Http/Middleware/EnsureUserIsLoggedIn.php`
- `bootstrap/app.php` (middleware alias registration)
- `routes/web.php` (protected route group)
- `resources/views/layouts/app.blade.php`

### Testing Results

- ✅ Public recipe list accessible without authentication
- ✅ Management routes blocked for guests (redirect to home)
- ✅ Management routes accessible after demo login
- ✅ Routes blocked again after demo logout
- ✅ Flash messages display correctly

---

## Lab Session 8: Building API Endpoints & Async Interaction ✅

### Overview

Extended the Recipe App with a RESTful JSON API and asynchronous frontend interactions, allowing real-time recipe management without page reloads.

### Implementation Summary

**API Controller:**

- Created `App\Http\Controllers\API\RecipeController` with `--api` flag
- Implemented 5 RESTful methods:
    - `index()` - Returns all recipes with relationships (category, tags)
    - `show($recipe)` - Returns single recipe with relationships
    - `store(Request $request)` - Creates recipe with validation (returns 201)
    - `update(Request $request, Recipe $recipe)` - Updates recipe and syncs tags
    - `destroy(Recipe $recipe)` - Deletes recipe

**API Routes:**

- Registered via `Route::apiResource('recipes', RecipeController::class)` in `routes/api.php`
- 5 endpoints: `GET/POST /api/recipes` and `GET/PUT/DELETE /api/recipes/{id}`

**Async Demo Page:**

- Located at `/recipes-api-demo`
- Form to create recipes without page reload
- Real-time recipe list that updates dynamically
- Delete functionality with confirmation dialog
- Validation error display
- Success/error flash messages

**JavaScript Features:**

- `loadRecipes()` - Fetches and displays all recipes
- Form submission handler - POSTs new recipe data
- `deleteRecipe()` - Deletes recipe via DELETE request
- CSRF token handling for state-changing operations
- XSS protection via HTML escaping

### Key Files

- `app/Http/Controllers/API/RecipeController.php`
- `routes/api.php`
- `resources/views/recipes/api-demo.blade.php`

### API Endpoints

| Method | Endpoint            | Purpose           | Response                  |
| ------ | ------------------- | ----------------- | ------------------------- |
| GET    | `/api/recipes`      | List all recipes  | 200 with array of recipes |
| POST   | `/api/recipes`      | Create new recipe | 201 with created recipe   |
| GET    | `/api/recipes/{id}` | Get single recipe | 200 with recipe object    |
| PUT    | `/api/recipes/{id}` | Update recipe     | 200 with updated recipe   |
| DELETE | `/api/recipes/{id}` | Delete recipe     | 200 with success message  |

### Testing Results

- ✅ API returns all recipes with category and tags
- ✅ Single recipe endpoint works correctly
- ✅ Create recipe via POST with validation
- ✅ Update recipe via PUT with tag syncing
- ✅ Delete recipe via DELETE
- ✅ Async demo page loads recipes on page load
- ✅ Can create recipe from form without page reload
- ✅ Can delete recipe from UI without page reload
- ✅ Validation errors display properly
- ✅ Success messages appear after operations

---

## Features

- ✅ Full CRUD operations for recipes
- ✅ Category assignment (one per recipe)
- ✅ Multiple tags per recipe (many-to-many relationship)
- ✅ Middleware-protected management routes
- ✅ Demo login/logout system
- ✅ RESTful JSON API endpoints
- ✅ Asynchronous recipe management
- ✅ Server-side validation with error responses
- ✅ Responsive Bootstrap UI
- ✅ CSRF protection on all state-changing operations

---

## Installation & Setup

```bash
# Clone the repository
git clone https://github.com/your-username/cosc434-recipe-manager-spring2026.git
cd cosc434-recipe-manager-spring2026

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database in .env
php artisan migrate

# Start development server
php artisan serve
```

---

## Using the Application

### Web Interface

**Recipe Listing:**

- Visit `http://127.0.0.1:8000/recipes`
- Public page showing all recipes

**Demo Login:**

- Click "Demo Login" button in header
- Enables recipe management features

**Create/Edit/Delete Recipes:**

- Traditional form-based CRUD operations
- Protected by middleware

**API Demo Page:**

- Visit `http://127.0.0.1:8000/recipes-api-demo`
- Interactive async recipe management
- Real-time updates without page reload

### Testing with Postman

**Setup:**

1. Open Postman
2. Create requests with the following base URL: `http://127.0.0.1:8000/api`

**Example: Create Recipe (POST)**

```
POST /api/recipes
Headers:
  Content-Type: application/json
  X-CSRF-TOKEN: <token from page>
Body:
{
  "name": "Pasta",
  "description": "Delicious pasta",
  "ingredients": "Pasta, sauce, cheese",
  "instructions": "Boil and serve",
  "category_id": 1,
  "tags": [1, 2]
}
```

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── API/
│   │   │   └── RecipeController.php (API endpoints)
│   │   └── RecipeController.php (Web CRUD)
│   └── Middleware/
│       └── EnsureUserIsLoggedIn.php
├── Models/
│   ├── Recipe.php
│   ├── Category.php
│   └── Tag.php
│
routes/
├── api.php (API routes with apiResource)
└── web.php (Web routes with middleware groups)

resources/views/recipes/
├── index.blade.php
├── show.blade.php
├── create.blade.php
├── edit.blade.php
└── api-demo.blade.php (Async demo page)
```

---

## Learning Outcomes

Through implementing Labs 6 and 8, you have learned:

**Lab 6 - Middleware:**

- ✅ Create custom middleware classes
- ✅ Register middleware aliases
- ✅ Apply middleware to routes and groups
- ✅ Redirect unauthorized requests
- ✅ Use session for simple authentication

**Lab 8 - API & Async:**

- ✅ Design RESTful API endpoints
- ✅ Return JSON instead of HTML
- ✅ Eager load relationships in APIs
- ✅ Validate input in API endpoints
- ✅ Use fetch() for asynchronous requests
- ✅ Handle CSRF tokens in AJAX
- ✅ Update DOM dynamically
- ✅ Display validation errors
- ✅ Prevent XSS attacks

---

## Troubleshooting

### Routes Not Showing

```bash
# Clear route cache
php artisan route:clear
```

### API Endpoints Returning 404

```bash
# Clear configuration cache
php artisan config:clear

# Restart the development server
php artisan serve
```

### Form Validation Issues

Check that:

- Category exists in database
- Tags exist in database
- All required fields are provided

---

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
