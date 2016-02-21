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
                    thisInstance.$set('current_title', false);
                    thisInstance.$set('current_id', false);
                    thisInstance.$set('new_notification_title', false);

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
         * Edit notification message.
         */
        editNotificationMessage: function() {

            this.$set('loading_message_modal', true);

            var postData = {
                _token: Token.get(),
                notification_id: this.$get('current_id'),
                notification_message: this.$get('new_notification_message')
            };

            var thisInstance = this;

            this.$http.post('/admin-center/notifications/edit-message', postData, function (response) {

                this.getNotifications(undefined, function() {

                    thisInstance.$set('loading_message_modal', false);
                    thisInstance.$set('current_id', false);
                    thisInstance.$set('current_message', false);
                    thisInstance.$set('new_notification_message', false);

                    $('#edit-notification-message-modal').modal('hide');
                    Alert.success(response.title, response.message);
                });

            }).error(function (response) {

                this.$set('loading_message_modal', false);

                if (!response.message) {
                    this.$set('error', Translation.common('general-error'));
                    return;
                }

                this.$set('error', response.message);
            });
        },

        /**
         * Set current message, id and reset modal.
         *
         * @param current_message
         * @param current_id
         */
        setCurrentMessage: function(current_message, current_id) {

            // Reset modal first
            this.$set('error', false);
            $('#new-notification-message').val('');

            this.$set('current_id', current_id);
            this.$set('current_message', current_message);
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

            }).error (function (response) {
                //
            });
        },

        /**
         * Delete all notifications.
         */
        deleteAllNotifications: function() {

            var thisInstance = this;

            Alert.confirmDelete(function() {

                Alert.loader();

                var postData = {
                    _token: Token.get()
                };

                thisInstance.$http.post('/admin-center/notifications/delete-all', postData, function (response) {

                    this.getNotifications(undefined, function() {
                        Alert.success(response.title, response.message);
                    });

                }).error(function (response) {
                    Alert.generalError();
                });

            }, 'delet etext');
        },

        /**
         * Set current id and get targeted users.
         *
         * @param notification_id
         * @param notification_title
         */
        setCurrentId: function(notification_id, notification_title) {

            this.$set('current_id', notification_id);
            this.$set('current_title', notification_title);
            this.$set('loading_targeted_users', true);

            this.$http.get('/admin-center/notifications/targeted-users', function (response) {

                this.$set('loading_targeted_users', false);
                this.$set('targeted_users', response.targeted_users);

            }).error (function (response) {

                this.$set('loading_targeted_users', false);

                if (!response.message) {
                    this.$set('error', Translation.common('general-error'));
                    return;
                }

                this.$set('error', response.message);
            });
        },

        /**
         * Allow to set targeted users.
         */
        addTargetedUsers: function() {

            this.$set('loading_targeted_users_modal', true);
            this.$set('error', false);

            var postData = {
                _token: Token.get(),
                target_group: this.$get('target_users_group'),
                notification_id: this.$get('current_id')
            };

            var thisInstance = this;

            // Make post request
            this.$http.post('/admin-center/notifications/set-targeted-users', postData, function (response) {

                this.getNotifications(undefined, function() {
                    thisInstance.$set('loading_targeted_users_modal', false);
                    $('#add-targeted-users-modal').modal('hide');
                    Alert.success(response.title, response.message);
                });

            }).error(function (response) {

                thisInstance.$set('loading_targeted_users_modal', false);

                if (!response.message) {
                    thisInstance.$set('error', Translation.common('general-error'));
                    return;
                }

                this.$set('error', response.message);
            });
        },
    }
});
//# sourceMappingURL=notifications-manager.js.map
