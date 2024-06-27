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
              url: "{{ route('olahan.detail') }}",
              data: {id:id, "_token": $('#token').val()},
              success: function (data) {
                console.log(data);
                $('#id_keuangan').val(data.data.id);
                $('#tanggal').val(data.data.tanggal);
                $('#jenis_transaksi').val(data.data.jenis_transaksi);
                $('#jenis_olahan').val(data.data.jenis_olahan);
                $('#total').val(data.data.total);
                $('#jumlah').val(data.data.jumlah);
                $('#editData').modal('toggle');
              }         
          });
      })


      $('.detail').on('click',function(e){
           let id = $(this).data('id');
           $.ajax({
              type: "POST",
              url: "{{ route('olahan.detail') }}",
              data: {id:id, "_token": $('#token').val()},
              success: function (data) {
                console.log(data);
                $('#id_keuangan_detail').val(data.data.id);
                $('#jenis_transaksiDetail').val(data.data.jenis_transaksi);
                $('#jenis_olahanDetail').val(data.data.jenis_olahan);
                $('#totalDetail').val(data.data.total);
                $('#jumlahDetail').val(data.data.jumlah);
                $('#detailData').modal('toggle');
              }         
          });
      })


  });
</script>