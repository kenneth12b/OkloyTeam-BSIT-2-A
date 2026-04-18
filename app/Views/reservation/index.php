<?= $this->extend('theme/template') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">

  <div class="content-header">
    <div class="container-fluid">
      <h1 class="m-0">Reservations Management</h1>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      <div class="card">

        <!-- HEADER -->
        <div class="card-header d-flex justify-content-between align-items-center">

          <input type="text" id="searchInput" class="form-control w-25" placeholder="Search reservation...">

          <button class="btn btn-primary" data-toggle="modal" data-target="#addReservationModal">
            + Add Reservation
          </button>

        </div>

        <!-- TABLE -->
        <div class="card-body">
          <table class="table table-bordered table-hover table-sm">

            <thead class="thead-dark">
              <tr>
                <th>#</th>
                <th>Table</th>
                <th>Customer</th>
                <th>Time Range</th>
                <th>Status</th>
                <th width="200">Actions</th>
              </tr>
            </thead>

            <tbody>

              <?php $i = 1; foreach($reservations as $r): ?>
              <tr>

                <td><?= $i++ ?></td>

                <td><strong>Table <?= $r['table_id'] ?></strong></td>

                <td><?= $r['customer_name'] ?></td>

                <!-- 🔥 TIME RANGE FIX -->
                <td>
                  <?php if(!empty($r['start_time']) && !empty($r['end_time'])): ?>
                    <?= date('h:i A', strtotime($r['start_time'])) ?>
                    TO
                    <?= date('h:i A', strtotime($r['end_time'])) ?>
                  <?php else: ?>
                    --
                  <?php endif; ?>
                </td>

                <!-- STATUS -->
                <td>
                  <?php if($r['status'] == 'pending'): ?>
                    <span class="badge badge-warning">Pending</span>

                  <?php elseif($r['status'] == 'approved'): ?>
                    <span class="badge badge-success">Approved</span>

                  <?php else: ?>
                    <span class="badge badge-danger">Cancelled</span>
                  <?php endif; ?>
                </td>

                <!-- ACTIONS -->
                <td>

  <?php if ($r['status'] == 'pending'): ?>

      <a href="<?= base_url('reservation/approve/'.$r['reservation_id']) ?>" 
         class="btn btn-success btn-sm">
        Approve
      </a>

      <a href="<?= base_url('reservation/cancel/'.$r['reservation_id']) ?>" 
         class="btn btn-warning btn-sm">
        Cancel
      </a>

      <a href="<?= base_url('reservation/edit/'.$r['reservation_id']) ?>" 
         class="btn btn-primary btn-sm">
        Edit
      </a>

      <a href="<?= base_url('reservation/delete/'.$r['reservation_id']) ?>" 
         class="btn btn-danger btn-sm"
         onclick="return confirm('Delete this reservation?')">
        Delete
      </a>

  <?php else: ?>

      <!-- approved OR cancelled -->
      <a href="<?= base_url('reservation/edit/'.$r['reservation_id']) ?>" 
         class="btn btn-primary btn-sm">
        Edit
      </a>

      <a href="<?= base_url('reservation/delete/'.$r['reservation_id']) ?>" 
         class="btn btn-danger btn-sm"
         onclick="return confirm('Delete this reservation?')">
        Delete
      </a>

  <?php endif; ?>

</td>

              </tr>
              <?php endforeach; ?>

            </tbody>

          </table>
        </div>

      </div>

    </div>
  </section>
</div>

<!-- ================= MODAL ================= -->
<div class="modal fade" id="addReservationModal">
  <div class="modal-dialog">

    <form action="<?= base_url('reservation/save') ?>" method="post">

      <?= csrf_field() ?>

      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Add Reservation</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

          <!-- TABLE -->
          <div class="form-group">
            <label>Select Table</label>
            <select name="table_id" class="form-control" required>
              <option value="">-- Select Table --</option>
              <?php foreach($tables as $t): ?>
                <option value="<?= $t['table_id'] ?>">
                  Table <?= $t['table_number'] ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- CUSTOMER -->
          <div class="form-group">
            <label>Customer Name</label>
            <input type="text" name="customer_name" class="form-control" required>
          </div>

          <!-- START TIME -->
          <div class="form-group">
            <label>Start Time</label>
            <input type="time" name="start_time" class="form-control" required>
          </div>

          <!-- END TIME -->
          <div class="form-group">
            <label>End Time</label>
            <input type="time" name="end_time" class="form-control" required>
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

<?= $this->endSection() ?>