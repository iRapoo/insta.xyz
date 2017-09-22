jQuery(function($){

    var _panel = $("._auth_panel");

    $("._auth_btn").click(function() {
        if(_panel.css("display")=="none")
            _panel.show();
    });

    $(document).mouseup(function (e){
    	if (!_panel.is(e.target)
    	    && _panel.has(e.target).length === 0) {
    		_panel.hide();
    	}
    });

});