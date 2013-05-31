(function($) {
    /**
     * Sidebar module implementation.
     *
     * @author Leo Zurbriggen
     * @namespace Tc.Module
     * @class Sidebar
     * @extends Tc.Module
     */
    Tc.Module.Sidebar = Tc.Module.extend({
        
        on: function(callback) {
            var that = this;
            var $ctx = this.$ctx;

            $('.openclose', $ctx).on('click', function(){
				if($(this).hasClass('closed')){
					$(this).removeClass('closed');
				}else{
					$(this).addClass('closed');
				}
				return false;
			});

            callback();
        },
        
        after: function() {
            
        }

    });
})(Tc.$);