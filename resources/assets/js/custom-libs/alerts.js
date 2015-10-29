/**
 * Handle work with alerts.
 *
 * @type {{show: Function}}
 */
var Alert = {

    /**
     * Edit product name alert.
     *
     * @param name
     * @param callback
     */
    editProductName: function(name, callback) {

        var nameConfig = {
            title: Translation.productDetails('edit-name'),
            inputValue: name,
            text: Translation.productDetails('edit-name-description'),
            requiredInput: Translation.productDetails('name-input-required')
        };

        this.edit(nameConfig, callback);

    },

    /**
     * Edit product code alert.
     *
     * @param code
     * @param callback
     */
    editProductCode: function(code, callback) {

        var codeConfig = {
            title: Translation.productDetails('edit-code'),
            inputValue: code,
            text: Translation.productDetails('edit-code-description'),
            requiredInput: Translation.productDetails('code-input-required')
        };

        this.edit(codeConfig, callback);

    },

    /**
     * Edit product page alert.
     *
     * @param page
     * @param callback
     */
    editPage: function(page, callback) {

        var pageConfig = {
            title: Translation.bill('edit-page'),
            placeholder: page,
            text: Translation.bill('edit-page-description'),
            requiredInput: Translation.bill('product-page-required')
        };

        this.edit(pageConfig, callback);
    },

    /**
     * Edit product quantity alert.
     *
     * @param quantity
     * @param callback
     */
    editQuantity: function(quantity, callback) {

        var quantityConfig = {
            title: Translation.bill('edit-quantity'),
            placeholder: quantity,
            text: Translation.bill('edit-quantity-description'),
            requiredInput: Translation.bill('product-quantity-required')
        };

        this.edit(quantityConfig, callback);
    },

    /**
     * Edit product price alert.
     *
     * @param price
     * @param callback
     */
    editPrice: function(price, callback) {

        var priceConfig = {
            title: Translation.bill('edit-price'),
            placeholder: price,
            text: Translation.bill('edit-price-description'),
            requiredInput: Translation.bill('product-price-required')
        };

        this.edit(priceConfig, callback);

    },

    /**
     * Edit product discount alert.
     *
     * @param discount
     * @param callback
     */
    editDiscount: function(discount, callback) {

        var discountConfig = {
            title: Translation.bill('edit-discount'),
            placeholder: discount,
            text: Translation.bill('edit-discount-description'),
            requiredInput: Translation.bill('product-discount-required')
        };

        this.edit(discountConfig, callback);

    },

    /**
     *
     * @param data
     * @param callback
     */
    edit: function(data, callback) {

        swal({
            title: data.title,
            type: 'input',
            inputPlaceholder: data.placeholder,
            text: data.text,
            showCancelButton: true,
            cancelButtonText: Translation.common('cancel'),
            confirmButtonText: Translation.common('save'),
            showLoaderOnConfirm: true,
            closeOnConfirm: false,
            inputValue: data.inputValue
        }, function(inputValue) {

            if (typeof callback !== 'undefined') {

                if (inputValue === false) {
                    return false;
                }

                if (inputValue === '') {
                    swal.showInputError(data.requiredInput);
                    return false;
                }

                callback(inputValue);
            }

        });

    },

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
     * @param keep
     */
    error: function(title, message, keep) {
        this.show('error', title, message, keep);
    },

    /**
     * Show confirm delete product from bill alert.
     *
     * @param callback
     */
    confirmDeleteProductFromBill: function(callback) {

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
     * Show delete bill confirmation.
     *
     * @param callback
     */
    confirmDeleteBill: function(callback) {
        swal(this.getConfirmDeleteConfig(Translation.bills('bill-will-be-deleted')), function() {
            callback();
        });
    },

    /**
     * Show reset to default settings confirmation.
     *
     * @param callback
     */
    confirmResetToDefault: function(callback) {
        swal(this.getConfirmDeleteConfig(Translation.settings('settings-will-be-restored'), Translation.settings('reset'), Translation.common('cancel')), function() {
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
            showConfirmButton: false
        };

        if (time !== 'keep') {
            config.timer = time;
        }

        swal(config);
    },

    /**
     * Close alert box.
     */
    close: function() {
        swal.close()
    },

    /**
     * Return config object used for delete confirmation.
     *
     * @param text
     * @param confirmButtonText
     * @param cancelButtonText
     *
     * @returns {{title: (*|jQuery), text: *, type: string, showCancelButton: boolean, confirmButtonColor: string, confirmButtonText: (*|jQuery), cancelButtonText: (*|jQuery), closeOnConfirm: boolean}}
     */
    getConfirmDeleteConfig: function(text, confirmButtonText, cancelButtonText) {

        var confirmText = Translation.common('confirm-delete');
        var cancelText = Translation.common('cancel');

        if (typeof confirmButtonText !== 'undefined') {
            confirmText = confirmButtonText;
        }
        if (typeof cancelButtonText !== 'undefined') {
            cancelText = cancelButtonText;
        }

        return {
            title: Translation.common('confirm'),
            text: text,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: confirmText,
            cancelButtonText: cancelText,
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }
    }
}