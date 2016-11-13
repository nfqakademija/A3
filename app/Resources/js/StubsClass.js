var Stubs = function()
{
    this.mainFact = {
        'name':'Zalgirio musis'
    };
    this.allFacts = [
        {
            'name':'Punios musis',
            'was_before':true,
            'id':1
        },
        {
            'name':'Punios musis 2',
            'was_before':false,
            'id':2
        },
        {
            'name':'Punios musis 3',
            'was_before':true,
            'id':3
        }
    ];
};


Stubs.prototype.getMainFact = function()
{
    return this.mainFact;
};

Stubs.prototype.getAllFacts = function()
{
    return this.allFacts;
};
