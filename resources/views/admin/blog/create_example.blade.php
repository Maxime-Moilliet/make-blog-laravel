<form action="" method="post">
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

        data: {
            blocks: [
                {
                    type: "header",
                    data: {
                        text: "Editor.js",
                        level: 2
                    }
                },
                {
                    type: 'paragraph',
                    data: {
                        text: 'Hey. Meet the new Editor. On this page you can see it in action — try to edit this text. Source code of the page contains the example of connection and configuration.'
                    }
                },
                {
                    type: "header",
                    data: {
                        text: "Key features",
                        level: 3
                    }
                },
                {
                    type: 'list',
                    data: {
                        items: [
                            'It is a block-styled editor',
                            'It returns clean data output in JSON',
                            'Designed to be extendable and pluggable with a simple API',
                        ],
                        style: 'unordered'
                    }
                },
                {
                    type: "header",
                    data: {
                        text: "What does it mean «block-styled editor»",
                        level: 3
                    }
                },
                {
                    type: 'paragraph',
                    data: {
                        text: `There are dozens of <a href="https://github.com/editor-js">ready-to-use Blocks</a> and the <a href="https://editorjs.io/creating-a-block-tool">simple API</a> for creation any Block you need. For example, you can implement Blocks for Tweets, Instagram posts, surveys and polls, CTA-buttons and even games.`
                    }
                },
                {
                    type: "header",
                    data: {
                        text: "What does it mean clean data output",
                        level: 3
                    }
                },
                {
                    type: 'paragraph',
                    data: {
                        text: 'Classic WYSIWYG-editors produce raw HTML-markup with both content data and content appearance. On the contrary, Editor.js outputs JSON object with data of each Block. You can see an example below'
                    }
                },
                {
                    type: 'paragraph',
                    data: {
                        text: `Given data can be used as you want: render with HTML for <code class="inline-code">Web clients</code>, render natively for <code class="inline-code">mobile apps</code>, create markup for <code class="inline-code">Facebook Instant Articles</code> or <code class="inline-code">Google AMP</code>, generate an <code class="inline-code">audio version</code> and so on.`
                    }
                },
                {
                    type: 'paragraph',
                    data: {
                        text: 'Clean data is useful to sanitize, validate and process on the backend.'
                    }
                },
                {
                    type: 'paragraph',
                    data: {
                        text: 'We have been working on this project more than three years. Several large media projects help us to test and debug the Editor, to make it\'s core more stable. At the same time we significantly improved the API. Now, it can be used to create any plugin for any task. Hope you enjoy. 😏'
                    }
                },
                {
                    type: 'image',
                    data: {
                        url: 'https://cdn.pixabay.com/photo/2017/09/01/21/53/blue-2705642_1280.jpg',
                        caption: 'Image caption example',
                        withBorder: false,
                        withBackground: false,
                        stretched: false
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

