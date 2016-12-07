var FontResizer = function () {

    this.$resizerBlock = $(".hidenResizer");
    this.$mainWrapper = $('.main-wrapper');

    this.initialSize = 32;
    this.desiredheight = 120;
};

FontResizer.prototype.getSize = function (text) {
    var size = this.initialSize;


    this.$resizerBlock.html(text);
    this.$resizerBlock.css("width", this.$mainWrapper.width() - 100);
    this.$resizerBlock.css("font-size", size);

    while(this.$resizerBlock.height() >= this.desiredheight) {
        size = parseInt(this.$resizerBlock.css("font-size"), 10);
        this.$resizerBlock.css("font-size", size - 1);
    }

    return size;
};

FontResizer.prototype.setFontSize = function ($block, text) {
    var fontSize = this.getSize(text);
    $block.css('font-size',fontSize);
};