<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $(".permissions").change(function() {
            var role_id = $(this).data('role_id');
            var permission_id = $(this).data('permission');
            var permission_type_id = $(this).data('type');
            var id = $(this).data('id');
            var access_id = $(this).val();
            $.ajax({
                url: "/admin/role/assign", // Ensure 'baseurl' is correctly defined
                type: 'POST',
                data: {
                    
                    role_id: role_id,
                    permission_id: permission_id,
                    permission_type_id: permission_type_id,
                    access_id: access_id,
                    id: id
                },
                success: function(response) {
                    console.log("Success:", response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    console.error('Response:', xhr.responseText);
                    alert('There was an error processing the request. Please try again.');
                }
            });
        });



    });
</script>
