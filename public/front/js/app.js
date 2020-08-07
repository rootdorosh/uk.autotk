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
        let self = $(this);

        if (self.val() != '') {
            let url = btnSubmit.data('url');
            url = url.replace('{makeAlias}', selectMake.val());
            url = url.replace('{modelAlias}', selectModel.val());
            url = url + '#' + selectYear.val();

            btnSubmit.attr('href', url);
            btnSubmit.removeClass('hidden');
        } else {
            btnSubmit.addClass('hidden');
        }
    });


    $('body').on('change', '#wheels-model-year', function(e) {
        let self = $(this);
        let url = window.currentUrl + '?action=markets&year=' + self.val();
        $.getJSON(url, function(response) {
            let select = $('#wheels-market')
            select.find('option').remove()
            $.each(response.items, function(index, item){
                let selected = item.selected ? 'selected="selected"' : '';
                select.append('<option ' + selected + ' value="' + item.id + '">' + item.title + '</option>');
            });
            $('#wheels-market').trigger('change');
        });
    });

    $('body').on('change', '#wheels-market', function(e) {
        let self = $(this);
        let url = window.currentUrl + '?action=trims&year=' + $('#wheels-model-year').val() + '&market_id=' + self.val();
        $.getJSON(url, function(response) {
            let select = $('#wheels-trim')
            select.find('option').remove()
            $.each(response.items, function(index, item){
                select.append('<option value="' + item.id + '">' + item.title + '</option>');
            });
            $('#wheels-trim').trigger('change');
        });
    });

    $('body').on('change', '#wheels-trim', function(e) {
        let self = $(this);
        let url = window.currentUrl + '?action=items&year=' + $('#wheels-model-year').val() + '&trim_id=' + self.val() + '&market_id=' + $('#wheels-market').val();
        $.getJSON(url, function(response) {
            $('#wheel-filter-result').html(response.trim);
            $('#wrap-rim').html(response.rim);

            let title = $('.js-filter-result-title').data('title') + ' ' + $('#wheels-model-year option:selected').text() + ' ' + $('#wheels-trim option:selected').text();
            $('.js-filter-result-title').text(title);
        });
    });


});
