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
                        <h5 class="card-title fw-semibold mb-0">Kolam</h5>
                            <form action="/admin/kolam/store" method="POST">
                                @csrf
                                <button type="button" class="btn btn-primary m-1" style="float:right;" onClick="printDiv()">
                                  Unduh
                                </button>
                                @if(Auth::user()->role == "admin")
                                <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#tambahKolamModal" >Tambah Kolam</button>
                                @endif
                                <!-- Modal -->
                                <div class="modal fade" id="tambahKolamModal" tabindex="-1" aria-labelledby="tambahKolamModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="tambahKolamModalLabel">Tambah Kolam</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        <form id="tambahKolamForm" onsubmit="event.preventDefault(); tambahKolam()">
                                          <div class="mb-3">
                                            <label for="namaKolam" class="form-label">Nama Kolam</label>
                                            <input name="nama_kolam" type="text" class="form-control" id="namaKolam">
                                          </div>
                                          <div class="mb-3">
                                            <label for="luasKolam" class="form-label">Luas Kolam</label>
                                            <input name="luas" type="text" class="form-control" id="luasKolam">
                                          </div>
                                          <div class="mb-3">
                                            <label for="tanggalDibersihkan" class="form-label">Tanggal Dibersihkan</label>
                                            <input name="tanggal_dibersihkan" type="date" class="form-control" id="tanggalDibersihkan" onchange="blockFutureDates(this)">
                                          </div>
                                          <div class="mb-3">
                                            <label for="tanggalPakan" class="form-label">Tanggal Diberi Pakan</label>
                                            <input name="tanggal_pakan" type="date" class="form-control" id="tanggalPakan" onchange="blockFutureDates(this)">
                                          </div>
                                          <div class="mb-3">
                                            <label for="tanggalPanen" class="form-label">Tanggal Terakhir Panen</label>
                                            <input name="tanggal_panen" type="date" class="form-control" id="tanggalPanen" onchange="blockFutureDates(this)">
                                          </div>
                                          <div class="mb-3">
                                            <label for="jumlahIkanHidup" class="form-label">Jumlah Ikan Hidup</label>
                                            <input name="jumlah_ikan_hidup" type="number" class="form-control" id="jumlahIkanHidup">
                                          </div>
                                          <div class="mb-3">
                                            <label for="jumlahIkanMati" class="form-label">Jumlah Ikan Mati</label>
                                            <input name="jumlah_ikan_mati" type="number" class="form-control" id="jumlahIkanMati">
                                          </div>
                                        </form>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </form>
                    </div>
                <div class="table-responsive" id="printTable">
                  <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">No</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Nama Kolam</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Luas</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Tanggal Terakhir Dibersihkan</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Tanggal Terakhir Panen</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Terakhir Diberi Pakan</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Jumlah Ikan Hidup</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Jumlah Ikan Mati</h6>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @if($kolam)
                      @foreach ($kolam as $item)
                      <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $item->nama_kolam }}</td>
                        <td>{{ $item->luas }}</td>
                        <td>{{ $item->tanggal_dibersihkan }}</td>
                        <td>{{ $item->tanggal_pakan }}</td>
                        <td>{{ $item->tanggal_panen }}</td>
                        <td>{{ $item->jumlah_ikan_hidup }}</td>
                        <td>{{ $item->jumlah_ikan_mati }}</td>
                        @if(Auth::user()->role == "admin")
                        <td>
                          <!-- Tombol Edit -->
                          <button type="button" class="btn btn-outline-light m-1 edit" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $item->id }}">
                              <img src="../assets/svg/outline/edit.svg" alt="Edit" width="15" height="15">
                          </button>
                          <!-- Tombol Detail -->
                          <button type="button" class="btn btn-outline-light m-1 detail" data-bs-toggle="modal" data-bs-target="#detailModal" data-id="{{ $item->id }}">
                            <img src="../assets/svg/filled/info-circle.svg" alt="Detail" width="15" height="15">
                          </button>
                          <!-- Tombol Hapus -->
                          <a href="{{ route('admin.kolam.delete', $item->id) }}" class="btn btn-outline-light m-1 hapus" data-id="{{ $item->id }}">
                                <img src="../assets/svg/outline/trash.svg" alt="Delete" width="15" height="15">
                          </a>
                        </td>
                        @endif
                      </tr>
                      @endforeach
                      <tr>
                        <th>Total</th>
                        <th></th>
                        <th>{{$totalLuas}}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>{{$totalHidup}}</th>
                        <th>{{$totalMati}}</th>
                        <th></th>
                      </tr>
                      @endif
                    </tbody>
                    <div class="modal fade" id="deleteModal2" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                            <form id="deleteKolamForm" action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menghapus  <span id="itemIdToDelete"></span>?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger" id="confirmDeleteButton">Hapus</button>
                                </div>
                            </form>
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
                                <label for="editNamaKolam" class="form-label">Nama Kolam</label>
                                <input name="nama_kolam" type="text" class="form-control" id="detailNamaKolam" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="editLuasKolam" class="form-label">Luas Kolam</label>
                                <input name="luas" type="text" class="form-control" id="detailLuas" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="editTanggalDibersihkan" class="form-label">Tanggal Dibersihkan</label>
                                <input name="tanggal_dibersihkan" type="date" class="form-control" id="detailTanggalDibersihkan" onchange="blockFutureDates(this)" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="editTanggalPakan" class="form-label">Tanggal Diberi Pakan</label>
                                <input name="tanggal_pakan" type="date" class="form-control" id="detailTanggalPakan" onchange="blockFutureDates(this)" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="editTanggalPanen" class="form-label">Tanggal Terakhir Panen</label>
                                <input name="tanggal_panen" type="date" class="form-control" id="detailTanggalPanen" onchange="blockFutureDates(this)" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="editJumlahIkanHidup" class="form-label">Jumlah Ikan Hidup</label>
                                <input name="jumlah_ikan_hidup" type="number" class="form-control" id="detailJumlahIkanHidup" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="editJumlahIkanMati" class="form-label">Jumlah Ikan Mati</label>
                                <input name="jumlah_ikan_mati" type="number" class="form-control" id="detailJumlahIkanMati" disabled>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Edit Kolam -->
                    @if(isset($item))
                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Kolam</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form id="editKolamForm" action="{{ route('admin.kolam.update', ['id' => $item->id]) }}" method="POST">
                                    <div class="modal-body">
                                        <!-- Form untuk mengedit kolam akan ditambahkan di sini -->
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="kolam_id" id="editKolamId">
                                        <div class="mb-3">
                                            <label for="editNamaKolam" class="form-label">Nama Kolam</label>
                                            <input name="nama_kolam" type="text" class="form-control" id="editNamaKolam">
                                        </div>
                                        <div class="mb-3">
                                            <label for="editLuasKolam" class="form-label">Luas Kolam</label>
                                            <input name="luas" type="text" class="form-control" id="editLuasKolam">
                                        </div>
                                        <div class="mb-3">
                                            <label for="editTanggalDibersihkan" class="form-label">Tanggal Dibersihkan</label>
                                            <input name="tanggal_dibersihkan" type="date" class="form-control" id="editTanggalDibersihkan" onchange="blockFutureDates(this)">
                                        </div>
                                        <div class="mb-3">
                                            <label for="editTanggalPakan" class="form-label">Tanggal Diberi Pakan</label>
                                            <input name="tanggal_pakan" type="date" class="form-control" id="editTanggalPakan" onchange="blockFutureDates(this)">
                                        </div>
                                        <div class="mb-3">
                                            <label for="editTanggalPanen" class="form-label">Tanggal Terakhir Panen</label>
                                            <input name="tanggal_panen" type="date" class="form-control" id="editTanggalPanen" onchange="blockFutureDates(this)">
                                        </div>
                                        <div class="mb-3">
                                            <label for="editJumlahIkanHidup" class="form-label">Jumlah Ikan Hidup</label>
                                            <input name="jumlah_ikan_hidup" type="number" class="form-control" id="editJumlahIkanHidup">
                                        </div>
                                        <div class="mb-3">
                                            <label for="editJumlahIkanMati" class="form-label">Jumlah Ikan Mati</label>
                                            <input name="jumlah_ikan_mati" type="number" class="form-control" id="editJumlahIkanMati">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function printDiv() {
                    var divName= "printTable";

                     var printContents = document.getElementById(divName).innerHTML;
                     var originalContents = document.body.innerHTML;

                     document.body.innerHTML = printContents;

                     window.print();

                     document.body.innerHTML = originalContents;
        }
  </script>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
  @extends('Admin.Kolam.script')
</body>
</html>
