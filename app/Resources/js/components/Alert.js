var Alert = function()
{
    this.$modal = $('.modal-alert');
    this.$textHolder = $('.modal-alert--message');
    this.$closeButton = $('.alert-ok');
    this.timer;
    this.timeToShow = 10; // In seconds

    var that = this;

    this.$closeButton.on('click',function(e){
        e.preventDefault();
        that.hide();
    });
};

Alert.prototype.hide = function ()
{
    clearTimeout(this.timer);
    this.$modal.fadeOut();
};

Alert.prototype.show = function(alertText)
{
    var that = this;
    this.$textHolder.text(alertText);
    this.$modal.fadeIn();
    this.timer = setTimeout(function(){
        that.hide();
    }, this.timeToShow * 1000);
};