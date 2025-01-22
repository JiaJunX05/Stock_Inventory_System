<!-- Header -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{route('admin.dashboard')}}"><i class="bi bi-house-door-fill me-2"></i>Inventory System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.create')}}"><i class="bi bi-bag-plus-fill me-2"></i>Add Product</a> 
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <form action="{{route('admin.logout')}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">Sign Out</button>
                  </form>
                </li>
            </ul>
        </div>
    </div>
</nav>