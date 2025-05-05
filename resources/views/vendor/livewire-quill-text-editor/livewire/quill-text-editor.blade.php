<div wire:ignore>
    <div id="{{ $quillId }}"></div>
</div>

@script
<script>
    const quill = new Quill('#' + @js($quillId), {
        modules: {
            toolbar: [
                [{ header: [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                ['image', 'code-block'],
                [{ 'color': [] },{ 'background': [] }],
            ],
            // toolbar: '#toolbar',
        },
        theme: @js($theme)
    });

    quill.root.innerHTML = $wire.get('value');

    quill.on('text-change', function () {
        let value = quill.root.innerHTML;
        @this.set('value', value);
    });
</script>
@endscript
