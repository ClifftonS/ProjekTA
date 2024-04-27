<div class="modal fade" id="Deletekategori" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-confirm">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title w-100 text-center">Are you sure?</h4>
                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <input type="hidden" name="idDelete" id="idDelete">
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary"aria-label="Close"
                    data-bs-dismiss="modal">Cancel</button>
                <button type="submit" id="deletekategori" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#Deletekategori').on('show.bs.modal', function(e) {
        var idkategori = $(e.relatedTarget).data('id').idkategori;
        $(e.currentTarget).find('input[id="idDelete"]').val(idkategori);
    });
    $('#deletekategori').click(function(e) {
        e.preventDefault();

        let id = $('#idDelete').val();
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: "POST",
            url: "/deletekategori",
            data: {
                "id": id,
                "_token": token
            },
            success: function(response) {
                search(1);
                $('#Deletekategori').modal('hide');
                Swal.fire({
                    title: "Success",
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
    });
</script>
