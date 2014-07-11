

var ViewModel = function() {
    
    this.items = ko.observableArray();
    this.currentItem = ko.observable();
 
    
    this.load = function() {
        
        $.ajax('/product/ajax_missingProducts', {
            success: function(resp) {

                console.log(resp);
            }
        })
    }
    
    
    this.load();
};
 
ko.applyBindings(new ViewModel());












jQuery(document).ready(function() {
    
//    TableAjax.init();

    $('#btn-category-assign').click(getSamplaImages)
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
