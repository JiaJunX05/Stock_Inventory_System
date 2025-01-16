@extends("admin.layouts.app")

@section("title", "View Product")
@section("content")

<!-- JQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="container mt-4">
    <div class="mb-4">
        <h1 class="text-primary">View Product</h1>
        <p class="text-muted">View and manage your products here.</p><hr>
    </div>
        <div class="row">
            <div class="col-md-3 mt-3 mb-3 text-center">
                <div class="card text-center border-0">
                    <div class="card-body">
                        <img src="{{ asset('assets/' . $product->image) }}" alt="{{ $product->name }}" 
                            class="image img-fluid w-50 object-fit-contain" id="preview-image">
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <p class="text-center fst-italic mt-3 mb-3">
                            With Knowledge Comes Power, <br>
                            With Attitude Comes Character.
                        </p>
                    </div>
                </div>
            </div>            
                 
            <div class="col-md-9">
                <div class="mb-3">
                    <label for="image" class="form-label">Product Image:</label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="image" name="image" disabled>
                        <label class="input-group-text" for="image">Upload</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Product Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Product Description:</label>
                    <textarea class="form-control" id="description" name="description" rows="3" readonly>{{ $product->description }}</textarea>
                </div>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Product Price:</label>
                <input type="text" class="form-control" id="price" name="price" value="RM {{ $product->price }}" readonly>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Product Quantity:</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="quantity" name="quantity" min="1" value="{{ $product->quantity }} Units" readonly>
                    <a href="{{ route('admin.stock', $product->id) }}" class="btn btn-success w-25">Stock</a>
                </div>
            </div> 

            <div class="mb-3">
                <label for="category" class="form-label">Product Category:</label>
                <input type="text" class="form-control" id="category" name="category" value="{{ $product->category }}" readonly>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <!-- Edit Button -->
            <a href="{{ route('admin.edit', $product->id) }}" class="btn btn-warning w-50 me-2">Edit</a> 
        
            <!-- Delete Button -->
            <form action="{{ route('admin.delete', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="w-50">

                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger w-100">Delete</button>
            </form>
        </div>        
</div>

@endsection