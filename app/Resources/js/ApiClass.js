var API = function()
{
    this.baseUrl = '';
};

API.prototype.loadGameData = function()
{
    var url = this.baseUrl+'/loadgamedata';
    return $.get(url);
};

API.prototype.loadFactsDetailsData = function()
{
    var url = this.baseUrl+'/loadgamedata';
    return $.get(url);
};
