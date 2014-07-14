

function Category(data) {

    this.catId = ko.observable(data.category_id);
    this.title = ko.observable(data.cat_name);
    this.count = ko.observable(data.say);
    
    
}


var ViewModel = function() {
    
    var self = this;
    
    this.loading = ko.observable(false);
    
    this.items = ko.observableArray();
    this.offers = ko.observableArray();
    this.merchants = ko.observableArray();
    this.currentItem = ko.observable();
 
    
    this.load = function() {
        
        
        this.loading(true);
        
        $.ajax('/product/ajax_missingProducts', {
            success: function(data) {

                var mapArr = $.map(data.products, function(data) { return new Category(data) });
                
                self.items(mapArr);
                
                self.loading(false);
            }
        })
    }
    
    
    this.loadSignData = function(a,b,c,d) {
        
        console.log(a,b,c,d);
        
    }
    
    
    
    this.load();
};
 
ko.applyBindings(new ViewModel());












jQuery(document).ready(function() {
    
//    TableAjax.init();

    $('#btn-category-assign').click(getSampleImages)
});


function getSampleImages() {
    
    var prId = $(this).val();
    
    $.ajax('/product/ajax_Products', {
        type: 'POST',
        data: {
            'id' : prId
        },
        success: function(resp) {
            
            console.log(resp);
        }
    })
}
