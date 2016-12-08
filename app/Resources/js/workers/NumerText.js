var NumberText = function () {

};
NumberText.prototype.getText = function (number, oneText, fewText, tensText) {
    if ((number > 1 && number < 10)
        || (number > 20 && number % 10 !== 0 && number % 10 > 1)) {

        return fewText;

    } else if (number % 10 == 0 || number < 20 && number !== 1) {

        return tensText;
    }

    return oneText;
};