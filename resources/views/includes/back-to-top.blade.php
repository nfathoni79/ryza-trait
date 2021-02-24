<style media="screen">
.back-to-top {
    position: fixed;
    bottom: 25px;
    right: 25px;
    display: none;
    background-color: #fd7e14;
    z-index: 9999;
}
</style>

<a id="back-to-top" href="#" class="btn btn-lg back-to-top" role="button">
    <i class="fas fa-chevron-up"></i>
</a>

<script>
$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });

    // scroll body to 0px on click
    $('#back-to-top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 400);
        return false;
    });
})
</script>
