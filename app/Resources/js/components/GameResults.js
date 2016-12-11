var GameResults = function () {

    this.goodAnswersCount = 0;
    this.$endGameResults = $('.results');

};

GameResults.prototype.generateResults = function (facts, mainFact) {
    var that = this;

    var $mainFactLine = $('<li class="results--item main-item"></li>');
    var $mainTitleDateHolder = $('<div class="titleDate-holder" ></div>');
    $mainTitleDateHolder.append('<span class="titleDate-title">'+mainFact.name+'</span>');
    $mainTitleDateHolder.append('<span class="titleDate-date">'+mainFact.date+'</span>');
    $mainFactLine.append($mainTitleDateHolder);
    that.$endGameResults.append($mainFactLine);

    $.each(facts, function (i, fact) {
        var $resultLine = $('<li class="results--item"></li>');

        var $titleDateHolder = $('<div class="titleDate-holder" ></div>');
        $titleDateHolder.append('<span class="titleDate-title">'+fact.name+'</span>');
        $titleDateHolder.append('<span class="titleDate-date">'+fact.date+'</span>');

        $resultLine.append($titleDateHolder);
        $resultLine.prepend('<span class="correct-icon" />');
        $resultLine.prepend('<span class="wrong-icon" />');

        if (fact.answer_was_right) {
            that.goodAnswersCount++;
        } else {
            // Show that the answer was wrong
            $resultLine.addClass('wrong');
        }


        /*
        if(fact.has_details == true) {
            var $moreBtn = $('<a href="#" class="btn btn--more-details" data-fact_id="' + fact.id + '">Skaityti daugiau</a>');
            $moreBtn.on('click', function (e) {
                e.preventDefault();
                that.showDetails($(this));
            });
            $resultLine.append($moreBtn);
        }*/

        that.$endGameResults.append($resultLine);
    });
};

GameResults.prototype.resetResults = function () {
    this.$endGameResults.html('');
    this.goodAnswersCount = 0;
};

GameResults.prototype.getGoodAnswersCount = function () {
    return this.goodAnswersCount;
};