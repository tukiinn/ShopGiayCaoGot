@extends('layouts.admin')

@section('title', 'Danh Sách Danh Mục')

@section('content')
    <h1>Danh Sách Danh Mục</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên Danh Mục</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>
                        <!-- Xem Danh Mục -->
                        <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-info">Xem</a>
                        
                        <!-- Hành động chỉ dành cho Admin -->
                        @auth
                            @if (auth()->user()->role === 'admin')
                                <!-- Chỉnh Sửa Danh Mục -->
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">Chỉnh Sửa</a>
                                
                                <!-- Xóa Danh Mục -->
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?');">Xóa</button>
                                </form>  
                            @endif
                        @endauth
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
