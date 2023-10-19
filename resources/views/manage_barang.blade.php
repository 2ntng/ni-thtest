<!DOCTYPE html>
<html lang="en">
@extends('layouts.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $title }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="btn btn-primary btn-sm col-md-2" onclick="form_modal('1','Tambah')"><i
                            class="fa fa-plus"></i>
                        Tambah Data
                    </div>
                </div>
                <div class="row py-3">
                    <div class="col-md-12">
                        <table id="tblBarang" class="display responsive nowrap text-center" width="100%">

                            <thead>
                                <tr>
                                    <th data-priority="1">AKSI</th>
                                    <th data-priority="1">NAMA BARANG</th>
                                    <th>HARGA BELI</th>
                                    <th>HARGA JUAL</th>
                                    <th data-priority="2">STOK</th>
                                </tr>
                            </thead>

                            <tbody></tbody>

                        </table>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


@section('modal')
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="formModalLabel">Tambah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>

                <!-- form -->
                <form role="form" id="formBarang" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">

                        <input type="text" name="id_barang" class="form-control" id="id_barang" hidden>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="foto_barang">FOTO BARANG</label>
                                </div>
                                <div class="col-md-1">
                                    <a class="btn btn-success btn-block disabled" id="foto_barang_view" style="color:#fff" target="_blank">
                                        <i class="fa fa-paperclip"></i> </a>
                                </div>
                                <div class="col-md-7">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="foto_barang" accept="image/*"
                                            name="foto_barang">
                                        <label class="custom-file-label" for="foto_barang" id="foto_barang_label">Pilih
                                            gambar .jpg atau .png</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="nama_barang">NAMA BARANG</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="nama_barang" class="form-control" id="nama_barang">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="harga_beli">HARGA BELI</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="harga_beli" class="form-control" id="harga_beli"
                                        value="Rp 0,00"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="harga_jual">HARGA JUAL</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="harga_jual" class="form-control" id="harga_jual"
                                        value="Rp 0,00"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="stok">STOK</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" name="stok" class="form-control" id="stok"
                                        value="0">
                                </div>
                            </div>
                        </div>

                    </div><!-- Close Card Body -->

                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" id="btnsubmit">Simpan</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    </div>

                </form>
                <!-- /form  -->

            </div>
            <!-- Close modal-content -->
        </div>
        <!-- Close modal-dialog -->
    </div><!-- Close modal-form -->

    <div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="viewModalLabel">View Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <img class="img-fluid"
                                src="http://127.0.0.1:8000/storage/img/foto-barang/5wz79aBOzsVsb0P9Un8IaytqTHIFjwjBW0j63WjS.png"
                                alt="Eror memuat foto" id="fm-foto-barang">
                        </div>
                        <div class="col-lg-8">
                            <h2 id="fm-nama-barang">Nama Barang</h2>
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th scope="row">Harga Beli</th>
                                        <td id="fm-harga-beli">Rp 1.000.000,00</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Harga Beli</th>
                                        <td id="fm-harga-jual">Rp 1.000.000,00</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Stok</th>
                                        <td id="fm-stok">10</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
            <!-- Close modal-content -->
        </div>
        <!-- Close modal-dialog -->
    </div><!-- Close modal-view -->
@endsection

@section('javascript')
    <script src={{ asset('js/app.js') }}></script>
    <script src={{ asset('js/manage_barang.js') }}></script>
@endsection
