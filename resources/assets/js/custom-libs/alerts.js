/**
 * Handle work with alerts.
 *
 * @type {{show: Function}}
 */
var Alert = {

    /**
     * Show loader.
     */
    loader: function() {
        swal({
            title: Translation.common('loading'),
            type: 'info',
            showConfirmButton: false
        })
    },

    /**
     * Show success alert box.
     *
     * @param title
     * @param message
     */
    success: function(title, message) {
        this.show('success', title, message);
    },

    /**
     * Show general error alert box.
     */
    generalError: function() {
        this.error(Translation.common('fail'), Translation.common('general-error'));
    },

    /**
     * Show error alert box.
     *
     * @param title
     * @param message
     */
    error: function(title, message) {
        this.show('error', title, message);
    },

    /**
     * Show confirm delete product from bill alert.
     *
     * @param callback
     */
    confirmDelete: function(callback) {

        swal({
            title: Translation.common('confirm'),
            text: Translation.bill('product-will-be-deleted'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: Translation.common('confirm-delete'),
            cancelButtonText: Translation.common('cancel'),
            closeOnConfirm: false
        }, function () {
            callback();
        });
    },

    /**
     * @param type
     * @param title
     * @param message
     * @param time
     */
    show: function(type, title, message, time) {

        // Set default value to hide hide the alert
        if (typeof time === 'undefined') {
            time = 1750;
        }

        var config = {
            title: title,
            text: message,
            type: type,
            timer: time,
            showConfirmButton: false
        };

        swal(config);
    },

    /**
     * Close alert box.
     */
    close: function() {
        swal.close()
    }
}