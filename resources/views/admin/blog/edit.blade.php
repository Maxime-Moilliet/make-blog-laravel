@extends('admin.blog.layout')

@section('content')
    <div class="d-flex justify-content-between align-items-start py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.blog.index') }}">Posts</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Post</li>
            </ol>
        </nav>
        <div>
            <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div>
        <div class="row">
            <div class="col-md-4">
                <form action="{{ route('admin.blog.destroyImage', $post) }}" method="post" class="card mb-3 p-0">
                    @csrf
                    @method('delete')
                    <div class="card-body d-flex align-items-center">
                        <button type="submit" class="btn btn-sm btn-danger">Delete image</button>
                    </div>
                </form>
                <form action="{{ route('admin.blog.update', $post) }}" method="post" enctype="multipart/form-data"
                      class="card">
                    @csrf
                    @method('put')
                    <div class="card-header">
                        <h1 class="card-title fs-4 m-0">Post Form</h1>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="content"
                               value="{{ json_encode($post->content)}}">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}"
                                   class="form-control"/>
                            @error('title')
                            <span class="text-danger d-block mt-1" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-end justify-content-between">
                                <div class="w-100">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" id="slug" name="slug" value="{{ old('slug', $post->slug) }}"
                                           class="form-control w-100"/>
                                    @error('slug')
                                    <span class="text-danger d-block mt-1" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="button" class="btn btn-primary ms-2" id="slug-generator">Generate
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            @if($post->main_image)
                                <div class="d-flex align-items-end gap-2 mb-2">
                                    <img src="{{ $post->getMainImageFromDisk() }}" alt="" width="100" height="100"
                                         class="rounded">
                                </div>
                            @endif
                            <label for="main_image" class="form-label">Image</label>
                            <input type="file" name="main_image" id="main_image" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="draft" @selected($post->status->name === "DRAFT")>Draft</option>
                                <option value="published" @selected($post->status->name === "PUBLISHED")>Published
                                </option>
                                <option value="archived" @selected($post->status->name === "ARCHIVED")>Archived
                                </option>
                            </select>
                            @error('status')
                            <span class="text-danger d-block mt-1" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <div class="mb-2">
                                <h1 class="card-title fs-4 m-0">Post Seo Form</h1>
                            </div>
                            <div>
                                <div class="mb-3">
                                    <label for="seo_title" class="form-label">Title</label>
                                    <input type="text" id="seo_title" name="seo_title" value="{{ old('seo_title', $post->seo->title) }}"
                                           class="form-control"/>
                                    @error('seo_title')
                                    <span class="text-danger d-block mt-1" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="seo_description" class="form-label">Description</label>
                                    <textarea type="text" id="seo_description" name="seo_description"
                                              class="form-control">{{ old('seo_description', $post->seo->description) }}</textarea>
                                    @error('seo_description')
                                    <span class="text-danger d-block mt-1" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="seo_keywords" class="form-label">Keywords</label>
                                    <input type="text" id="seo_keywords" name="seo_keywords"
                                           value="{{ old('seo_keywords', $post->seo->keywords) }}"
                                           class="form-control"/>
                                    @error('seo_keywords')
                                    <span class="text-danger d-block mt-1" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="seo_canonical" class="form-label">Canonical</label>
                                    <input type="text" id="seo_canonical" name="seo_canonical"
                                           value="{{ old('seo_canonical', $post->seo->canonical) }}"
                                           class="form-control"/>
                                    @error('seo_canonical')
                                    <span class="text-danger d-block mt-1" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary w-100">Save</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-8">
                <div class="border rounded-2">
                    <div id="editorjs"></div>
                </div>
            </div>
        </div>
    </div>
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
                blocks: @js($post->content ?? [])
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
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
    <script>
        const inputTitle = document.getElementById('title');
        const slugButton = document.getElementById('slug-generator');

        slugButton.addEventListener('click', function () {
            const title = inputTitle.value;
            const slug = _.kebabCase(title);
            document.getElementById('slug').value = slug;
        });
    </script>
@endpush
