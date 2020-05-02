(function($) {
	$.fn.hide = function() {
	    this.css('height', '0');
	    return this;
	};

	$.fn.collapse = function() {
		let height = 0;
		this.children().each(function() {
			height += $(this).outerHeight(true);
		});
	    this.css('height', `${height}px`);
	    return this;
	};
}(jQuery));