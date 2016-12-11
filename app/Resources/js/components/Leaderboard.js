var Leaderboard = function (API, Loader) {

    this.$modal = $('.modal--leaderboard');
    this.$listHolder = $('.leaderboard-content');
    this.$showButton = $('.btn--show-leaderboard');
    this.$closeButton = $('.close-leaderboard');

    this.API = API;
    this.Loader = Loader;

    this.initClickEvents();
};

Leaderboard.prototype.initClickEvents = function () {

    var that = this;

    this.$showButton.on('click', function(e){
        e.preventDefault();
        that.load();
    });

    this.$closeButton.on('click', function(e){
        e.preventDefault();
        that.hide();
    });
};

Leaderboard.prototype.load = function () {

    var that = this;

    this.Loader.show('Gaunama informacija. Prašome palaukti.');

    this.API.getLeaderboard().done(function (data) {

        var list = $('<ul class="leaderboard"/>');
        var li = $('<li class="header">' +
            '<span class="leaderboard--place">Vieta</span>' +
            '<span class="leaderboard--username">Vardas</span>' +
            '<span class="leaderboard--score">Surinko taškų</span>' +
            '</li>');
        list.append(li);
        $.each(data.leaders,function(i,leader){
            var li = $('<li>' +
                '<span class="leaderboard--place">'+(i+1)+'</span>' +
                '<span class="leaderboard--username">'+leader.username+'</span>' +
                '<span class="leaderboard--score">'+leader.score+'</span>' +
                '</li>');
            list.append(li);
        });

        that.$listHolder.html(list);
        that.Loader.hide();
        that.show();
    }).fail(function (response) {
        // Display error
        that.Loader.hide();
        console.error('Could not load leaderboard. ' + response.status + ' ' + response.statusText);
    });

};

Leaderboard.prototype.show = function () {
    this.$modal.fadeIn();
};

Leaderboard.prototype.hide = function () {
    this.$modal.fadeOut();
};