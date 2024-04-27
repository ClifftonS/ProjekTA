<div class="modal fade" id="Deletemerk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <button type="submit" id="deletemerk" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#Deletemerk').on('show.bs.modal', function(e) {
        var idmerk = $(e.relatedTarget).data('id').idmerk;
        $(e.currentTarget).find('input[id="idDelete"]').val(idmerk);
    });
    $('#deletemerk').click(function(e) {
        e.preventDefault();

        let id = $('#idDelete').val();
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: "POST",
            url: "/deletemerk",
            data: {
                "id": id,
                "_token": token
            },
            success: function(response) {
                search(1);
                $('#Deletemerk').modal('hide');
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
