var Reset = {

    /**
     * Reset given vue variables.
     *
     * @param fields
     */
    vueData: function(vue, fields) {
        for (var index = 0; index < fields.length; index++) {
            vue.$set(fields[index], '');
        }
    }

};