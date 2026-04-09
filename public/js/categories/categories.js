function showToast(type, message) {
    if (type === 'success') {
        toastr.success(message, 'Success');
    } else {
        toastr.error(message, 'Error');
    }
}

/* ================= ADD CATEGORY ================= */
$('#addCategoryForm').on('submit', function (e) {  // ✅ Changed ID
    e.preventDefault();

    $.ajax({
        url: baseUrl + 'categories/save',  // ✅ Changed URL
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',

        success: function (response) {
            if (response.status === 'success') {
                $('#AddNewModal').modal('hide');
                $('#addCategoryForm')[0].reset();  // ✅ Changed ID

                showToast('success', 'Category added successfully!');  // ✅ Changed message

                setTimeout(() => location.reload(), 1000);
            } else {
                showToast('error', response.message || 'Failed to add category.');  // ✅ Changed
            }
        },

        error: function () {
            showToast('error', 'An error occurred.');
        }
    });
});

/* ================= EDIT BUTTON ================= */
$(document).on('click', '.edit-btn', function () {

    const categoryId = $(this).data('id');  // ✅ Changed

    $.ajax({
        url: baseUrl + 'categories/edit/' + categoryId,  // ✅ Changed URL
        method: 'GET',
        dataType: 'json',

        success: function (response) {
            if (response.data) {

                $('#editCategoryModal #category_name').val(response.data.category_name);  // ✅ Changed field
                $('#editCategoryModal #categoryId').val(response.data.category_id);        // ✅ Changed ID
                $('#editCategoryModal #description').val(response.data.description);       // ✅ New field

                $('#editCategoryModal').modal('show');  // ✅ Changed modal ID

            } else {
                alert('Error fetching category data');  // ✅ Changed
            }
        },

        error: function () {
            alert('Error fetching category data');  // ✅ Changed
        }
    });
});

/* ================= UPDATE CATEGORY ================= */
$('#editCategoryForm').on('submit', function (e) {  // ✅ Changed ID
    e.preventDefault();

    $.ajax({
        url: baseUrl + 'categories/update',  // ✅ Changed URL
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',

        success: function (response) {
            if (response.success) {

                $('#editCategoryModal').modal('hide');  // ✅ Changed ID
                showToast('success', 'Category updated successfully!');  // ✅ Changed

                setTimeout(() => location.reload(), 1000);

            } else {
                alert('Error updating category');  // ✅ Changed
            }
        },

        error: function () {
            alert('Error updating');  // ✅ Changed
        }
    });
});

/* ================= DELETE CATEGORY ================= */
$(document).on('click', '.deleteUserBtn', function () {  // ✅ Same class name as products

    const categoryId = $(this).data('id');  // ✅ Changed

    const csrfName = $('meta[name="csrf-name"]').attr('content');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    if (confirm('Are you sure you want to delete this category?')) {  // ✅ Changed

        $.ajax({
            url: baseUrl + 'categories/delete/' + categoryId,  // ✅ Changed URL
            method: 'POST',

            data: {
                _method: 'DELETE',
                [csrfName]: csrfToken
            },

            success: function (response) {
                if (response.success) {

                    showToast('success', 'Category deleted successfully.');  // ✅ Changed

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
            url: baseUrl + 'categories/fetchRecords',  // ✅ Changed URL
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        },

        columns: [
            { data: 'row_number' },
            { data: 'category_id', visible: false },     // ✅ Changed field name
            { data: 'category_name' },                   // ✅ Changed field name
            { data: 'description' },                     // ✅ New field
            {
                data: null,
                orderable: false,
                searchable: false,

                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-warning edit-btn" data-id="${row.category_id}">  <!-- ✅ Changed ID -->
                            <i class="far fa-edit"></i>
                        </button>

                        <button class="btn btn-sm btn-danger deleteUserBtn" data-id="${row.category_id}">  <!-- ✅ Changed ID -->
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