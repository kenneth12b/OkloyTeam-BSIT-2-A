function showToast(type, message) {
    if (type === 'success') {
        toastr.success(message, 'Success');
    } else {
        toastr.error(message, 'Error');
    }
}

/* ================= ADD PRODUCT ================= */
$('#addProductForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: baseUrl + 'product/save',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',

        success: function (response) {
            if (response.status === 'success') {
                $('#AddNewModal').modal('hide');
                $('#addProductForm')[0].reset();

                showToast('success', 'Product added successfully!');

                setTimeout(() => location.reload(), 1000);
            } else {
                showToast('error', response.message || 'Failed to add product.');
            }
        },

        error: function () {
            showToast('error', 'An error occurred.');
        }
    });
});


/* ================= EDIT BUTTON ================= */
$(document).on('click', '.edit-btn', function () {

    const productId = $(this).data('id');

    $.ajax({
        url: baseUrl + 'product/edit/' + productId,
        method: 'GET',
        dataType: 'json',

        success: function (response) {
            if (response.data) {

                $('#editProductModal #product_name').val(response.data.product_name);
                $('#editProductModal #productId').val(response.data.product_id);
                $('#editProductModal #quantity').val(response.data.quantity);
                $('#editProductModal #price').val(response.data.price);

                $('#editProductModal').modal('show');

            } else {
                alert('Error fetching product data');
            }
        },

        error: function () {
            alert('Error fetching product data');
        }
    });

});


/* ================= UPDATE PRODUCT ================= */
$('#editProductForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: baseUrl + 'product/update',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',

        success: function (response) {
            if (response.success) {

                $('#editProductModal').modal('hide');
                showToast('success', 'Product updated successfully!');

                setTimeout(() => location.reload(), 1000);

            } else {
                alert('Error updating product');
            }
        },

        error: function () {
            alert('Error updating');
        }
    });
});


/* ================= DELETE PRODUCT ================= */
$(document).on('click', '.deleteUserBtn', function () {

    const productId = $(this).data('id');

    const csrfName = $('meta[name="csrf-name"]').attr('content');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    if (confirm('Are you sure you want to delete this product?')) {

        $.ajax({
            url: baseUrl + 'product/delete/' + productId,
            method: 'POST',

            data: {
                _method: 'DELETE',
                [csrfName]: csrfToken
            },

            success: function (response) {
                if (response.success) {

                    showToast('success', 'Product deleted successfully.');

                    setTimeout(() => location.reload(), 1000);

                } else {
                    alert(response.message || 'Failed to delete.');
                }
            },

            error: function () {
                alert('Something went wrong while deleting.');
            }
        });
    }
});


/* ================= DATATABLE ================= */
$(document).ready(function () {

    const $table = $('#example1');

    const csrfName = 'csrf_test_name';
    const csrfToken = $('input[name="' + csrfName + '"]').val();

    $table.DataTable({
        processing: true,
        serverSide: true,

        ajax: {
            url: baseUrl + 'product/fetchRecords',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        },

        columns: [
            { data: 'row_number' },
            { data: 'product_id', visible: false },
            { data: 'product_name' },
            { data: 'quantity' },
            { data: 'price' },
            {
                data: null,
                orderable: false,
                searchable: false,

                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-warning edit-btn" data-id="${row.product_id}">
                            <i class="far fa-edit"></i>
                        </button>

                        <button class="btn btn-sm btn-danger deleteUserBtn" data-id="${row.product_id}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    `;
                }
            }
        ],

        responsive: true,
        autoWidth: false
    });

});