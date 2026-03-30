# Lab 8 Testing Guide - API Endpoints & Async Interaction

## Quick Start

1. **Start the server:**

    ```bash
    php artisan serve
    ```

2. **Access the demo page:**
    - Open `http://127.0.0.1:8000/recipes-api-demo`
    - The page will automatically load all recipes from the API

3. **Test the API directly:**
    - Open Postman or use `curl` commands
    - Base URL: `http://127.0.0.1:8000/api`

---

## API Endpoint Tests

### Test 1: List All Recipes (GET)

**Request:**

```
GET http://127.0.0.1:8000/api/recipes
```

**Expected Response:**

- Status: `200 OK`
- Body: Array of recipes with category and tags

```json
[
    {
        "id": 1,
        "name": "Recipe Name",
        "description": "...",
        "ingredients": "...",
        "instructions": "...",
        "category_id": 1,
        "category": {
            "id": 1,
            "name": "Category Name"
        },
        "tags": [{ "id": 1, "name": "Tag Name" }]
    }
]
```

**What This Tests:**

- ✓ API endpoint works
- ✓ Relationships are eager-loaded
- ✓ JSON structure is correct

---

### Test 2: Get Single Recipe (GET)

**Request:**

```
GET http://127.0.0.1:8000/api/recipes/1
```

**Expected Response:**

- Status: `200 OK`
- Body: Single recipe object with relationships

**What This Tests:**

- ✓ Model binding works
- ✓ Single recipe retrieval
- ✓ Relationships included

---

### Test 3: Create Recipe (POST)

**Request:**

```
POST http://127.0.0.1:8000/api/recipes
Content-Type: application/json

{
  "name": "Chocolate Cake",
  "description": "A delicious chocolate cake",
  "ingredients": "Flour, cocoa, sugar, eggs, butter",
  "instructions": "Mix and bake at 350F for 30 minutes",
  "category_id": 1,
  "tags": [1, 2]
}
```

**Expected Response:**

- Status: `201 Created`
- Body:

```json
{
  "message": "Recipe created successfully.",
  "recipe": {
    "id": 5,
    "name": "Chocolate Cake",
    "category": {...},
    "tags": [...]
  }
}
```

**What This Tests:**

- ✓ POST creates new resource
- ✓ Validation works
- ✓ Returns 201 status
- ✓ Tags are attached
- ✓ Relationships are loaded

---

### Test 4: Create with Validation Error (POST)

**Request:** Same as Test 3, but missing required field

```json
{
    "description": "...",
    "ingredients": "...",
    "instructions": "...",
    "category_id": 1,
    "tags": []
}
```

**Expected Response:**

- Status: `422 Unprocessable Entity`
- Body:

```json
{
    "errors": {
        "name": ["The name field is required."]
    }
}
```

**What This Tests:**

- ✓ Validation catches errors
- ✓ Proper error response format
- ✓ Correct HTTP status code

---

### Test 5: Update Recipe (PUT)

**Request:**

```
PUT http://127.0.0.1:8000/api/recipes/1
Content-Type: application/json

{
  "name": "Updated Name",
  "description": "Updated description",
  "ingredients": "Updated ingredients",
  "instructions": "Updated instructions",
  "category_id": 2,
  "tags": [2, 3, 4]
}
```

**Expected Response:**

- Status: `200 OK`
- Body:

```json
{
  "message": "Recipe updated successfully.",
  "recipe": {
    "id": 1,
    "name": "Updated Name",
    "category": {"id": 2},
    "tags": [...]
  }
}
```

**What This Tests:**

- ✓ PUT updates record
- ✓ Tags are synced (replaced)
- ✓ Returns updated record
- ✓ Relationships updated

---

### Test 6: Delete Recipe (DELETE)

**Request:**

```
DELETE http://127.0.0.1:8000/api/recipes/1
```

**Expected Response:**

- Status: `200 OK`
- Body:

```json
{
    "message": "Recipe deleted successfully."
}
```

**Verification:**

- Run Test 1 again
- Recipe should no longer appear in list

**What This Tests:**

- ✓ DELETE removes record
- ✓ Record gone from list
- ✓ Proper success response

---

## Demo Page Tests

### Test 1: Page Load & Initial Recipe Display

**Action:** Open `http://127.0.0.1:8000/recipes-api-demo`

**Expected:**

- Page loads without errors
- Recipe list populates automatically
- Each recipe shows:
    - Name
    - Category
    - Tags
    - Description
    - Delete button

**What This Tests:**

- ✓ JavaScript loads recipes on page load
- ✓ fetch('/api/recipes') works
- ✓ Recipes render to DOM
- ✓ Relationships display

---

### Test 2: Create Recipe Asynchronously

**Action:**

1. Fill form fields:
    - Name: "Test Recipe"
    - Description: "A test"
    - Ingredients: "Ingredient list"
    - Instructions: "Steps"
    - Category: Select one
    - Tags: Check 2-3
2. Click "Add Recipe" button

**Expected:**

- ✓ No page reload
- ✓ Success message appears in green
- ✓ Form clears
- ✓ New recipe appears in list

**What This Tests:**

- ✓ Form submit handler works
- ✓ fetch() POST succeeds
- ✓ CSRF token sent
- ✓ Form reset on success
- ✓ List reloads

---

### Test 3: Validation Error Display

**Action:**

1. Leave name field empty
2. Fill other fields
3. Click "Add Recipe"

**Expected:**

- ✓ Error message in red
- ✓ Shows "The name field is required."
- ✓ Form NOT cleared
- ✓ Recipe NOT added to list

**What This Tests:**

- ✓ Error parsing works
- ✓ Errors display to user
- ✓ Form preserved on error

---

### Test 4: Delete Recipe

**Action:**

1. Click "Delete" on any recipe
2. Confirm deletion

**Expected:**

- ✓ No page reload
- ✓ Success message appears
- ✓ Recipe disappears from list

**If you cancel:**

- ✓ Nothing happens
- ✓ Recipe stays

**What This Tests:**

- ✓ DELETE method works
- ✓ Confirmation dialog works
- ✓ CSRF token sent
- ✓ DOM updates

---

### Test 5: Multiple Operations

**Action:**

1. Create 3 recipes
2. Delete the middle one
3. Create another
4. Edit a recipe (view its data)

**Expected:**

- ✓ All operations work
- ✓ List always in sync
- ✓ No page reloads

**What This Tests:**

- ✓ Multiple async operations work
- ✓ List updates consistently
- ✓ Stability under load

---

## Browser Console Testing

**Action:** Open DevTools (F12) → Console Tab

**Check for:**

- ✓ No red error messages
- ✓ No CORS errors
- ✓ No 404 errors for `/api` routes

### Network Tab Testing

1. Open DevTools → Network Tab
2. Perform operations
3. Look for:
    - `GET /api/recipes` → Status 200
    - `POST /api/recipes` → Status 201
    - `DELETE /api/recipes/{id}` → Status 200

**Expected:**

- ✓ All requests succeed
- ✓ Responses contain JSON
- ✓ No authentication errors

---

## curl Command Examples

If you prefer testing with curl instead of Postman:

### Get All Recipes

```bash
curl http://127.0.0.1:8000/api/recipes
```

### Get Single Recipe

```bash
curl http://127.0.0.1:8000/api/recipes/1
```

### Create Recipe

```bash
# First get CSRF token from page
curl -s http://127.0.0.1:8000/recipes-api-demo | grep '_token' | head -1 | grep -oP 'value="\K[^"]*'

# Then use token in request
curl -X POST http://127.0.0.1:8000/api/recipes \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: <token>" \
  -d '{"name":"Test","description":"Test","ingredients":"Test","instructions":"Test","category_id":1,"tags":[]}'
```

### Delete Recipe

```bash
curl -X DELETE http://127.0.0.1:8000/api/recipes/1 \
  -H "X-CSRF-TOKEN: <token>"
```

---

## Troubleshooting

### Problem: 404 on API routes

**Solution:**

```bash
php artisan route:clear
php artisan config:clear
php artisan serve
```

### Problem: CSRF token error

**Check:**

- Page includes `@csrf` directive
- JavaScript grabs token correctly
- Token sent in X-CSRF-TOKEN header

### Problem: Recipes don't load on demo page

**Check:**

- Browser console for errors (F12)
- Network tab shows `/api/recipes` request
- Server is running (`php artisan serve`)

### Problem: Can't delete recipes

**Check:**

- Database has recipes
- DELETE request sent correctly
- CSRF token present

---

## Success Criteria Checklist

- [ ] GET /api/recipes returns all recipes
- [ ] GET /api/recipes/{id} returns single recipe
- [ ] POST /api/recipes creates recipe (201 status)
- [ ] PUT /api/recipes/{id} updates recipe
- [ ] DELETE /api/recipes/{id} deletes recipe
- [ ] Demo page loads recipes on page load
- [ ] Can create recipe in form without reload
- [ ] Can delete recipe from list without reload
- [ ] Validation errors display
- [ ] Success messages display
- [ ] Multiple operations work correctly
- [ ] No console errors
- [ ] No network errors

**If all items checked, Lab 8 is complete! ✅**
