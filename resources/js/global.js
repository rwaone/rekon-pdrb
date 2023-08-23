window.showToastr = function(type, message){
    switch(type) {
        case 'success':
        toastr.success(message)
        break;
        case 'info':
        toastr.info(message)
        break;
        case 'error':
        toastr.error(message)
        break;
        case 'warning':
        toastr.warning(message)
        break;
    }
}