<?= $this->extend('theme/template') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">

  <!-- ================= TOP CARDS ================= -->
  <div class="container-fluid mt-3">

    <div class="row">

      <div class="col-md-3">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>₱<?= number_format($totalSales, 2) ?></h3>
            <p>Total Sales</p>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3><?= $activeTables ?></h3>
            <p>Active Tables</p>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3><?= $reservedTables ?></h3>
            <p>Reserved Tables</p>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?= count($lowStock) ?></h3>
            <p>Low Stock Snack</p>
          </div>
        </div>
      </div>

    </div>

    <!-- ================= MAIN CONTENT ================= -->
    <div class="row mt-3">

      <!-- TABLE STATUS -->
      <div class="col-md-8">

        <div class="card">
          <div class="card-header">
            <h5>Tables Status</h5>
          </div>

          <div class="card-body p-0">

            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Table</th>
                  <th>Status</th>
                  <th>Start</th>
                  <th>End</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                <?php foreach($tables as $t): ?>
                <tr>
                  <td><?= $t['table_number'] ?></td>

                  <td>
                    <?php if($t['status']=='occupied'): ?>
                      <span class="badge badge-success">Active</span>
                    <?php elseif($t['status']=='reserved'): ?>
                      <span class="badge badge-warning">Reserved</span>
                    <?php else: ?>
                      <span class="badge badge-secondary">Available</span>
                    <?php endif; ?>
                  </td>

                  <td>
                    <?= $t['start_time'] ? date('h:i A', strtotime($t['start_time'])) : '--' ?>
                  </td>

                  <td>
                    <?= $t['end_time'] ? date('h:i A', strtotime($t['end_time'])) : '--' ?>
                  </td>

                  <td>
                    <?php if($t['status']=='available'): ?>
                      <a href="<?= base_url('tables/start/'.$t['table_id']) ?>" class="btn btn-success btn-sm">Start</a>
                    <?php elseif($t['status']=='occupied'): ?>
                      <a href="<?= base_url('tables/end/'.$t['table_id']) ?>" class="btn btn-danger btn-sm">End</a>
                    <?php endif; ?>
                  </td>

                </tr>
                <?php endforeach; ?>
              </tbody>

            </table>

          </div>
        </div>

      </div>

      <!-- LOW STOCK SIDE -->
      <div class="col-md-4">

        <div class="card">
          <div class="card-header bg-danger text-white">
            <h5>Low Stock Snack</h5>
          </div>

          <div class="card-body">

            <?php if(!empty($lowStock)): ?>
              <ul class="list-group">
                <?php foreach($lowStock as $item): ?>
                  <li class="list-group-item d-flex justify-content-between">
                    <?= $item['product_name'] ?>
                    <span class="badge badge-danger"><?= $item['quantity'] ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php else: ?>
              <p>No low stock items</p>
            <?php endif; ?>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>

<?= $this->endSection() ?>