document.querySelectorAll('input[type="file"]').forEach(function(input) {
    input.addEventListener('change', function(event) {
        let imageInput = event.target;
        let preview = imageInput.nextElementSibling;

        if (imageInput.files && imageInput.files[0]) {
            const maxSize = 10 * 1024 * 1024; // 10 MB in bytes
            if (imageInput.files[0].size > maxSize) {
                showErrorMessage('File size exceeds 10 MB. Please select a smaller file.');
                return;
            }

            let reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(imageInput.files[0]);
        }
    });
});

