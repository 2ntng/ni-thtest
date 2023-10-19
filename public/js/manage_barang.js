var trigger = null;
var public_url = window.location.protocol + "//" + window.location.host + "/storage/";

function view_modal(id) {
    $.ajax({
        url: "/ajax/getData/" + id,
        method: "get",
        dataType: "JSON",
        beforeSend: function () {
            loading_start();
        },
        success: function (data) {
            $('#fm-foto-barang').attr('src', public_url + data.foto_barang);
            $('#fm-nama-barang').text(data.nama_barang);
            $('#fm-harga-beli').text(data.harga_beli.toLocaleString("id-ID", {
                style: "currency",
                currency: "IDR"
            }));
            $('#fm-harga-jual').text(data.harga_jual.toLocaleString("id-ID", {
                style: "currency",
                currency: "IDR"
            }));
            $('#fm-stok').text(data.stok);
            loading_end();
            $('#modal-view').modal('show');
        },
        error: function (e) {
            alert(e);
        }
    });
}

$('.custom-file-input').on('change', function () {
    var fileName = $(this).val();
    fileName = fileName.substring(fileName.lastIndexOf('\\') + 1);

    $(this).next('.custom-file-label').html(fileName);
})

function form_modal(id, act) {
    if (act == "Tambah") {
        $('#formModalLabel').text('Tambah Data'); // name label
        $('#foto_barang_label').text('Pilih gambar .jpg atau .png');
        $('#foto_barang_view').addClass("disabled");
        $('#formBarang')[0].reset(); // reset form
        $('#btnsubmit').text('Simpan');
        $('#btnsubmit').show();
        $('#modal-form').modal('show');
    } else {
        $('#id_barang').val(id);
        var id_barang = id;

        // Ajax isi data
        $.ajax({
            url: "/ajax/getData/" + id,
            method: "get",
            dataType: "JSON",
            data: {
                id: id_barang
            },
            beforeSend: function () {
                loading_start();
            },
            success: function (data) {
                $('#foto_barang_label').text('Ubah gambar, .jpg atau .png');
                $('#foto_barang_view').attr('href', public_url + data.foto_barang);
                $('#foto_barang_view').removeClass("disabled");
                $('#nama_barang').val(data.nama_barang);
                $('#harga_beli').val(data.harga_beli.toLocaleString("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }));
                $('#harga_jual').val(data.harga_jual.toLocaleString("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }));
                $('#stok').val(data.stok);
                loading_end();
                $('#modal-form').modal('show');
            },
            error: function (data) {
                console.log(data);
            }
        });

        $('#formModalLabel').text('Ubah Data'); //name view 
        $('#btnsubmit').text('Ubah'); //name Update  
        $('#btnsubmit').show();
    }
    trigger = act;
}

$(document).on("click", "#btnsubmit", function () {

    // Form data
    var fdata = new FormData();

    // Form data collect name value
    var form_data = $('#formBarang').serializeArray();
    $.each(form_data, function (key, input) {
        fdata.append(input.name, input.value);
    });
    var fotoBarang = $('#foto_barang')[0].files[0];
    fdata.append('foto_barang', fotoBarang);

    nama_barang = $('#nama_barang').val();

    fdata.set('harga_beli', rupiahToInt($('#harga_beli').val()));
    fdata.set('harga_jual', rupiahToInt($('#harga_jual').val()));

    // Simpan or Update data          
    var vurl;
    if (trigger == 'Tambah') {
        vurl = "/ajax/addData";
    } else {
        vurl = "/ajax/editData";
    }

    $.ajax({
        url: vurl,
        method: "POST",
        processData: false,
        contentType: false,
        data: fdata,
        success: function (data) {
            $("#modal-form").modal('hide');
            Swal.fire(
                'Berhasil ' + trigger.toLowerCase() + ' data!',
                nama_barang,
                'success'
            ); // Pesan berhasil
            $('#formBarang')[0].reset(); // Reset Form
            tblBarang.ajax.reload();
        },
        error: function (xhr, status, error) {
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                msg = '';

                for (var key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        msg = msg + "-" + errors[key][0] + "<br>";
                    }
                }
                Swal.fire(
                    trigger + ' data gagal!',
                    msg,
                    'error'
                );
            } else {
                // Handle other error cases
            }
        }
    });

});

tblBarang = null;
$(document).ready(function () {
    tblBarang = $('#tblBarang').DataTable({
        processing: true,
        responsive: true,
        order: [1, 'asc'],
        ajax: {
            url: '/ajax/getAll',
            dataSrc: ''
        },
        columns: [{
                data: 'id',
                sortable: false,
                render: function (data, row, type, meta) {
                    mnu = '';
                    mnu +=
                        '<div class="btn btn-success btn-sm btnActView mr-2" data-id="' +
                        data + '"> <i class="fa fa-eye"></i></div>';
                    mnu +=
                        '<div class="btn btn-primary btn-sm btnActEdit mr-2" data-id="' +
                        data +
                        '"> <i class="fa fa-edit"></i></div>';
                    mnu +=
                        '<div class="btn btn-danger btn-sm btnActDelete" data-id="' +
                        data + '" data-nama="' +
                        type.nama_barang +
                        '"> <i class="fa fa-trash"></i></div>';
                    return mnu;
                }
            },
            {
                data: 'nama_barang'
            },
            {
                data: 'harga_beli',
                render: function (data) {
                    return data.toLocaleString("id-ID", {
                        style: "currency",
                        currency: "IDR"
                    });
                }
            },
            {
                data: 'harga_jual',
                render: function (data) {
                    return data.toLocaleString("id-ID", {
                        style: "currency",
                        currency: "IDR"
                    });
                }
            },
            {
                data: 'stok'
            },
        ]
    });
});

$(document).on("click", ".btnActView", function () {
    view_modal($(this).attr("data-id"));
});

$(document).on("click", ".btnActEdit", function () {
    form_modal($(this).attr("data-id"), 'Ubah');
});

$(document).on("click", ".btnActDelete", function () {
    konfirmasiHapus($(this).attr("data-id"), $(this).attr("data-nama"));
});

function konfirmasiHapus(id, nama_barang) {
    Swal.fire({
        title: 'Hapus Data',
        text: "Apakah yakin menghapus data : " + nama_barang + "?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya, Hapus data!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/ajax/deleteData",
                method: "POST",
                data: {
                    id: id
                },
                success: function (data) {
                    Swal.fire(
                        'Berhasil hapus!',
                        nama_barang + ' berhasil dihapus.',
                        'success'
                    );
                    tblBarang.ajax.reload();
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
    });
}

$('#harga_beli').focus(function () {
    this.value = this.value.replace(/\D/g, "");
    this.value = this.value.substring(0, this.value.length - 2);
});
$('#harga_beli').blur(function () {
    this.value = Number(this.value).toLocaleString("id-ID", {
        style: "currency",
        currency: "IDR"
    })
});
$('#harga_jual').focus(function () {
    this.value = this.value.replace(/\D/g, "");
    this.value = this.value.substring(0, this.value.length - 2);
});
$('#harga_jual').blur(function () {
    this.value = Number(this.value).toLocaleString("id-ID", {
        style: "currency",
        currency: "IDR"
    })
});

function rupiahToInt(str) {
    str = str.replace(/\D/g, "");
    str = str.substring(0, str.length - 2);
    return Number(str);
}
