/**
 * Main game class
 **/
var Game = function (gameContainer) {
    this.API = new API();

    // Facts array
    this.facts = [];
    this.factsCount = 0;
    this.mainFact = {};

    this.qestionIndex = 0;
    this.timer = null;
    this.timeLeft = 0;
    this.maxTime = 0;

    // Init elements
    // Main container
    this.$gameContainer = $(gameContainer);

    // Buttons
    this.$startBtn = $('.btn--start-game');
    this.$beforeBtn = $('.btn--before');
    this.$afterBtn = $('.btn--after');

    // Screens
    this.$startScreen = $('.screen--start');
    this.$gameScreen = $('.screen--game');
    this.$endGameScreen = $('.screen--end');
    this.$fullDetailsScreen = $('.modal--full-details');

    // Game objects
    this.$gameTimer = $('.timer');
    this.$gameQuestionCount = $('.question-count');
    this.$gameMainFact = $('.main-fact');
    this.$gameSecondaryFact = $('.socondary-fact');

    // End game objects
    this.$endGameTime = $('.time-holder');
    this.$endGameAnswers = $('.answers-holder');
    this.$endGameResults = $('.results');

    var that = this;


    // Init click events
    // Start game event
    this.$startBtn.on('click', function (e) {
        e.preventDefault();
        // Init game with game type 1
        that.initGame(1);
    });

    this.$beforeBtn.on('click', function (e) {
        e.preventDefault();
        // True - fact was before main fact
        that.checkAnswer(true);
    });

    this.$afterBtn.on('click', function (e) {
        e.preventDefault();
        // False - fact was after main fact
        that.checkAnswer(false);
    });
};

Game.prototype.initGame = function (gameType) {
    var that = this;
    // Display loader
    this.showLoader('Ruošiamas žaidimas. Prašome palaukti.');

    // Reset questions index
    this.qestionIndex = 0;


    // Load stubs data
   /* var allStubs = new Stubs();
    this.mainFact = allStubs.getMainFact();
    this.facts = allStubs.getAllFacts();

    that.factsCount = that.facts.length;
    that.$gameMainFact.text(that.mainFact.name);
    that.showNextQuestion();
    that.$startScreen.fadeOut();
    that.$gameScreen.fadeIn();
    this.maxTime = 50;
    that.initTimer();*/


    // Get game facts

    this.API.loadGameData(gameType).done(function (data) {
        // Parse data
        // Set main fact
        that.mainFact = data.root;
        // Set questions array
        that.facts = data.questions;
        that.factsCount = that.facts.length;

        that.$gameMainFact.text(that.mainFact.name);
        that.showNextQuestion();


        that.$startScreen.fadeOut();
        that.$gameScreen.fadeIn();
        that.maxTime = 50
        that.initTimer();

        that.hideLoader();

    }).fail(function (response) {
        // Display error
        that.hideLoader();
        console.error('Could not load game data. ' + response.status + ' ' + response.statusText);
    });

};

Game.prototype.initTimer = function () {
    var that = this;
    this.timeLeft = this.maxTime;
    this.$gameTimer.text(this.timeLeft + ' s');
    this.timer = setInterval(function () {
        that.checkTime();
    }, 1000);
};

Game.prototype.checkTime = function () {
    this.timeLeft--;
    if (this.timeLeft <= 0) {
        this.endGame();
    }

    this.$gameTimer.text(this.timeLeft + ' s');

    // Check if time is running out. If yes add allert class.
    if (this.timeLeft < 10 && !this.$gameTimer.hasClass('allert')) {
        this.$gameTimer.addClass('allert');
    }

};

Game.prototype.showLoader = function (loader_text) {
    $('.loader-text').text(loader_text);
    $('.loader').fadeIn();
};

Game.prototype.hideLoader = function () {
    $('.loader').fadeOut();
};

Game.prototype.showNextQuestion = function () {
    if (this.qestionIndex < this.factsCount) {
        // Display new question
        this.$gameSecondaryFact.text(this.facts[this.qestionIndex].name);
        this.$gameQuestionCount.text((this.qestionIndex + 1) + '/' + this.factsCount);

    } else {
        this.endGame();
    }
};

/**
 * Checks if answer is wright or wrong
 */
Game.prototype.checkAnswer = function (answer) {
    this.facts[this.qestionIndex].answer_was_right = answer == this.facts[this.qestionIndex].is_before;
    this.qestionIndex++;
    this.showNextQuestion();
};

Game.prototype.endGame = function () {
    // Display end game screen
    // Get full details
    // Display results

    var that = this;
    clearInterval(this.timer);
    var goodAnswersCount = 0;

    $.each(that.facts, function (i, fact) {
        var $resultLine = $('<li class="results--item"></li>');
        $resultLine.text(fact.name);
        if (fact.answer_was_right) {
            goodAnswersCount++;
        } else {
            // Show that the answer was wrong
            $resultLine.addClass('wrong').append('<span>Wrong</span>');
        }
        var $moreBtn = $('<a href="#" class="btn btn--more-details" data-fact_id="' + fact.id + '">Skaityti daugiau</a>');
        $moreBtn.on('click', function (e) {
            e.preventDefault();
            that.showDetails($(this));
        });
        $resultLine.append($moreBtn);

        that.$endGameResults.append($resultLine);
    });

    this.$endGameTime.text(this.maxTime - this.timeLeft);
    this.$endGameAnswers.text(goodAnswersCount);

    that.$gameScreen.fadeOut();
    that.$endGameScreen.fadeIn();
};

Game.prototype.showDetails = function ($button) {
    var factId = $button.data('fact_id');
    console.log(factId);
    this.API.loadFactsDetailsDataById(factId).done(function (data) {


    }).fail(function (response) {
        console.error('Could not load full details data. ' + response.status + ' ' + response.statusText);
    });
};

Game.prototype.resetGame = function () {
    // Reset game and get back to main screen
};