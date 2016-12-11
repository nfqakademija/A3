var Secret = function(rootFact, questions)
{
    this.rootFact = rootFact;
    this.questions = questions;
};

Secret.prototype.getSecret = function()
{
    var stringIds = this.rootFact.id + '';

    for(var i = 0; i < this.questions.length; i++){
        stringIds += this.questions[i].id;
    }

    return sha256(stringIds);
};