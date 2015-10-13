var UrlBuilder = {

    /**
     * Return url used to get bill data.
     *
     * @param rowsOnPage
     * @param currentPage
     * @returns {string}
     */
    getBill: function(rowsOnPage, currentPage) {

        if (rowsOnPage < 1) {
            currentPage -= 1;
        }

        return '/bills/get?page=' + currentPage;
    },

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