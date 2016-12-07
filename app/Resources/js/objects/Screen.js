var Screen = function (title, block) {

    this.title = title;
    this.$block = $(block);

};

Screen.prototype.show = function () {
    this.$block.fadeIn();
};

Screen.prototype.hide = function () {
    this.$block.hide();
};

Screen.prototype.getTitle = function(){
    return this.title;
};