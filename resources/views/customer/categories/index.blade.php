<!-- resources/views/categories/index.blade.php -->
@extends('layouts.customer')

@section('title', 'Danh sách danh mục')

@section('content')
<title>Danh mục</title>
<div class="category-list-container">
    <h1 class="mb-4">Danh sách danh mục</h1>

    <table class="table table-hover table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Tên danh mục</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td class="text-center">
                        <!-- Nút Xem danh mục -->
                        <a href="{{ route('customer.categories.show', $category->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i> Xem
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    .category-list-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }
    .btn {
        padding: 5px 10px;
        font-size: 0.875rem;
    }
    h1 {
        font-size: 2rem;
        font-weight: bold;
        color: #333;
    }
</style>
@endsection
