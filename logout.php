<script type="application/javascript">
    $.ajax({
        type: "GET",
        url: "php/removeUserLocalData.php",
    })

    $(document).ajaxStop(function() {
        window.location.reload();
    });
</script>