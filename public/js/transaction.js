$(document).ready(function() {
    $('#service-type').change(function() {
        var serviceTypeId = $(this).val();
        $.ajax({
            url: '/admin/transactions/session/store-service-type', // Create this route
            method: 'POST',
            data: {
                service_type_id: serviceTypeId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Handle success if needed
            }
        });
    });
});