var API = function () {
    this.baseUrl = '';
};

API.prototype.loadGameData = function (gameType) {
    var url = this.baseUrl + '/game/init';
    return $.get(url);
};

API.prototype.loadFactsDetailsDataById = function (factId) {
    var url = this.baseUrl + '/loadgamedata/' + factId;
    return $.get('');
};

API.prototype.saveGame = function (username, gameId, rootFact, questions) {

    var secretMaker = new Secret(rootFact, questions);

    var gameDetails = {};
    gameDetails.id = gameId;
    gameDetails.username = username;
    gameDetails.secret = secretMaker.getSecret();

    var url = this.baseUrl + 'game/save';
    return $.post(url, gameDetails);
};

API.prototype.finishGame = function (gameId, questionsAnswered, timeUsed, questions, rootFact) {

    var secretMaker = new Secret(rootFact, questions);

    var gameDetails = {};
    gameDetails.id = gameId;
    gameDetails.questions_answered = questionsAnswered;
    gameDetails.time_used = timeUsed;
    gameDetails.secret = secretMaker.getSecret();

    var url = this.baseUrl + 'game/finish';

    return $.get(url, gameDetails);
};


API.prototype.isLeaderBetter = function (score, time) {
    var url = this.baseUrl + 'leaderboard/isbetter/' + score + '/' + time;
    return $.get(url);
};

API.prototype.getLeaderboard = function () {
    var url = this.baseUrl + 'leaderboard/get';
    return $.get(url);
};