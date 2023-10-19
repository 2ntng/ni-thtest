const Toast = Swal.mixin({
    toast: true,
    position: 'center',
    showConfirmButton: false,
    timer: 3000
});

function berhasil($data) {

    Toast.fire({
        type: 'success',
        title: '&nbsp;' + $data
    });

}

function gagal($data) {

    Toast.fire({
        type: 'error',
        title: '&nbsp;' + $data
    });
}

function peringatan($data) {

    Toast.queue({
        type: 'warning',
        title: '&nbsp;' + $data
    });
}


const Toast2 = Swal.mixin({
    // toast: true,
    position: 'center',
    showConfirmButton: false,
    allowEscapeKey: false,
    allowOutsideClick: false,
    onOpen: () => {
        swal.showLoading();
    }
});


function loading_start() {
    Toast2.fire({
        title: 'Loading...'
    });
}


function loading_end() {
    Toast2.close();
}
