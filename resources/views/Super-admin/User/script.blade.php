<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
              url: "{{ route('user.detail') }}",
              data: {id:id, "_token": $('#token').val()},
              success: function (data) {
                console.log(data);
                $('#id_user').val(data.data.id);
                $('#name').val(data.data.name);
                $('#email').val(data.data.email);
                $('#role').val(data.data.role);
                $('#status').val(data.data.status);
                $('#editData').modal('toggle');
              }         
          });
      })


      $('.detail').on('click',function(e){
           let id = $(this).data('id');
           $.ajax({
              type: "POST",
              url: "{{ route('user.detail') }}",
              data: {id:id, "_token": $('#token').val()},
              success: function (data) {
                console.log(data);
                $('#id_user_detail').val(data.data.id);
                $('#nameDetail').val(data.data.name);
                $('#emailDetail').val(data.data.email);
                $('#roleDetail').val(data.data.role);
                $('#statusDetail').val(data.data.status);
                $('#detailData').modal('toggle');
              }         
          });
      })


  });
</script>