var QuitGame = function (quitCallback) {

    this.$modal = $('.quit-modal');
    this.$quitYes = $('.quit-yes');
    this.$quitNo = $('.quit-no');
    this.$backBtn = $('.back-arrow');

    this.quitCallback = quitCallback;
    this.isPlaying = false;

    this.initClickEvents();

};

QuitGame.prototype.initClickEvents = function () {
    var that = this;

    this.$quitYes.on('click', function (e) {
        e.preventDefault();
        that.hide();
        that.quitCallback(true);
    });

    this.$quitNo.on('click', function (e) {
        e.preventDefault();
        that.hide();
        that.quitCallback(false);
    });

    this.$backBtn.on('click', function (e) {
        e.preventDefault();

        that.stop();
    });
};

QuitGame.prototype.show = function () {
    this.$modal.fadeIn();
};

QuitGame.prototype.hide = function () {
    this.$modal.fadeOut();
};

QuitGame.prototype.stop = function () {
    if (this.isPlaying) {
        this.show();
        return;
    }
    this.hide();
    this.quitCallback(true);
};

QuitGame.prototype.showBackBtn = function () {
    this.$backBtn.css('display', 'flex');
};

QuitGame.prototype.hideBackBtn = function () {
    this.$backBtn.css('display', 'none');
};


