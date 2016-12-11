var QuitGame = function (that) {

    this.$modal = $('.quit-modal');
    this.$quitYes = $('.quit-yes');
    this.$quitNo = $('.quit-no');
    this.$backBtn = $('.back-arrow');

    this.that = that;
    this.isPlaying = false;

    this.initClickEvents();

};

QuitGame.prototype.initClickEvents = function () {
    var that = this;

    this.$quitYes.on('click', function (e) {
        e.preventDefault();
        that.hide();
        that.that.quitToMainScreen(true);
    });

    this.$quitNo.on('click', function (e) {
        e.preventDefault();
        that.hide();
        that.that.quitToMainScreen(false);
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
    if (this.that.isPlaying) {
        this.show();
        return;
    }
    this.hide();
    this.that.quitToMainScreen(true);
};

QuitGame.prototype.showBackBtn = function () {
    this.$backBtn.css('display', 'flex');
};

QuitGame.prototype.hideBackBtn = function () {
    this.$backBtn.css('display', 'none');
};


