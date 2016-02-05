new Vue({

    /**
     * Target element.
     */
    el: '#compare-campaigns',

    ready: function() {
        this.getCharts();
    },

    methods: {
        getCharts: function() {
            var numberOfClientsChart = document.getElementById("number-of-clients-chart").getContext("2d");

            var clientsData = [
                {
                    value: 45,
                    color:"#F7464A",
                    highlight: "#FF5A5E",
                    label: "Clienti in campania 2/2016"
                },
                {
                    value: 50,
                    color: "#46BFBD",
                    highlight: "#5AD3D1",
                    label: "Clienti in campania 1/2016"
                }
            ];

            new Chart(numberOfClientsChart).Pie(clientsData, {scaleBeginAtZero : true, scaleGridLineWidth : 1});
        }
    }
});