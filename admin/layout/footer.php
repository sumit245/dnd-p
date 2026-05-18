    </main>
    <script>
        // Initialize TinyMCE for any textarea with class 'richtext'
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: 'textarea.richtext',
                height: 500,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
                // C-01 fix: restrict headings to H2/H3/H4 only.
                // H1 is reserved for the page title. H5/H6 removed to prevent broken hierarchy.
                block_formats: 'Paragraph=p; Heading 2=h2; Heading 3=h3; Heading 4=h4; Blockquote=blockquote; Code=code',
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; font-size: 16px; } h2 { font-size: 1.6em; margin-top: 1.5em; } h3 { font-size: 1.25em; margin-top: 1.2em; }'
            });
        }
    </script>
</body>
</html>
