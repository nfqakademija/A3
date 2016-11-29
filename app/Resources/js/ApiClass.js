var API = function()
{
    this.baseUrl = 'http://10.10.10.10:8000';
};

API.prototype.loadGameData = function(gameType)
{
    var url = this.baseUrl+'/game/init';
    return $.get(url);
};

API.prototype.loadFactsDetailsDataById = function(factId)
{
    var url = this.baseUrl+'/loadgamedata/'+factId;
    return $.get('');
};
