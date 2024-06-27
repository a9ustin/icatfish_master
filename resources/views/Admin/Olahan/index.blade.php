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
                        <h5 class="card-title fw-semibold mb-0">Manajemen Olahan Ikan</h5>
                        <div>
                          @if(Auth::user()->role == "admin")
                          <button type="button" class="btn btn-primary" style="float:right;" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Tambah Data
                          </button>
                          @endif
                          <button type="button" class="btn btn-primary" style="float:right;" onClick="printDiv()">
                            Unduh
                          </button>
                        </div>
                    </div>
                <div class="table-responsive" id="printTable">
                  <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">No</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Tanggal</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Jenis Transaksi</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Jenis Olahan</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Jumlah Olahan</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Total</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Action</h6>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($olahan as $item)
                      <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->jenis_transaksi }}</td>
                        <td>{{ $item->jenis_olahan }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>{{ $item->total }}</td>
                        @if(Auth::user()->role == "admin")
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
                          <a href="{{ route('olahan.destroy', $item->id) }}" class="btn btn-outline-light m-1 hapus" data-id="{{ $item->id }}">
                            <img src="../assets/svg/outline/trash.svg" alt="Delete" width="15" height="15">
                          </a>
                        </td>
                        @endif
                      </tr>
                      @endforeach
                      <tr>
                        <th>Total:</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>{{$total}}</th>
                        <th></th>
                      </tr>
                    </tbody>
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
      <form action="{{ route('olahan.update') }}" method="POST"  enctype="multipart/form-data">
      @csrf
      <input type="hidden" id="id_keuangan" name="id">
      <div class="modal-body">
        <div class="form-group">
          <label for="tanggal" class="form-label">Tanggal</label>
          <input  type="date" id="tanggal" name="tanggal" class="form-control" placeholder="Masukan Tanggal" required>
        </div>
        <div class="form-group">
          <label for="Jenis Transaksi" class="form-label">Jenis Transaksi</label>
          <select name="jenis_transaksi" id="jenis_transaksi" class="form-control">
            <option value="" selected>-- Pilih Jenis Transaksi --</option>
            <option value="Pemasukan" >Pemasukan</option>
            <option value="Pengeluaran" >Keluar</option>
          </select>
        </div>
        <div class="form-group">
          <label for="jenis_olahan" class="form-label">Jenis Olahan</label>
          <input  type="text" id="jenis_olahan" name="jenis_olahan" class="form-control" placeholder="Masukan Jenis Olahan" required>
        </div>
        <div class="form-group">
          <label for="jumlah" class="form-label">Jumlah Olahan</label>
          <input  type="number" id="jumlah" name="jumlah" class="form-control" placeholder="Masukan jumlah" required>
        </div>
        <div class="form-group">
          <label for="total" class="form-label">Total</label>
          <input  type="number" id="total" name="total" class="form-control" placeholder="Masukan Total" required>
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
          <label for="tanggal" class="form-label">Tanggal</label>
          <input  type="date" id="tanggalDetail" name="tanggal" class="form-control" placeholder="Masukan Tanggal" required>
        </div>
        <div class="form-group">
          <label for="Jenis Transaksi" class="form-label">Jenis Transaksi</label>
          <select name="jenis_transaksi" id="jenis_transaksiDetail" class="form-control">
            <option value="" selected>-- Pilih Jenis Transaksi --</option>
            <option value="Pemasukan" >Pemasukan</option>
            <option value="Pengeluaran" >Keluar</option>
          </select>
        </div>
        <div class="form-group">
          <label for="jenis_olahan" class="form-label">Jenis Olahan</label>
          <input  type="text" id="jenis_olahanDetail" name="jenis_olahan" class="form-control" placeholder="Masukan Jenis Olahan" required>
        </div>
        <div class="form-group">
          <label for="jumlah" class="form-label">Jumlah Olahan</label>
          <input  type="number" id="jumlahDetail" name="jumlah" class="form-control" placeholder="Masukan jumlah" required>
        </div>
        <div class="form-group">
          <label for="total" class="form-label">Total</label>
          <input  type="number" id="totalDetail" name="total" class="form-control" placeholder="Masukan Total" required>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Olahan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('olahan.add') }}" method="POST"  enctype="multipart/form-data">
      @csrf
      <div class="modal-body">
        <div class="form-group">
          <label for="tanggal" class="form-label">Tanggal</label>
          <input  type="date" name="tanggal" class="form-control" placeholder="Masukan Tanggal" required>
        </div>
        <div class="form-group">
          <label for="Jenis Transaksi" class="form-label">Jenis Transaksi</label>
          <select name="jenis_transaksi" class="form-control">
            <option value="" selected>-- Pilih Jenis Transaksi --</option>
            <option value="Pemasukan" >Pemasukan</option>
            <option value="Pengeluaran" >Keluar</option>
          </select>
        </div>
        <div class="form-group">
          <label for="jenis_olahan" class="form-label">Jenis Olahan</label>
          <input  type="text" name="jenis_olahan" class="form-control" placeholder="Masukan Jenis Olahan" required>
        </div>
        <div class="form-group">
          <label for="jumlah" class="form-label">Jumlah Olahan</label>
          <input  type="number" name="jumlah" class="form-control" placeholder="Masukan jumlah" required>
        </div>
        <div class="form-group">
          <label for="total" class="form-label">Total</label>
          <input  type="number" name="total" class="form-control" placeholder="Masukan Total" required>
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
  @extends('Admin.Olahan.script')
</body>
</html>
