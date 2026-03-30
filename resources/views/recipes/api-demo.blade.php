@extends('layouts.app')

@section('title', 'Recipe API Demo')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Recipe API Demo - Async Interaction</h1>
    
    <div id="messageBox" class="mb-3"></div>
    
    <form id="recipeForm" class="mb-5 p-4 border rounded" style="background-color: #f8f9fa;">
        @csrf
        <h3 class="mb-3">Add New Recipe</h3>
        
        <div class="mb-3">
            <label for="name" class="form-label">Recipe Name</label>
            <input type="text" id="name" class="form-control" placeholder="Recipe Name" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" class="form-control" rows="2" placeholder="Description" required></textarea>
        </div>
        
        <div class="mb-3">
            <label for="ingredients" class="form-label">Ingredients</label>
            <textarea id="ingredients" class="form-control" rows="3" placeholder="List ingredients" required></textarea>
        </div>
        
        <div class="mb-3">
            <label for="instructions" class="form-label">Instructions</label>
            <textarea id="instructions" class="form-control" rows="3" placeholder="Step-by-step instructions" required></textarea>
        </div>
        
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select id="category_id" class="form-control" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Tags</label>
            <div>
                @foreach($tags as $tag)
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input tag-checkbox" id="tag_{{ $tag->id }}" value="{{ $tag->id }}">
                        <label class="form-check-label" for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Add Recipe</button>
    </form>
    
    <h3 class="mb-3">Recipes</h3>
    <div id="recipeList" class="row"></div>
</div>

<script>
    // Load recipes from API
    async function loadRecipes() {
        try {
            const response = await fetch('/api/recipes');
            const recipes = await response.json();
            const recipeList = document.getElementById('recipeList');
            
            recipeList.innerHTML = '';
            
            if (recipes.length === 0) {
                recipeList.innerHTML = '<p class="col-12">No recipes found.</p>';
                return;
            }
            
            recipes.forEach(recipe => {
                const categoryName = recipe.category ? recipe.category.name : 'No Category';
                const tags = recipe.tags.length > 0 
                    ? recipe.tags.map(tag => tag.name).join(', ')
                    : 'No tags';
                
                const recipeHtml = `
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">${escapeHtml(recipe.name)}</h5>
                                <p class="card-text"><strong>Category:</strong> ${escapeHtml(categoryName)}</p>
                                <p class="card-text"><strong>Tags:</strong> ${escapeHtml(tags)}</p>
                                <p class="card-text"><strong>Description:</strong></p>
                                <p class="card-text" style="font-size: 0.9em;">${escapeHtml(recipe.description)}</p>
                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteRecipe(${recipe.id})">Delete</button>
                            </div>
                        </div>
                    </div>
                `;
                recipeList.innerHTML += recipeHtml;
            });
        } catch (error) {
            console.error('Error loading recipes:', error);
            document.getElementById('messageBox').innerHTML = 
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">Failed to load recipes.</div>';
        }
    }
    
    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Handle form submission
    document.getElementById('recipeForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const selectedTags = Array.from(document.querySelectorAll('.tag-checkbox:checked'))
            .map(tag => parseInt(tag.value));
        
        const payload = {
            name: document.getElementById('name').value,
            description: document.getElementById('description').value,
            ingredients: document.getElementById('ingredients').value,
            instructions: document.getElementById('instructions').value,
            category_id: parseInt(document.getElementById('category_id').value),
            tags: selectedTags
        };
        
        try {
            const response = await fetch('/api/recipes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(payload)
            });
            
            const result = await response.json();
            const messageBox = document.getElementById('messageBox');
            
            if (response.ok) {
                messageBox.innerHTML = 
                    `<div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${escapeHtml(result.message)}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>`;
                document.getElementById('recipeForm').reset();
                loadRecipes();
            } else {
                if (result.errors) {
                    let errorsHtml = '<ul class="mb-0">';
                    Object.values(result.errors).forEach(messages => {
                        messages.forEach(message => {
                            errorsHtml += `<li>${escapeHtml(message)}</li>`;
                        });
                    });
                    errorsHtml += '</ul>';
                    messageBox.innerHTML = 
                        `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Validation Errors:</strong>
                            ${errorsHtml}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>`;
                } else {
                    messageBox.innerHTML = 
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">Failed to create recipe.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                }
            }
        } catch (error) {
            console.error('Error creating recipe:', error);
            document.getElementById('messageBox').innerHTML = 
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">An error occurred while creating the recipe.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        }
    });
    
    // Handle recipe deletion
    async function deleteRecipe(id) {
        if (!confirm('Are you sure you want to delete this recipe?')) {
            return;
        }
        
        try {
            const token = document.querySelector('input[name="_token"]').value;
            const response = await fetch(`/api/recipes/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            });
            
            const result = await response.json();
            const messageBox = document.getElementById('messageBox');
            
            if (response.ok) {
                messageBox.innerHTML = 
                    `<div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${escapeHtml(result.message)}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>`;
                loadRecipes();
            } else {
                messageBox.innerHTML = 
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">Failed to delete recipe.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
            }
        } catch (error) {
            console.error('Error deleting recipe:', error);
            document.getElementById('messageBox').innerHTML = 
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">An error occurred while deleting the recipe.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        }
    }
    
    // Load recipes when page loads
    document.addEventListener('DOMContentLoaded', loadRecipes);
</script>

<style>
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
</style>
@endsection
