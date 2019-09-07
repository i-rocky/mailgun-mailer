import toastr from 'toastr';
import Swal from 'sweetalert2';

toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: true,
    progressBar: true,
    positionClass: 'toast-top-right',
    preventDuplicates: false,
    showDuration: 300,
    hideDuration: 500,
    timeOut: 3000,
    extendedTimeOut: 1000,
    showEasing: 'swing',
    hideEasing: 'linear',
    showMethod: 'fadeIn',
    hideMethod: 'fadeOut',
};

export default {
    success(text, title, duration) {
        toastr.success(text, title, {timeOut: duration});
    },
    error(text, title, duration) {
        toastr.error(text, title, {timeOut: duration});
    },
    warn(text, title, duration) {
        toastr.warn(text, title, {timeOut: duration});
    },
    info(text, title, duration) {
        toastr.info(text, title, {timeOut: duration});
    },
    confirm(
        title = 'Are you sure?',
        text = 'You won\'t be able to revert this',
        type = 'warning',
        confirmButtonText = 'Ok',
    ) {
        return new Promise((resolve) => {
            Swal
                .fire({
                    title,
                    text,
                    type,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText,
                })
                .then(({value}) => {
                    resolve(value === true);
                });
        });
    },
};
