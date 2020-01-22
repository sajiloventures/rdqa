<!-- Body Bottom modal dialog-->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
<script type="text/javascript">

    function confirmDelete(url) {

        $('#myModal').modal();
        $.get(url, function(data){
            $('#myModal').find('.modal-content').html(data);
        })

    }

</script>