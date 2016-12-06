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

API.prototype.saveLeader = function (leader) {
    var url = this.baseUrl + 'leaderboard/save';
    return $.post(url, leader);
};

API.prototype.isLeaderBetter = function (score, time) {
    var url = this.baseUrl + 'leaderboard/isbetter/' + score + '/' + time;
    return $.get(url);
};

API.prototype.getLeaderboard = function () {
    var url = this.baseUrl + 'leaderboard/get';
    return $.get(url);
};