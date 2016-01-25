
// Nav Search Bar:
new Vue({
    el: '#nav-search-bar',

    data: {
        name: '',
        profile_link: '',
        request_uri: ''
    },

    ready: function(){
        // Setup and Initialize Bloodhound
        var suggestions = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: this.request_uri + '/hint-search',
            remote: {
                url: this.request_uri + '/hint-search?q=%QUERY' + encodeURI('&t[]=\\App\\User&t[]=\\App\\Group'),
                wildcard: '%QUERY'
            }
        });
        suggestions.initialize();

        // Typeahead initialisation

        $('#nav-search-bar-typeahead')
            .typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 1
                },
                {
                    source: suggestions.ttAdapter(),
                    limit: 30,
                    displayKey: 'name'
                }
            ).on('typeahead:select typeahead:autocomplete', function(e, suggestion){
                this.name = suggestion.name;
                this.profile_link = suggestion.profile_link;
            }.bind(this));
    },

    methods: {
        search: function(){
            var input = $('<input>').attr('type', 'hidden').attr('name', 'q');

            $(input).val( this.profile_link ? this.profile_link : this.name );

            $('form#nav-search-bar').append($(input)).submit();

            return false;
        }
    }
});