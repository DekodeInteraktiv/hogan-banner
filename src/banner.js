function apply_object_fit_fix() {
	if ('objectFit' in document.documentElement.style === false) {
		const { objectFitImages } = window;

		const images = document.querySelectorAll( '.hogan-banner-image img' );
		objectFitImages( images );
	}
}

if (document.readyState === "loading") {
	document.addEventListener("DOMContentLoaded", apply_object_fit_fix);
} else {
	apply_object_fit_fix();
}
