<!-- resources/views/admin/categories/create.blade.php -->
@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
    <h1>Create New Category</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Category Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="manufacturer">Manufacturer:</label>
            <input type="text" name="manufacturer" id="manufacturer" class="form-control" value="{{ old('manufacturer') }}">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Create</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mt-3">Back</a>
    </form>
@endsection
