@extends('admin.blog.layout')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css"/>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-start py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Posts</li>
            </ol>
        </nav>
        <div>
            <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">Create Post</a>
        </div>
    </div>

    <section class="card">
        <div class="card-header">
            <h2 class="card-title">Posts</h2>
        </div>
        <div class="card-body">
            <table id="myTable" class="display">
                <thead>
                <tr>
                    <th>Action</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>CreatedAt</th>
                </tr>
                </thead>
                <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>
                            <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-sm btn-primary">
                                Show
                            </a>
                        </td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->slug }}</td>
                        <td>{{ $post->status[0] }}</td>
                        <td>{{ $post->created_at->format('d/m/Y à h:i') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>
@endpush
