<?php if(session()->getFlashdata('success')): ?>
<div class="alert alert-success" id="toastMsg">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<?= $this->extend('theme/template') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">

  <div class="content-header">
    <div class="container-fluid">
      <h1 class="m-0">Tables Management</h1>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      <div class="card">

        <!-- HEADER -->
        <div class="card-header d-flex justify-content-between align-items-center">

          <input type="text" id="searchInput" class="form-control w-25" placeholder="Search table...">

          <button class="btn btn-primary" data-toggle="modal" data-target="#addTableModal">
            + Add Table
          </button>

        </div>

        <!-- TABLE -->
        <div class="card-body">

          <table class="table table-bordered table-hover table-sm" id="tablesTable">

            <thead class="thead-dark">
              <tr>
                <th>#</th>
                <th>Table Number</th>
                <th>Status</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Actions</th>
              </tr>
            </thead>

            <tbody>

              <?php if(!empty($tables)): ?>
                <?php $i = 1; foreach($tables as $row): ?>
                <tr>
                  <td><?= $i++ ?></td>
                  <td><strong><?= $row['table_number'] ?></strong></td>

                  <td>
                    <?php if($row['status'] == 'occupied'): ?>
                      <span class="badge badge-success">Occupied</span>
                    <?php elseif($row['status'] == 'reserved'): ?>
                      <span class="badge badge-warning">Reserved</span>
                    <?php else: ?>
                      <span class="badge badge-secondary">Available</span>
                    <?php endif; ?>
                  </td>

                  <td>
                    <?= !empty($row['start_time']) ? date('h:i A', strtotime($row['start_time'])) : '--' ?>
                  </td>

                  <td>
                    <?= !empty($row['end_time']) ? date('h:i A', strtotime($row['end_time'])) : '--' ?>
                  </td>

                  <td>

                    <!-- START -->
                    <?php if($row['status'] == 'available'): ?>
                      <a href="<?= base_url('tables/start/' . $row['table_id']) ?>" class="btn btn-success btn-sm">
                        Start
                      </a>

                    <!-- END -->
                    <?php elseif($row['status'] == 'occupied'): ?>
                      <a href="<?= base_url('tables/end/' . $row['table_id']) ?>" class="btn btn-danger btn-sm">
                        End
                      </a>

                    <!-- RESERVED -->
                    <?php elseif($row['status'] == 'reserved'): ?>
                      <a href="<?= base_url('tables/start/' . $row['table_id']) ?>" class="btn btn-warning btn-sm">
                        Start
                      </a>

                    <?php else: ?>
                      <span class="text-muted">No Action</span>
                    <?php endif; ?>

                  </td>

                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center">NO TABLES FOUND</td>
                </tr>
              <?php endif; ?>

            </tbody>

          </table>

        </div>
      </div>

    </div>
  </section>
</div>

<!-- ================= ADD TABLE MODAL ================= -->
<div class="modal fade" id="addTableModal">
  <div class="modal-dialog">

    <form action="<?= base_url('tables/save') ?>" method="post">
      <?= csrf_field() ?>

      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Add Table</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

          <div class="form-group">
            <label>Table Number</label>
            <input type="text" name="table_number" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Hourly Rate</label>
            <input type="number" name="hourly_rate" class="form-control" value="80" required>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>

      </div>

    </form>

  </div>
</div>

<!-- ================= SEARCH SCRIPT ================= -->
<script>
document.getElementById('searchInput').addEventListener('keyup', function () {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll("#tablesTable tbody tr");

    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});

// toast auto hide
setTimeout(() => {
    let el = document.getElementById('toastMsg');
    if (el) el.remove();
}, 2000);
</script>

<?= $this->endSection() ?>