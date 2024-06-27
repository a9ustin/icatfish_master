@include('template.header')
      <!--  Header End -->
      <div class="container-fluid">
        <!--  Row 1 -->
        <div class="row">
          <div class="col-lg-8 d-flex align-items-strech">
            <div class="card w-100">
            </div>
          </div>
          <div class="col-lg-4">
            <div class="row">
              <div class="col-lg-12">
              </div>
              <div class="col-lg-12">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 d-flex align-items-stretch">
          </div>
          <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-semibold mb-0">Manajemen User</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                          Tambah Data
                        </button>
                    </div>
                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">No</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Name</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Email</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Role</h6>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($user as $item)
                      <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->role }}</td>
                        <td>
                          <!-- Tombol Edit -->
                          <button type="button"  class="btn btn-outline-light m-1 edit" data-id="{{ $item->id }}">
                              <img src="../assets/svg/outline/edit.svg" alt="Edit" width="15" height="15">
                          </button>
                          <!-- Tombol Detail -->
                          <button type="button" class="btn btn-outline-light m-1 detail" data-id="{{ $item->id }}" >
                            <img src="../assets/svg/filled/info-circle.svg" alt="Detail" width="15" height="15">
                          </button>
                          <!-- Tombol Hapus -->
                          <a href="{{ route('user.destroy', $item->id) }}" class="btn btn-outline-light m-1 hapus" data-id="{{ $item->id }}">
                            <img src="../assets/svg/outline/trash.svg" alt="Delete" width="15" height="15">
                          </a>
                        </td>
                      </tr>
                      @endforeach                      
                    </tbody>
                    <div class="modal fade" id="deleteModal2" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus  <span id="itemIdToDelete"></span>?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteButton">Hapus</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Detail Kolam -->
                    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel">Detail Kolam</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <!-- Konten detail kolam di sini -->
                            <div class="mb-3">
                              <label for="detailNamaKolam" class="form-label">Nama Kolam</label>
                              <p id="detailNamaKolam"></p>
                            </div>
                            <div class="mb-3">
                              <label for="detailLuas" class="form-label">Luas</label>
                              <p id="detailLuas"></p>
                            </div>
                            <div class="mb-3">
                              <label for="detailTanggalDibersihkan" class="form-label">Tanggal Terakhir Dibersihkan</label>
                              <p id="detailTanggalDibersihkan"></p>
                            </div>
                            <div class="mb-3">
                              <label for="detailTanggalPakan" class="form-label">Tanggal Diberi Pakan</label>
                              <p id="detailTanggalPakan"></p>
                            </div>
                            <div class="mb-3">
                              <label for="detailTanggalPanen" class="form-label">Tanggal Terakhir Panen</label>
                              <p id="detailTanggalPanen"></p>
                            </div>
                            <div class="mb-3">
                              <label for="detailJumlahIkanHidup" class="form-label">Jumlah Ikan Hidup</label>
                              <p id="detailJumlahIkanHidup"></p>
                            </div>
                            <div class="mb-3">
                              <label for="detailJumlahIkanMati" class="form-label">Jumlah Ikan Mati</label>
                              <p id="detailJumlahIkanMati"></p>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Edit Kolam -->
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="editDataLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editDataLabel">Update Data user</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('user.update') }}" method="POST"  enctype="multipart/form-data"> 
      @csrf
      <input type="hidden" id="id_user" name="id">
      <div class="modal-body">
        <div class="form-group">
          <label for="namaUser" class="form-label">Nama User</label>
          <input id="name" type="text" name="name" class="form-control" placeholder="Masukan Nama User" required>
        </div>
        <div class="form-group">
          <label for="email" class="form-label">Email</label>
          <input id="email" type="email" name="email" class="form-control" placeholder="Masukan Email" required>
        </div>
        <div class="form-group">
          <label for="Role" class="form-label">Role</label>
          <select id="role" name="role" class="form-control">
            <option value="" selected>-- Pilih Role User --</option>
            <option value="admin" >Admin</option>
            <option value="super admin" >Super Admin</option>
          </select>
        </div>
        <div class="form-group">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" placeholder="Isi Field jika ingin mengubah password">
        </div>
        <div class="form-group">
          <label for="status" class="form-label">Status</label>
          <select id="status" name="status" class="form-control">
            <option value="" selected>-- Pilih Status --</option>
            <option value="1" >Aktif</option>
            <option value="0" >Non Aktif</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="detailData" tabindex="-1" role="dialog" aria-labelledby="detailDataLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailDataLabel">Detail Data user</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <input type="hidden" id="id_user_detail" name="id">
      <div class="modal-body">
        <div class="form-group">
          <label for="namaUser" class="form-label">Nama User</label>
          <input id="nameDetail" type="text" name="name" class="form-control" placeholder="Masukan Nama User" required>
        </div>
        <div class="form-group">
          <label for="email" class="form-label">Email</label>
          <input id="emailDetail" type="email" name="email" class="form-control" placeholder="Masukan Email" required>
        </div>
        <div class="form-group">
          <label for="Role" class="form-label">Role</label>
          <select id="roleDetail" name="role" class="form-control">
            <option value="" selected>-- Pilih Role User --</option>
            <option value="admin" >Admin</option>
            <option value="super admin" >Super Admin</option>
          </select>
        </div>
        <div class="form-group">
          <label for="statusDetail" class="form-label">Status</label>
          <select id="statusDetail" name="status" class="form-control">
            <option value="" selected>-- Pilih Status --</option>
            <option value="1" >Aktif</option>
            <option value="0" >Non Aktif</option>
          </select>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data user</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('user.add') }}" method="POST"  enctype="multipart/form-data"> 
      @csrf
      <div class="modal-body">
        <div class="form-group">
          <label for="namaUser" class="form-label">Nama User</label>
          <input type="text" name="name" class="form-control" placeholder="Masukan Nama User" required>
        </div>
        <div class="form-group">
          <label for="email" class="form-label">Email</label>
          <input  type="email" name="email" class="form-control" placeholder="Masukan Email" required>
        </div>
        <div class="form-group">
          <label for="Role" class="form-label">Role</label>
          <select name="role" class="form-control">
            <option value="" selected>-- Pilih Role User --</option>
            <option value="admin" >Admin</option>
            <option value="super admin" >Super Admin</option>
          </select>
        </div>
        <div class="form-group">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" placeholder="Masukan Password" required>
        </div>
        <div class="form-group">
          <label for="status" class="form-label">Status</label>
          <select name="status" class="form-control">
            <option value="" selected>-- Pilih Status --</option>
            <option value="1" >Aktif</option>
            <option value="0" >Non Aktif</option>
          </select>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
  @extends('Super-admin.User.script')     
</body>
</html>