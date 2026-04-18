<?= $this->extend('theme/template') ?>
<?= $this->section('content') ?>

<div class="container-fluid mt-3">

    <!-- 🎱 CARDS -->
    <div class="row mb-3">

        <div class="col-md-4">
            <div class="card shadow border-0 rounded-lg bg-success text-white">
                <div class="card-body">
                    <h6>Available Tables</h6>
                    <h3 id="availableTables">0</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-0 rounded-lg bg-danger text-white">
                <div class="card-body">
                    <h6>Occupied Tables</h6>
                    <h3 id="occupiedTables">0</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-0 rounded-lg bg-warning text-dark">
                <div class="card-body">
                    <h6>Maintenance</h6>
                    <h3 id="maintenanceTables">0</h3>
                </div>
            </div>
        </div>

    </div>

    <!-- 🎱 TABLE LIST -->
    <div class="card shadow border-0 rounded-lg">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>🎱 Billiard Tables</h5>
            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#AddTableModal">
                + Add Table
            </button>
        </div>

        <div class="card-body">
            <table id="tablesTable" class="table table-hover">
                <thead>
                    <tr>
                        <th>Table #</th>
                        <th>Status</th>
                        <th>Hourly Rate</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>

<!-- 🎱 ADD TABLE MODAL -->
<div class="modal fade" id="AddTableModal">
<div class="modal-dialog">
<form id="addTableForm">
<div class="modal-content">

<div class="modal-header bg-success text-white">
<h5>Add Table</h5>
</div>

<div class="modal-body">
<input name="table_number" class="form-control mb-2" placeholder="Table Name (ex. Table 1)">
<input name="hourly_rate" class="form-control mb-2" placeholder="Hourly Rate (₱)">
</div>

<div class="modal-footer">
<button class="btn btn-success">Save</button>
</div>

</div>
</form>
</div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const baseUrl = "<?= base_url() ?>";
</script>

<!-- 🔥 IMPORTANT: CHANGE JS FILE -->
<script src="<?= base_url('js/tables/tables.js') ?>"></script>

<?= $this->endSection() ?>