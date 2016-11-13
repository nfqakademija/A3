var API = function()
{
    this.baseUrl = '';
};

API.prototype.loadGameData = function(gameType)
{
    var url = this.baseUrl+'/loadgamedata';
    return $.get(url);
};

API.prototype.loadFactsDetailsDataById = function(factId)
{
    var url = this.baseUrl+'/loadgamedata/'+factId;
    return $.get('');
};
