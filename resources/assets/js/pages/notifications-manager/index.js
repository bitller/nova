new Vue({

    /**
     * Target element.
     */
    el: '#notifications-manager',

    /**
     * Called on ready.
     */
    ready: function() {
        this.getNotifications();
    },

    methods: {

        getNotifications: function(all, callback) {

            var url = '/admin-center/notifications/last';

            // Check if should be used url that returns all notifications
            if (typeof all !== 'undefined') {
                url = '/admin-center/notifications/all';
            }

            if (typeof callback === 'undefined') {
                this.$set('loading', true);
                Alert.loader();
            }

            this.$http.get(url, function (response) {

                this.$set('notifications', response.notifications);
                this.$set('number_of_notifications', response.number_of_notifications);

                if (typeof callback === 'undefined') {
                    this.$set('loading', false);
                    Alert.close();
                    return;
                }

                callback();
            }).error (function (response) {
                //
            });

        },

        /**
         * View or hide all notifications.
         */
        viewAllNotifications: function() {

            var thisInstance = this;

            if (this.$get('all_notifications_are_displayed')) {

                this.$set('show_all_notifications_button_loader', true);

                this.getNotifications(undefined, function() {
                    thisInstance.$set('show_all_notifications_button_loader', false);
                    thisInstance.$set('all_notifications_are_displayed', false);
                });

                return;
            }

            if (!this.$get('all_notifications_are_displayed')) {

                this.$set('show_all_notifications_button_loader', true);

                this.getNotifications('all', function() {
                    thisInstance.$set('show_all_notifications_button_loader', false);
                    thisInstance.$set('all_notifications_are_displayed', true);
                });

                return;
            }
        },

        /**
         * Allow admin to create new notification.
         */
        createNewNotification: function() {

            this.$set('loading_notifications_modal', true);
            this.$set('error', false);
            this.$set('errors', false);

            // Build data used in post request
            var postData = {
                _token: Token.get(),
                type: this.$get('type'),
                title: this.$get('title'),
                message: this.$get('message')
            };

            this.$http.post('/admin-center/notifications/new', postData, function (response) {

                this.getNotifications(undefined, function() {
                    this.$set('loading_notifications_modal', false);

                    $('#create-new-notification-modal').modal('hide');
                    Alert.success(response.title, response.message);
                });

            }).error(function (response) {

                this.$set('loading_notifications_modal', false);

                if (!response.message) {
                    Alert.generalError();
                    return false;
                }

                this.$set('errors', response.errors);
            });
        },

        /**
         * Allow admin to delete a notification.
         *
         * @param notification_id
         */
        deleteNotification: function(notification_id) {

            Alert.loader();

            var postData = {
                _token: Token.get(),
                notification_id: notification_id
            };

            this.$http.post('/admin-center/notifications/delete', postData, function (response) {

                this.getNotifications(undefined, function() {
                    Alert.success(response.title, response.message);
                });

            }).error(function (response) {
                Alert.generalError();
            });
        },

        /**
         * Edit notification title.
         *
         */
        editNotificationTitle: function() {

            this.$set('loading_title_modal', true);

            var postData = {
                _token: Token.get(),
                notification_id: this.$get('current_id'),
                notification_title: this.$get('new_notification_title')
            };

            var thisInstance = this;

            this.$http.post('/admin-center/notifications/edit-title', postData, function (response) {

                this.getNotifications(undefined, function() {
                    thisInstance.$set('loading_title_modal', false);
                    $('#edit-notification-title-modal').modal('hide');
                    Alert.success(response.title, response.message);
                });

            }).error(function (response) {

                this.$set('loading_title_modal', false);

                if (!response.message) {
                    this.$set('error', Translation.common('general-error'));
                    return;
                }

                this.$set('error', response.message);
            });
        },

        /**
         * Set given title as current title.
         *
         * @param current_title
         * @param current_id
         */
        setCurrentTitle: function(current_title, current_id) {

            // First reset modal
            this.$set('error', false);
            $('#new-notification-title').val('');

            this.$set('current_id', current_id);
            this.$set('current_title', current_title);
        },

        /**
         * Return notification types.
         */
        getTypes: function() {

            this.$set('loading_notification_types', true);
            this.$set('errors', false);
            this.$set('error', false);

            $('#title').val('');
            $('#message').val('');

            var thisInstance = this;

            this.$http.get('/admin-center/notifications/types', function (response) {

                this.$set('types', response.notification_types);
                this.$set('loading_notification_types', false);
                console.log(this.$get('types'));
            }).error (function (response) {
                //
            });
        }
    }
});