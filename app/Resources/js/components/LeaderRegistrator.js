var LeaderRegistrator = function(Alerter, Loader, API){
    this.$holder = $('.register-leader');
    this.$form = $('#leader-form');
    this.$nameField = $('#leader_name');

    this.Alerter = Alerter;
    this.Loader = Loader;
    this.API = API;

};

LeaderRegistrator.prototype.show = function () {
    this.$holder.slideDown();
};

LeaderRegistrator.prototype.hide = function () {
    this.$nameField.val('');
    this.$holder.slideUp();
};

LeaderRegistrator.prototype.init = function () {

    var that = this;

    this.$form.on('submit', function (e) {
        e.preventDefault();

        that.showLoader('Saugomas jūsų rezultatas. Prašome palaukti.');

        that.API.saveLeader({
            'username': $('#leader_name').val(),
            'score': goodAnswersCount,
            'time': timeSpent
        }).done(function (data) {

            that.hide();
            that.dissable();
            that.Loader.hide();

        }).fail(function (response) {
            // Display error

            that.Alerter.show('Jūsų rezultato išsaugoti nepavyko.');
            that.Loader.hide();
            console.error('Could not save leader to database. ' + response.status + ' ' + response.statusText);
        });
    });

    this.show();
};

LeaderRegistrator.prototype.dissable = function () {
    this.$form.unbind('submit');
};