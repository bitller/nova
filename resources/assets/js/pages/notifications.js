new Vue({

    /**
     * Target element.
     */
    el: '#notifications',

    /**
     * Called on ready.
     */
    ready: function() {

        this.getNotifications();

        var thisInstance = this;

        (function () {
            var pusher = new Pusher('ec8f61a5a50cba3228e0', {
                encrypted: true
            });

            var channel = pusher.subscribe('notifications');

            channel.bind('App\\Events\\NotificationCreated', function(data) {
                thisInstance.getNotifications();
            });

        })();

        //
        //var thisInstance = this;
        //
        //setInterval(function() {
        //    thisInstance.getNotifications();
        //}, 60000);
    },

    methods: {

        updateNotifications: function() {
            //
        },

        getNotifications: function() {

            this.$set('loading_notifications', true);

            this.$http.get('/notifications', function (response) {

                this.$set('loading_notifications', false);
                this.$set('notifications', response.notifications);
                this.$set('number_of_notifications', response.number_of_notifications);
                this.$set('number_of_notifications_counter', response.number_of_notifications);

            }).error(function (response) {
                //
            });
        },

        /**
         * Mark notifications as read.
         */
        markNotificationsAsRead: function() {
            this.$http.get('/notifications/mark-notifications-as-read', function (response) {
                this.$set('number_of_notifications_counter', 0);
            }).error (function (response) {
                //
            });
        }

    }
});