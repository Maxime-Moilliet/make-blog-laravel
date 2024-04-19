<form action="{{ route('admin.blog.store') }}" method="post">
    @csrf
    <input type="hidden" name="content">
    <div>
        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}"/>
        @error('title')
        <span role="alert">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="slug">Slug</label>
        <input type="text" id="slug" name="slug" value="{{ old('slug') }}"/>
        @error('slug')
        <span role="alert">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="status">Status</label>
        <select name="status" id="status">
            <option value="draft">Draft</option>
            <option value="published">Published</option>
            <option value="archived">Archived</option>
        </select>
        @error('status')
        <span role="alert">{{ $message }}</span>
        @enderror
    </div>
    <div id="editorjs"></div>
    <div>
        <button type="submit">Save</button>
    </div>
</form>

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

