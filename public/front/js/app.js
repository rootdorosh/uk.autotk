$(document).ready(function() {
    var selectYear = $('#home-filter-year');
    var selectMake = $('#home-filter-make');
    var selectModel = $('#home-filter-model');
    var btnSubmit = $('#home-filter-btn');
    
    $('body').on('change', '#home-filter-year', function(e) {
        var self = $(this);
        
        selectMake.find('option').not(':first').remove();
        
        if (self.val() !== '') {
            $.getJSON('/ajax/get-list-makes-by-year/' + self.val(), function(response) {
                $.each(response, function(index, item){
                    selectMake.append('<option value="' + item.slug + '" data-id="'+ item.id +'">' + item.title + '</option>');
                });
            });
        }
        selectMake.trigger('change');
    });

    $('body').on('change', '#home-filter-make', function(e) {
        var self = $(this);
        
        selectModel.find('option').not(':first').remove();
        
        if (self.val() != '') {
            $.getJSON('/ajax/get-list-models-by-year-and-make-id/' + selectYear.val() + '/' + selectMake.find('option:selected').data('id'), function(response) {
                $.each(response, function(index, item){
                    selectModel.append('<option value="' + item.slug + '" data-id="'+ item.id +'">' + item.title + '</option>');
                });
            });
        }
        
        selectModel.trigger('change');
    });

    $('body').on('change', '#home-filter-model', function(e) {
        var self = $(this);
        
        if (self.val() != '') {
            var url = btnSubmit.data('url');
            url = url.replace('{makeAlias}', selectMake.val());
            url = url.replace('{modelAlias}', selectModel.val());
            url = url + '#' + selectYear.val();
            
            btnSubmit.attr('href', url);
            btnSubmit.removeClass('hidden');
        } else {
            btnSubmit.addClass('hidden');
        }
    });

});
