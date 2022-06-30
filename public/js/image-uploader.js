$(document).ready(function () {
    let maxFileSize = 2 * 2048 * 2048; // (байт) Максимальный размер файла (2мб)
    let queue = {};
    let form = $('form#slider_create');
    let imagesList = $('#uploadImagesList');

    let itemPreviewTemplate = imagesList.find('.item.template').clone();
    itemPreviewTemplate.removeClass('template');
    imagesList.find('.item.template').remove();
    $('#images').on('change', function () {
        let files = this.files;
        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            if ( !file.type.match(/image\/(jpeg|jpg|png|gif)/) ) {
                alert( 'Image should be in jpg, png or gif format!' );
                continue;
            }
            if ( file.size > maxFileSize ) {
                alert( 'Image size must not exceed 4 Мб' );
                continue;
            }
            preview(files[i]);
        }
        this.value = files;
    });

    // Создание превью
    function preview(file) {
        let reader = new FileReader();
        reader.addEventListener('load', function(event) {
            let img = document.createElement('img');
            let itemPreview = itemPreviewTemplate.clone();
            itemPreview.find('.img-wrap img').attr('src', event.target.result);
            itemPreview.data('id', file.name);
            imagesList.append(itemPreview);
            queue[file.name] = file;
        });
        reader.readAsDataURL(file);
    }

    // Удаление фотографий
    imagesList.on('click', '.delete-link', function () {
        let item = $(this).closest('.item'),
            id = item.data('id');
        delete queue[id];
        item.remove();
    });

    $('.admin-change-image').on('change', function() {
        let imageForChange = $(this).data('slider-image-id');
        let oldImage = $('#'+imageForChange+'');
        if (this.files && this.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                oldImage.attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    $('.admin-item-image-input').on('change', function() {
        let imagePreview = $('#admin-item-image-preview');
        if (this.files && this.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.attr('src', e.target.result);
                imagePreview.css('display', 'block');
                imagePreview.css('width', '5rem');
                imagePreview.css('margin-bottom', '1rem');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
});
