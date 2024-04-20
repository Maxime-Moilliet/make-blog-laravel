@extends('admin.blog.layout')

@section('content')
    <div class="d-flex justify-content-between align-items-start py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.blog.index') }}">Posts</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Post</li>
            </ol>
        </nav>
        <div>
            <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <form action="{{ route('admin.blog.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title fs-4 m-0">Post Form</h1>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="content">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control"/>
                            @error('title')
                            <span class="text-danger d-block mt-1" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="archived">Archived</option>
                            </select>
                            @error('status')
                            <span class="text-danger d-block mt-1" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary w-100">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="border rounded-2">
                    <div id="editorjs"></div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/simple-image@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/checklist@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/code@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/table@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/link@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/marker@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/inline-code@latest"></script>

    <script>
        const editor = new EditorJS({

            holderId: 'editorjs',

            tools: {
                header: {
                    class: Header,
                    inlineToolbar: ['link'],
                    config: {
                        placeholder: 'Header'
                    },
                    shortcut: 'CMD+SHIFT+H'
                },
                image: {
                    class: SimpleImage,
                    inlineToolbar: true,
                    config: {
                        placeholder: 'Paste image URL'
                    },
                    shortcut: 'CMD+SHIFT+H'
                },
                list: {
                    class: List,
                    inlineToolbar: true,
                    shortcut: 'CMD+SHIFT+L'
                },
                checklist: {
                    class: Checklist,
                    inlineToolbar: true,
                },
                marker: {
                    class: Marker,
                    shortcut: 'CMD+SHIFT+M'
                },
                code: {
                    class: CodeTool,
                    shortcut: 'CMD+SHIFT+C'
                },
                inlineCode: {
                    class: InlineCode,
                    shortcut: 'CMD+SHIFT+C'
                },
                linkTool: LinkTool,
                embed: Embed,
                table: {
                    class: Table,
                    inlineToolbar: true,
                    shortcut: 'CMD+ALT+T'
                },
            },
            data: {
                blocks: [
                    {
                        type: "header",
                        data: {
                            text: "Title",
                            level: 1
                        }
                    },
                    {
                        type: 'paragraph',
                        data: {
                            text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
                        }
                    },
                ]
            },
            onChange: function () {
                console.log('something changed');
                editor.save().then((outputData) => {
                    document.querySelector('input[name=content]').value = JSON.stringify(outputData['blocks'])
                }).catch((error) => {
                    console.log('Saving failed: ', error)
                });
            }
        });
    </script>
@endpush
