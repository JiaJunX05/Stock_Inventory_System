@extends("admin.layouts.app")

@section("title", "Admin Panel")
@section("content")

<!-- JQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="container text-center mt-5">
    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Welcome Section -->
    <div class="mb-5">
        <h1 class="display-4 text-primary font-weight-bold">Welcome to Admin Panel</h1>
        <p class="lead text-muted">Manage your products here.</p>
    </div>    

    <div class="mb-3">
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search by SKU..." aria-label="Search" id="search-input">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
    
    <!-- Users List Table -->
    <div class="table-responsive" id="table-container">
        <table id="list-table" class="table table-hover table-bordered table-striped">
            <thead class="table-dark" style="position: sticky; top: 0; z-index: 1;">
                <tr>
                    <th scope="col" class="fw-bold">Image</th>
                    <th scope="col" class="fw-bold">Name</th>
                    <th scope="col" class="fw-bold">Description</th>
                    <th scope="col" class="fw-bold">Price</th>
                    <th scope="col" class="fw-bold">Quantity</th>
                    <th scope="col" class="fw-bold">Category</th>
                    <th scope="col" class="fw-bold">Action</th>
                </tr>                
            </thead>            
            <tbody id="table-body"></tbody> <!-- 数据将通过 AJAX 动态填充 -->
        </table>
        <div id="result" class="text-center" style="display: none;">No results found.</div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-2">
        <ul id="pagination" class="pagination"></ul> <!-- 分页将通过 AJAX 动态填充 -->
    </div>
</div>

<script>
    $(document).ready(function() {
        
        loadTable(1); // 默认加载第一页的数据
    
        // 搜索框绑定事件
        $('#search-input').on('input', function() {
            const search = $(this).val();
            loadTable(1, search); // 从第一页加载搜索结果
        });
    
        // 加载表格数据
        function loadTable(page, search = '', length = 10) {
            $.ajax({
                url: "{{ route('admin.search') }}",
                type: 'GET',
                data: { 
                    page: page,     // 传递当前页码
                    search: search, // 传递搜索关键字
                    length: length  // 传递每页显示记录数
                },
                success: function(response) {
                    if (response.data.length === 0 && search !== '') {
                        $('#result').show(); // 显示没有结果的提示
                    } else {
                        $('#result').hide(); // 隐藏没有结果的提示
                    }
                    
                    renderTable(response.data); // 渲染表格数据
                    renderPagination(response.current_page, response.last_page); // 渲染分页
                }
            });
        }
    
        // 渲染表格数据
        function renderTable(data) {
            let tableBody = $('#table-body'); // 获取表格 tbody 元素
            tableBody.empty();                // 清空表格内容
    
            data.forEach(product => {
                tableBody.append(`  
                    <tr>
                        <td><img src="{{ asset('assets/${product.image}') }}" alt="${product.name}" class="img-fluid" style="width: 50px;"></td>
                        <td>${product.name}</td>
                        <td>${product.description}</td>
                        <td>RM ${product.price}</td>
                        <td>${product.quantity} Unit</td>
                        <td>${product.category}</td>
                        <td>
                            <a href="{{ url('admin/view') }}/${product.id}" class="btn btn-primary btn-sm">View More</a>
                        </td>
                    </tr>
                `);
            });
        }
    
        // 渲染分页
        function renderPagination(currentPage, lastPage) {
            let pagination = $('#pagination'); // 获取分页元素
            pagination.empty();                // 清空分页内容
    
            if (currentPage > 1) {
                pagination.append(`  
                    <li class="page-item">
                        <a class="page-link" href="#" data-page="${currentPage - 1}">«</a>
                    </li>
                `);
            }
    
            for (let i = 1; i <= lastPage; i++) {
                pagination.append(` 
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
            }
    
            if (currentPage < lastPage) {
                pagination.append(`
                    <li class="page-item">
                        <a class="page-link" href="#" data-page="${currentPage + 1}">»</a>
                    </li>
                `);
            }
    
            // 分页点击事件
            $('.page-link').on('click', function(e) {
                e.preventDefault();                // 阻止默认跳转行为
                const page = $(this).data('page'); // 获取当前页码
                loadTable(page);                   // 加载指定页码数据
            });
        }
    });
</script>

@endsection