var ScreenPicker = function (screens) {
    this.screens = screens;
};

ScreenPicker.prototype.showScreen = function (title) {

    $.each(this.screens, function (i, screen) {
        if(screen.getTitle() == title){
            screen.show();
        }else{
            screen.hide();
        }
    });

};