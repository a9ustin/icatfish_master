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
              url: "{{ route('keuangan.detail') }}",
              data: {id:id, "_token": $('#token').val()},
              success: function (data) {
                console.log(data);
                $('#id_keuangan').val(data.data.id);
                $('#jenis_transaksi').val(data.data.jenis_transaksi);
                $('#tanggal').val(data.data.tanggal);
                $('#jumlah_uang').val(data.data.jumlah_uang);
                $('#keterangan').val(data.data.keterangan);
                $('#editData').modal('toggle');
              }
          });
      })


      $('.detail').on('click',function(e){
           let id = $(this).data('id');
           $.ajax({
              type: "POST",
              url: "{{ route('keuangan.detail') }}",
              data: {id:id, "_token": $('#token').val()},
              success: function (data) {
                console.log(data);
                $('#id_keuangan_detail').val(data.data.id);
                $('#jenis_transaksiDetail').val(data.data.jenis_transaksi);
                $('#tanggalDetail').val(data.data.tanggal);
                $('#jumlah_uangDetail').val(data.data.jumlah_uang);
                $('#keteranganDetail').val(data.data.keterangan);
                $('#detailData').modal('toggle');
              }
          });
      })


  });
</script>
