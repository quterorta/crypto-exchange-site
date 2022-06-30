$(document).ready(function () {
    let titleInput = $('#title');
    titleInput.on('input', function () {
        let slugInput = $('#slug');
        slugInput.val(slugify(titleInput.val()));
    });
});

$(document).ready(function () {
    let titleInput = $('#product_title');
    titleInput.on('input', function () {
        let slugInput = $('#slug');
        slugInput.val(slugify(titleInput.val()));
    });
});

function slugify(string) {
    return string
        .toString()
        .trim()
        .toLowerCase()
        .replace(/\s+/g, "-")
        .replace(/[^\w\-]+/g, "")
        .replace(/\-\-+/g, "-")
        .replace(/^-+/, "")
        .replace(/-+$/, "");
}
