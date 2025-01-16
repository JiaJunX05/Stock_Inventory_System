@extends("admin.layouts.app")

@section("title", "Create Product")
@section("content")

<!-- JQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="container mt-4">
    <div class="text-center">
        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Error Alert -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="mb-4">
        <h1 class="text-primary">Create Product</h1>
        <p class="text-muted">Add a new product to the inventory system.</p><hr>
    </div>

    <form action="{{ route('admin.create.submit') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-3 mt-3 mb-3 text-center">
                <div class="card text-center border-0">
                    <div class="card-body">
                        <img src="https://cdn-icons-png.freepik.com/256/5968/5968253.png?ga=GA1.1.1815414687.1712627600&semt=ais_hybrid" 
                            alt="Preview" class="image img-fluid w-50 object-fit-contain" id="preview-image">
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
                        <input type="file" class="form-control" id="image" name="image" required>
                        <label class="input-group-text" for="image">Upload</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Product Name:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Product Name" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Product Description:</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Enter Your Product Description" rows="3"></textarea>
                </div>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Product Price:</label>
                <input type="text" class="form-control" id="price" name="price" placeholder="Enter Your Product Price" required>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Product Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" min="1" placeholder="Enter Your Product Quantity" required>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Product Category:</label>
                <input type="text" class="form-control" id="category" name="category" placeholder="Enter Your Product Category" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3 mb-3">Submit</button>
        </div>
    </form>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/create.js') }}"></script>
@endsection