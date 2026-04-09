<?= $this->extend('theme/template') ?>

<?= $this->section('content') ?>

<div class="content-wrapper">

  <!-- HEADER -->
  <div class="content-header">
    <div class="container-fluid">
      <h1>Dashboard</h1>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      <!-- 📊 CARDS -->
      <div class="row">

        <div class="col-lg-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= $totalProducts ?></h3>
              <p>Total Products</p>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= $totalStock ?></h3>
              <p>Total Stock</p>
            </div>
          </div>
        </div>

      </div>

      <!-- 📉 LOW STOCK TABLE -->
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-header bg-danger">
              <h3 class="card-title text-white">Low Stock Products (Below 10)</h3>
            </div>

            <div class="card-body">

              <table class="table table-bordered table-sm">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                  </tr>
                </thead>

                <tbody>
                  <?php if (!empty($lowStock)) : ?>
                    <?php $no = 1; ?>
                    <?php foreach ($lowStock as $row) : ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['product_name'] ?></td>

                        <td>
                          <span class="badge bg-danger">
                            <?= $row['quantity'] ?>
                          </span>
                        </td>

                        <td><?= $row['price'] ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td colspan="4" class="text-center">
                        ✅ No Low Stock Products
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>

              </table>

            </div>
          </div>

        </div>
      </div>

    </div>
  </section>

</div>

<?= $this->endSection() ?>