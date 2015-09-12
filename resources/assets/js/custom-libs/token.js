/**
 * Handle work with tokens
 *
 * @type {{get: Function}}
 */
var Token = {

    /**
     * Return token
     * @returns {*|jQuery}
     */
    get: function() {
        return $('#token').attr('content');
    }

};