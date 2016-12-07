var Loader = function () {
    this.$modal = $('.loader');
    this.$textHolder = $('.loader-text');
};

Loader.prototype.show = function (loadingText) {
    this.$textHolder.text(loadingText);
    this.$modal.fadeIn();
};

Loader.prototype.hide = function (){
    this.$modal.fadeOut();
};