(function($) {
	$.fn.close = function() {
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

	$.fn.showTitle = function() {
		this.addClass('position-relative');
		let element = `
			<span class="hover-tooltip">
				${this.attr('data-title')}
			</span>
		`;
		this.append(element);
		this.children('.hover-tooltip').css('top', `-${this.children('.hover-tooltip').outerHeight() + 20}px`);
	};
}(jQuery));