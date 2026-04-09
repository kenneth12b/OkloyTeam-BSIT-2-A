<?= $this->extend('theme/template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Categories System</h1>  <!-- ✅ Changed title -->
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Category List</h3>  <!-- ✅ Changed -->
              <div class="float-right">
                <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#AddNewModal">
                  <i class="fa fa-plus-circle"></i> Add Category  <!-- ✅ Changed -->
                </button>
              </div>
            </div>

            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th style="display:none;">ID</th>
                    <th>Category Name</th>  <!-- ✅ Changed -->
                    <th>Description</th>    <!-- ✅ Changed -->
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ✅ ADD MODAL - EXACT SAME -->
    <div class="modal fade" id="AddNewModal">
      <div class="modal-dialog">
        <form id="addCategoryForm">  <!-- ✅ Changed ID -->
          <?= csrf_field() ?>
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add Category</h5>  <!-- ✅ Changed -->
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <label>Category Name</label>  <!-- ✅ Changed -->
                <input type="text" name="category_name" class="form-control" required />  <!-- ✅ Changed name -->
              </div>

              <div class="form-group">
                <label>Description</label>  <!-- ✅ New field -->
                <input type="text" name="description" class="form-control" />  <!-- ✅ New field -->
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

    <!-- ✅ EDIT MODAL - EXACT SAME -->
    <div class="modal fade" id="editCategoryModal">  <!-- ✅ Changed ID -->
      <div class="modal-dialog">
        <form id="editCategoryForm">  <!-- ✅ Changed ID -->
          <?= csrf_field() ?>
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Category</h5>  <!-- ✅ Changed -->
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
              <input type="hidden" id="categoryId" name="id">  <!-- ✅ Changed ID -->

              <div class="form-group">
                <label>Category Name</label>  <!-- ✅ Changed -->
                <input type="text" name="category_name" id="category_name" class="form-control" required />  <!-- ✅ Changed -->
              </div>

              <div class="form-group">
                <label>Description</label>  <!-- ✅ New field -->
                <input type="text" id="description" name="description" class="form-control">  <!-- ✅ New field -->
              </div>  
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>

<div class="toasts-top-right fixed" style="position: fixed; top: 1rem; right: 1rem; z-index: 9999;"></div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script> const baseUrl = "<?= base_url() ?>"; </script>
<script src="<?= base_url('js/categories/categories.js') ?>"></script>  <!-- ✅ Changed path -->
<?= $this->endSection() ?>