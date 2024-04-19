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

    <ul class="nav nav-pills pb-2" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="draft-tab" data-bs-toggle="tab" data-bs-target="#draft-tab-pane"
                    type="button" role="tab" aria-controls="draft-tab-pane" aria-selected="true">Draft
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="published-tab" data-bs-toggle="tab" data-bs-target="#published-tab-pane"
                    type="button" role="tab" aria-controls="published-tab-pane" aria-selected="false">Published
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="archived-tab" data-bs-toggle="tab" data-bs-target="#archived-tab-pane"
                    type="button" role="tab" aria-controls="archived-tab-pane" aria-selected="false">Archived
            </button>
        </li>
    </ul>
    @foreach($posts_draft as $post_draft)
        @include('admin.blog._modal-delete', ['post' => $post_draft])
    @endforeach
    @foreach($posts_published as $post_published)
        @include('admin.blog._modal-delete', ['post' => $post_published])
    @endforeach
    @foreach($posts_archived as $post_archived)
        @include('admin.blog._modal-delete', ['post' => $post_archived])
    @endforeach
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="draft-tab-pane" role="tabpanel" aria-labelledby="draft-tab"
             tabindex="0">
            <section class="card">
                <div class="card-body">
                    <table id="draftTable" class="display w-100">
                        <thead>
                        <tr>
                            <th>Action</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>CreatedAt</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts_draft as $post_draft)
                            <tr>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('blog.show', $post_draft->slug) }}"
                                           class="btn btn-sm btn-primary">
                                            Show
                                        </a>
                                        <a href="{{ route('admin.blog.edit', $post_draft) }}"
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete-post-{{ $post_draft->id }}">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                                <td>{{ $post_draft->title }}</td>
                                <td>{{ $post_draft->slug }}</td>
                                <td>{{ $post_draft->created_at->format('d/m/Y à h:i') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="published-tab-pane" role="tabpanel" aria-labelledby="published-tab" tabindex="0">
            <section class="card">
                <div class="card-body">
                    <table id="publishedTable" class="display w-100">
                        <thead>
                        <tr>
                            <th>Action</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>CreatedAt</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts_published as $post_published)
                            <tr>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('blog.show', $post_published->slug) }}"
                                           class="btn btn-sm btn-primary">
                                            Show
                                        </a>
                                        <a href="{{ route('admin.blog.edit', $post_published) }}"
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete-post-{{ $post_published->id }}">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                                <td>{{ $post_published->title }}</td>
                                <td>{{ $post_published->slug }}</td>
                                <td>{{ $post_published->created_at->format('d/m/Y à h:i') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="archived-tab-pane" role="tabpanel" aria-labelledby="archived-tab" tabindex="0">
            <section class="card">
                <div class="card-body">
                    <table id="archivedTable" class="display w-100">
                        <thead>
                        <tr>
                            <th>Action</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>CreatedAt</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts_archived as $post_archived)
                            <tr>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('blog.show', $post_archived->slug) }}"
                                           class="btn btn-sm btn-primary">
                                            Show
                                        </a>
                                        <a href="{{ route('admin.blog.edit', $post_archived) }}"
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete-post-{{ $post_archived->id }}">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                                <td>{{ $post_archived->title }}</td>
                                <td>{{ $post_archived->slug }}</td>
                                <td>{{ $post_archived->created_at->format('d/m/Y à h:i') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script>
        new DataTable('#draftTable');
        new DataTable('#publishedTable');
        new DataTable('#archivedTable');
    </script>
@endpush
