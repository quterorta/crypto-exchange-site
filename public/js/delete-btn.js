$(document).ready(function () {
    $(".delete-btn").click(function() {
        let title = $(this).data("title")
        var res = confirm('Are you sure you want to delete the "' + title + '"? This will also remove child entries!');
        if (!res) {
            return false;
        }
    });
});
