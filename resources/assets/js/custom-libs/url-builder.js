var UrlBuilder = {

    /**
     * Return url used to delete a bill.
     *
     * @param billId
     * @returns {string}
     */
    deleteBill: function(billId) {
        return '/bills/' + billId + '/delete';
    }

};