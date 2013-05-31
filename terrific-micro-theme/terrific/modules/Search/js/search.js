(function($) {
    /**
     * Search module implementation.
     *
     * @author Leo Zurbriggen
     * @namespace Tc.Module
     * @class Search
     * @extends Tc.Module
     */
    Tc.Module.Search = Tc.Module.extend({
        
        on: function(callback) {
            var that = this;
            var $ctx = this.$ctx;
			
			// Increase seach field width when clicked
            $('.field', $ctx).on('click', function(){
				$(this).addClass('wide');
			}).on('blur', function(){
				$(this).removeClass('wide');
			});

            callback();
        },
        
        after: function() {
            
        }

    });
})(Tc.$);