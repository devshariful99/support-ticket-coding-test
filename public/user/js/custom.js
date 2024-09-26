function handleErrors(response) {
    var errors = response.message;
    for (var field in errors) {
        toastr.error(errors[field][0]);
    }
}
