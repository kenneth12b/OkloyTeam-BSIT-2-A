function showToast(type, message) {
    if (type === 'success') {
        toastr.success(message, 'Success');
    } else {
        toastr.error(message, 'Error');
    }
}

// ===============================
// 🔥 CSRF SETUP (SAFE VERSION)
// ===============================
let csrfName = $('meta[name="csrf-name"]').attr('content');
let csrfToken = $('meta[name="csrf-token"]').attr('content');

// ===============================
// ➕ ADD TABLE (FIXED + SAFE)
// ===============================
$(document).on('submit', '#addTableForm', function (e) {
    e.preventDefault();

    $.ajax({
        url: baseUrl + 'tables/save',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (res) {
            console.log(res);

            if (res.success) {
                alert('SUCCESS ADD');
                location.reload();
            } else {
                alert(res.message);
            }
        },
        error: function (xhr) {
            console.log(xhr.responseText);
            alert('ERROR AJAX');
        }
    });
});
// ===============================
// ▶ START GAME
// ===============================
$(document).on('click', '.startBtn', function () {
    let id = $(this).data('id');

    $.ajax({
        url: baseUrl + 'tables/start/' + id,
        method: 'POST',
        dataType: 'json',

        success: function (res) {
            if (res.success) {
                showToast('success', 'Game started');
                setTimeout(() => location.reload(), 600);
            } else {
                showToast('error', res.message || 'Failed to start');
            }
        },

        error: function (xhr) {
            console.log(xhr.responseText);
            showToast('error', 'Error starting game');
        }
    });
});

// ===============================
// ⏹ END GAME
// ===============================
$(document).on('click', '.endBtn', function () {
    let id = $(this).data('id');

    if (!confirm('End this game?')) return;

    $.ajax({
        url: baseUrl + 'tables/end/' + id,
        method: 'POST',
        dataType: 'json',

        success: function (res) {
            if (res.success) {
                showToast('success', 'Total: ₱' + res.total);
                setTimeout(() => location.reload(), 800);
            } else {
                showToast('error', res.message || 'Failed to end game');
            }
        },

        error: function (xhr) {
            console.log(xhr.responseText);
            showToast('error', 'Error ending game');
        }
    });
});

// ===============================
// ⭐ RESERVE TABLE
// ===============================
$(document).on('click', '.reserveBtn', function () {
    let id = $(this).data('id');

    $.ajax({
        url: baseUrl + 'tables/reserve/' + id,
        method: 'POST',
        dataType: 'json',

        success: function (res) {
            if (res.success) {
                showToast('success', 'Table reserved');
                setTimeout(() => location.reload(), 600);
            }
        },

        error: function () {
            showToast('error', 'Error reserving table');
        }
    });
});

// ===============================
// 🔄 RESET TABLE
// ===============================
$(document).on('click', '.resetBtn', function () {
    let id = $(this).data('id');

    if (!confirm('Reset table?')) return;

    $.ajax({
        url: baseUrl + 'tables/reset/' + id,
        method: 'POST',
        dataType: 'json',

        success: function (res) {
            if (res.success) {
                showToast('success', 'Table reset');
                setTimeout(() => location.reload(), 600);
            }
        },
        

        error: function () {
            showToast('error', 'Error resetting table');
        }
        
    });
});
<script>
console.log("JS OK");
</script>