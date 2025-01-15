<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function getAssignedData(role_id) {
        $.ajax({
            url: "/admin/role/getAssignedDataByRole", // Ensure 'baseurl' is correctly defined
            type: 'POST',
            dataType: 'json',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                role_id: role_id,
            },
            success: function(response) {
                $.each(response, function(key, val) {
                    $('select[data-type="' + val.permission_type_id + '"][data-permission="' + val
                        .permission_id + '"]').val(val.access_id).attr('data-id', val.id);

                });
            },

        });
    }
    $(document).ready(function() {

        getAssignedData({{ $roleData['id'] }})


        $(".permissions").change(function() {
            var role_id = $(this).data('role_id');
            var permission_id = $(this).data('permission');
            var permission_type_id = $(this).data('type');
            var id = $(this).data('id');
            var access_id = $(this).val();

            // Show loading spinner
            $("body").append('<div class="loading-overlay">Loading...</div>');

            $.ajax({
                url: "/admin/role/assign",
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    role_id: role_id,
                    permission_id: permission_id,
                    permission_type_id: permission_type_id,
                    access_id: access_id,
                    id: id
                },

                error: function(error) {
                    $(".loading-overlay").remove();
                    $("body").append(
                        '<div class="loading-overlay">An Error has occured! Please Reload.</div>'
                    );

                },
                success: function(response) {
                    getAssignedData({{ $roleData['id'] }})

                    // $('select[data-type="' + permission_type_id +
                    //     '"][data-permission="' + permission_id + '"]').attr('data-id',
                    //     response);


                    $(".loading-overlay").remove();
                }
            });
        });





    });
</script>
