<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon">
      <img src="./img/logo.jpg" alt="" width="40" class="logo-gloria" />
    </div>
    <div class="sidebar-brand-text mx-3">Gloria School</div>
  </a>

  <!-- <div class="logo-gloria mt-4 mb-4"></div> -->

  <!-- Divider -->
  <hr class="sidebar-divider my-0" />

  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="index.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider" />

  <!-- Heading -->
  <div class="sidebar-heading">kendaraan</div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
      aria-controls="collapseTwo">
      <i class="fas fa-fw fa-car"></i>
      <span>Kendaraan</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Menu:</h6>
        <a class="collapse-item" href="./list_kendaraan.php">List Kendaraan</a>
        <a class="collapse-item" href="./add_kendaraan.php">Daftar Kendaraan baru</a>
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider" />

  <!-- Heading -->
  <div class="sidebar-heading">Riwayat</div>

  <!-- Nav Item - Charts -->
  <li class="nav-item">
    <a class="nav-link" href="./history.php">
      <i class="fas fa-fw fa-history"></i>
      <span>Riwayat Penjemputan</span></a>
  </li>

  <!-- Nav Item - Tables -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="./liveview.php" data-toggle="collapse" data-target="#collapseLiveview" aria-expanded="true"
      aria-controls="collapseLiveview">
      <i class="fas fa-fw fa-table"></i>
      <span>Live View</span>
    </a>
    <div id="collapseLiveview" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Menu:</h6>
        <a class="collapse-item" href="./liveview.php" target="_blank">All</a>
        <a class="collapse-item" href="./liveview.php?grade=tk" target="_blank">TK</a>
        <a class="collapse-item" href="./liveview.php?grade=sd" target="_blank">SD</a>
        <a class="collapse-item" href="./liveview.php?grade=smp" target="_blank">SMP</a>
      </div>
    </div>
  </li>

  <!-- Divider -->

  <hr class="sidebar-divider" />

  <!-- Heading -->
  <div class="sidebar-heading">Jam Operasional</div>

  <li class="nav-item">
    <a class="nav-link" id="editJam">
      <i class="fas fa-fw fa-clock"></i>
      <span>Ubah Jam</span></a>
  </li>

  <!-- Divider -->

  <hr class="sidebar-divider my-0" />
  <!-- <hr class="sidebar-divider d-none d-md-block"> -->

  <li class="nav-item">
    <a class="nav-link" href="logout.php">
      <i class="fas fa-sign-out-alt"></i>
      <span>Logout</span></a>
  </li>

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>
<!-- End of Sidebar -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: #000000">
          Ubah Jam
        </h5>
      </div>
      <form id="submit-jam" action="./api/editJam.php" method="POST">
        <div class="modal-body">
          <select name="select_grade" class="form-select w-100 p-1 mb-2" aria-label="Default select example" required>
            <option selected disabled value="0">Kelas yang diubah</option>
            <option value="1">TK</option>
            <option value="2">SD 1-3</option>
            <option value="3">SD 4-6</option>
            <option value="4">SMP</option>
          </select>
          <label for="awal" style="color: #000000">Jam Awal:</label>
          <input class="form-control mb-2" type="time" id="awal" name="awal" required />
          <label for="akhir" style="color: #000000">Jam Akhir:</label>
          <input class="form-control mb-2" type="time" id="akhir" name="akhir" required />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Close
          </button>
          <button type="submit" class="btn btn-primary">Save changes</button>
      </form>
    </div>
  </div>
</div>
</div>
<script>
  var btnEdit = document.getElementById("editJam");
  btnEdit.addEventListener("click", () => {
    $("#exampleModal").modal("show");
  });
  $(document).ready(function () {
    $("#submit-jam").on("submit", function (e) {
      e.preventDefault();
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "./api/editJam.php",
            type: "POST",
            dataType: "JSON",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false
          }).done((data) => {
            if (!data.success) {
              Swal.fire({
                icon: 'error',
                title: 'Failed!!',
                text: data.pesan
              })
            } else {
              Swal.fire({
                icon: 'success',
                title: 'Success!!',
                text: data.pesan
              })
            }
          })
        }
      })
    })
  })
</script>