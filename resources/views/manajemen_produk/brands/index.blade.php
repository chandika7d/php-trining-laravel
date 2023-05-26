@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="m-0 text-dark">Manajemen Brands</h1>
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2',true)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="/brands/create" class="btn btn-primary mb-2">Tambah Brands</a>
                    <table class="table table-bordered" id="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Photo</th>
                            <th scope="col">Secondary Photo</th>
                            <th scope="col">Aksi</th>
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
                url:'/api/brands',
                type:'get',
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend(){
                    const html = `<tr>
                            <td colspan="7" class="text-center">loading ...</td>
                        </tr>`;
                    $('#table tbody').html(html);
                },
                success(data){
                    let html = `<tr>
                            <td colspan="7" class="text-center">No Data</td>
                        </tr>`;

                    const d = data.map((value,key) => {
                        console.log(value.secondary_photo)
                        return `<tr>
                            <th scope="row">${++key}</th>
                            <td>${value.name}</td>
                            <td>${value.slug}</td>
                            <td>${value.description}</td>
                            <td>${value.photo != '' ? `<img style="width: 200px; height: 200px;" class="img-thumbnail" src="${value.photo}">` : '-'}</td>
                            <td>${value.secondary_photo != '' ? `<img class="w-100 h-100" src="${value.secondary_photo}">` : '-'}</td>
                            <td>
                                <a href="/brands/${value.id}/edit" class="btn btn-warning btn-sm"><i class="fa fa-pencil-alt"></i></a>
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
                        url: '/api/brands/'+id,
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
