<input type="hidden" jenis_transaksi="_token" id="token" value="{{ csrf_token() }}">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
        function printDiv() {
                    var divName= "printTable";

                     var printContents = document.getElementById(divName).innerHTML;
                     var originalContents = document.body.innerHTML;

                     document.body.innerHTML = printContents;

                     window.print();

                     document.body.innerHTML = originalContents;
        }
        @if(Session::has('success'))
        Swal.fire(
            'Success!',
            '{{ session('success') }}',
            'success'
        )
      @endif

      @if(Session::has('error'))
          Swal.fire(
              'Error!',
              '{{ session('error') }}',
              'Error'
          )
      @endif
      $(document).ready(function () {
      $('.hapus').on('click', function (e) {

        e.preventDefault();
        const href = $(this).attr('href');


        Swal.fire({
          title: 'Apakah anda yakin ?',
          text: "Data akan dihapus!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Hapus data !'
        }).then((result) => {
            if (result.isConfirmed) {
            document.location.href = href;
          }
        });

      });

      $('.edit').on('click',function(e){
           let id = $(this).data('id');
           $.ajax({
              type: "POST",
              url: "{{ route('kolam.detail') }}",
              data: {"id":id, "_token": $('#token').val()},
              success: function (data) {
                console.log(data);
                $('#editKolamId').val(data.data.id);
                $('#editNamaKolam').val(data.data.nama_kolam);
                $('#editLuasKolam').val(data.data.luas);
                $('#editTanggalDibersihkan').val(data.data.tanggal_dibersihkan);
                $('#editTanggalPakan').val(data.data.tanggal_pakan);
                $('#editTanggalPanen').val(data.data.tanggal_panen);
                $('#editJumlahIkanHidup').val(data.data.jumlah_ikan_hidup);
                $('#editJumlahIkanMati').val(data.data.jumlah_ikan_mati);
              }
          });
      })


      $('.detail').on('click',function(e){
           let id = $(this).data('id');
           $.ajax({
              type: "POST",
              url: "{{ route('kolam.detail') }}",
              data: {id:id, "_token": $('#token').val()},
              success: function (data) {
                console.log(data);
                $('#detailNamaKolam').val(data.data.nama_kolam);
                $('#detailLuas').val(data.data.luas);
                $('#detailTanggalDibersihkan').val(data.data.tanggal_dibersihkan);
                $('#detailTanggalPakan').val(data.data.tanggal_pakan);
                $('#detailTanggalPanen').val(data.data.tanggal_panen);
                $('#detailJumlahIkanHidup').val(data.data.jumlah_ikan_hidup);
                $('#detailJumlahIkanMati').val(data.data.jumlah_ikan_mati);
              }
          });
      })


  });
</script>
