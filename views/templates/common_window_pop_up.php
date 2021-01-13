<style>
    .open_page{
        display: none;
        position: absolute;
        z-index: 1000;
        margin: 0% 0%;
        width: 100%;
        background: rgba(128, 128, 128, 0.48);
        height: 1000px;
    }
    .open_page #open_page_frame{

        width: 80%;
        margin: 0px 10%;
        height: 500px;
        box-shadow: 0 0 5px;
        padding: 5px;

    }
    .open_page #close_open_page_frame{
        position: relative;
        top: 20px;
        right: 9%;
        float: right;
    }
</style> 
<div class="open_page">
    <button type="button" id="close_open_page_frame" class="btn btn-danger btn-md">
        <span class="glyphicon glyphicon-remove"></span> 
    </button>
    <iframe id="open_page_frame" class="frame_two_frme" src=""></iframe>  
</div>
<script>
    $("#close_open_page_frame").click(function() {
        $(".open_page").hide(1000);
    });

    function open_page(page_url)
        {
        $("html, body").animate({scrollTop: 0}, 1000);
        var page = page_url;
        //alert(page);
        $('#open_page_frame').attr('src', page);
        $('#open_page_frame').parent().show(1000);
    }
</script>