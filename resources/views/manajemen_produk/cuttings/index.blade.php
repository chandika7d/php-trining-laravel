@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="m-0 text-dark">Manajemen Cuttings</h1>
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2',true)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="/cuttings/create" class="btn btn-primary mb-2">Tambah Cuttings</a>
                    <table class="table table-bordered" id="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Cutting</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        getDataTable();
        function getDataTable(){
            $.ajax({
                url:'/api/cuttings',
                type:'get',
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend(){
                    const html = `<tr>
                            <td colspan="3" class="text-center">loading ...</td>
                        </tr>`;
                    $('#table tbody').html(html);
                },
                success(data){
                    let html = `<tr>
                                <td colspan="3" class="text-center">No Data</td>
                            </tr>`;

                    const d = data.map((value,key) => {
                        return `<tr>
                            <th scope="row">${++key}</th>
                            <td>${value.name}</td>
                            <td>
                                <a href="/cuttings/${value.id}/edit" class="btn btn-warning btn-sm"><i class="fa fa-pencil-alt"></i></a>
                                <button data-id="${value.id}" class="btn btn-danger btn-sm btn-delete"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>`;
                    });

                    if(d.length > 0){
                        $('#table tbody').html(d);
                        $('#table').dataTable();
                    }else{
                        $('#table tbody').html(html);
                    }
                },
                error(error){
                    console.error(error);
                }
            })
        }

        $(document).on('click','.btn-delete',function(){
           const id = $(this).data('id');

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Untuk hapus data ini?",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '/api/cuttings/'+id,
                        type:"DELETE",
                        enctype: 'multipart/form-data',
                        processData: false,
                        contentType: false,
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            accept: "*/*"
                        },
                        beforeSend(){
                            $(this).attr('disabled','true');
                            $(this).html('loading <i class="fa fa-spinner"></i>');
                        },
                        success(data){
                            $(this).removeAttr('disabled');
                            $(this).html('<i class="fa fa-trash"></i>');
                            getDataTable();
                            Swal.fire(
                                '',
                                'Data berhasil di hapus',
                                'success'
                            );

                            setTimeout(() => {
                                window.reload();
                            }, 500);
                        },
                        error(error){
                            console.error(error)
                            $(this).removeAttr('disabled');
                            $(this).html('<i class="fa fa-trash"></i>');
                        },
                    })
                }
            })
        });
    </script>
@stop
