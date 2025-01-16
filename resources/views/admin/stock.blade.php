@extends("admin.layouts.app")

@section("title", "Stock Product")
@section("content")

<!-- JQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="container mt-4">
    <div class="mb-4">
        <h1 class="text-primary">Stock Product</h1>
        <p class="text-muted">Use this tool to adjust product stock levels and manage inventory seamlessly. <br>
            Accurate stock management helps improve customer satisfaction and avoid unnecessary shortages.
        </p><hr>
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
                <label for="name" class="form-label">Product Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" readonly>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Product Quantity:</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="quantity" name="quantity" min="1" value="{{ $product->quantity }} Units" readonly>
                </div>
            </div>

            <div class="mb-4">
                <h1 class="text-primary">Stock In & Out</h1>
                <p class="text-muted">Use this tool to adjust product stock levels and manage inventory seamlessly.</p><hr>
            </div>

            <form action="{{ route('admin.stockUpdate', $product->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="stock_quantity" class="form-label">Product Quantity:</label>
                    <div class="input-group">
                        @if ($product->quantity == 0)
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="1" 
                                placeholder="Enter Your Stock Quantity" required>
                        @else
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="1" 
                                max="{{ request('status') === 'stock_out' ? $product->quantity : '' }}" placeholder="Enter Your Stock Quantity" required>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label for="stock_status" class="form-label">Stock Status:</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input type="radio" name="status" id="stock_in" value="stock_in" required>
                                </div>
                                <label for="stock_in" class="form-control">Stock In</label>
                            </div>
                        </div>
                
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-text">
                                    @if ($product->quantity == 0)
                                        <input type="radio" name="status" id="stock_out" value="stock_out" disabled>
                                    @else
                                        <input type="radio" name="status" id="stock_out" value="stock_out" required>
                                    @endif
                                </div>
                                <label for="stock_out" class="form-control">Stock Out</label>
                            </div>
                        </div>
                    </div>
                </div>                
                
                <button type="submit" class="btn btn-success w-100">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection