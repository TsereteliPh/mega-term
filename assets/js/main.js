"use strict";

function get_siblings(elem) {
	// for collecting siblings
	let siblings = [];
	// if no parent, return no sibling
	if (!elem.parentNode) {
		return siblings;
	}
	// first child of the parent node
	let sibling = elem.parentNode.firstChild;
	// collecting siblings
	while (sibling) {
		if (sibling.nodeType === 1 && sibling !== elem) {
			siblings.push(sibling);
		}
		sibling = sibling.nextSibling;
	}
	return siblings;
}

function slideDown(elem) {
	elem.style.maxHeight = `${elem.scrollHeight}px`;
}

function slideToggle(elem) {
	if (elem.offsetHeight === 0) {
		elem.style.maxHeight = `${elem.scrollHeight}px`;
	} else {
		elem.style.maxHeight = 0;
	}
}

function accordion() {
	const accordionHolders = document.querySelectorAll('.js-accordion');

	accordionHolders.forEach(accordion => {
		const accordionBtns = accordion.querySelectorAll('button');
		const accordionBreakpoint = parseInt(accordion.dataset.breakpoint);

		const accordionBtnsClose = () => {
			for (let btn of accordionBtns) {
				btn.classList.remove('active');
				if (btn.nextElementSibling && (window.innerWidth <= accordionBreakpoint)) {
					btn.nextElementSibling.style.maxHeight = 0;
				}
			}
		}

		accordionBtns.forEach(btn => {
			btn.addEventListener('click', function() {
				if (this.classList.contains('active')) {
					accordionBtnsClose();
				} else {
					accordionBtnsClose();
					this.classList.add('active');
					if (btn.nextElementSibling && (window.innerWidth <= accordionBreakpoint)) {
						slideToggle(this.nextElementSibling);
					}
				}
			})
		});
	});
}

function setHeaderScrollClass() {
	const header = document.querySelector('.header');

	window.addEventListener('scroll', function () {
		if (window.scrollY >= header.offsetHeight) {
			header.classList.add('scroll');
		} else {
			header.classList.remove('scroll');
		}
	});
}

function setTelMask() {
	[].forEach.call(document.querySelectorAll('[type="tel"]'), function (input) {
		let keyCode;

		function mask(event) {
			event.keyCode && (keyCode = event.keyCode);
			let pos = this.selectionStart;
			if (pos < 3) event.preventDefault();
			let matrix = '+7 (___) ___-__-__',
				i = 0,
				def = matrix.replace(/\D/g, ''),
				val = this.value.replace(/\D/g, ''),
				new_value = matrix.replace(/[_\d]/g, function (a) {
					return i < val.length ? val.charAt(i++) || def.charAt(i) : a;
				});
			i = new_value.indexOf('_');
			if (i != -1) {
				i < 5 && (i = 3);
				new_value = new_value.slice(0, i);
			}
			let reg = matrix
				.substr(0, this.value.length)
				.replace(/_+/g, function (a) {
					return '\\d{1,' + a.length + '}';
				})
				.replace(/[+()]/g, '\\$&');
			reg = new RegExp('^' + reg + '$');
			if (
				!reg.test(this.value) ||
				this.value.length < 5 ||
				(keyCode > 47 && keyCode < 58)
			)
				this.value = new_value;
			if (event.type == 'blur' && this.value.length < 5) this.value = '';
		}

		input.addEventListener('input', mask, false);
		input.addEventListener('focus', mask, false);
		input.addEventListener('blur', mask, false);
		input.addEventListener('keydown', mask, false);
	});
}

function setNameMask() {
	const nameInputs = document.querySelectorAll('input[name=client_name]');

	if (!nameInputs) return;

	nameInputs.forEach(input => {
		input.addEventListener('input', () => {
			input.value = input.value.replace(/[^A-Za-zА-Яа-яЁё]/g, '');
		});
	});
}

function sendForm() {
	document.querySelectorAll('form[name]').forEach(function (form) {
		form.addEventListener('submit', function (e) {
			e.preventDefault();
			const form = this;
			form.classList.add('loader');
			let formData = new FormData(form);
			const formName = form.name;
			const fileInput = form.querySelector('input[type=file]');

			formData.append('action', 'send_mail');

			if (formName) {
				formData.append('form_name', formName);
			} else {
				return;
			}

			if (fileInput) {
				Array.from(fileInput.files).forEach((file, key) => {
					formData.append(key.toString(), file);
				});
			}

			const response = fetch(adem_ajax.url, {
				method: 'POST',
				body: formData,
			})
				.then(response => {
					form.classList.remove('loader');
					Fancybox.close(true);
					form.reset();
					setTimeout(function () {
						Fancybox.show([
							{
								src: response.ok ? '#success' : '#failure',
								type: 'inline',
							},
						]);
					}, 100);
				})
				.catch(error => console.error('Error:', error));
		});
	});
}

function setFileName() {
	const fileInputs = document.querySelectorAll('input[type=file]');
	if (fileInputs) {
		fileInputs.forEach(function (input) {
			input.addEventListener('change', function (e) {
				e.target.nextElementSibling.textContent = e.target.files[0].name;
			});
		});
	}
}

function tabs() {
	const tabsLists = document.querySelectorAll('.js-tabs');
	if (tabsLists) {
		tabsLists.forEach(function (tabsList) {
			bindUIFunctions(tabsList);
		});
	}

	function bindUIFunctions(tabsList) {
		tabsList.addEventListener('click', function (e) {
			const tabItem = e.target.closest('li');
			if (tabItem.classList.contains('active')) {
				toggleMobileMenu(tabItem);
			}
			if (!tabItem.classList.contains('active') && e.target !== tabsList) {
				changeTab(tabItem);
			}
		});
	}

	function changeTab(tabItem) {
		const tabContainer = document.querySelector(
			'#' + tabItem.getAttribute('data-tab')
		);

		const tabExtra = document.querySelector(
			'[data-id="' + tabItem.getAttribute('data-tab') + '"]'
		);

		tabItem.classList.add('active');
		get_siblings(tabItem).forEach(function (tab) {
			tab.classList.remove('active');
		});

		tabContainer.classList.add('active');
		get_siblings(tabContainer).forEach(function (tab_container) {
			tab_container.classList.remove('active');
		});

		tabExtra.classList.add('active');
		get_siblings(tabExtra).forEach(function (tab_extra) {
			tab_extra.classList.remove('active');
		});

		tabItem.parentNode.classList.remove('open');
	}

	function toggleMobileMenu(tabItem) {
		tabItem.parentNode.classList.toggle('open');
	}
}

// ---------------------------------------------------------------- Ajax

function showMorePosts() {
	const show_more_btns = document.querySelectorAll('.js-show-more');

	if (!show_more_btns) return;

	show_more_btns.forEach(button => {
		button.addEventListener('click', function (e) {
			e.stopImmediatePropagation();
			let container = this.previousElementSibling;
			this.classList.add('loader');
			let slug = this.dataset.slug;

			let response = fetch(adem_ajax.url, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
				},
				body: new URLSearchParams({
					action: 'load_more',
					query: window[`${slug}_posts`],
					page: window[`${slug}_current_page`],
				}),
			})
				.then(response => response.text())
				.then(data => {
					this.classList.remove('loader');
					container.insertAdjacentHTML('beforeend', data);
					window[`${slug}_current_page`]++;
					if (window[`${slug}_current_page`] === window[`${slug}_max_pages`]) this.classList.add('hidden');
				})
				.catch(error => {
					console.error('Error:', error);
					Fancybox.show([
						{
							src: '#failure',
							type: 'inline',
						},
					]);
				});
		});
	});
}

// ---------------------------------------------------------------- Swiper

function initReviewSlider() {
	const slider = document.querySelector('.review-slider');

	if (!slider) return;

	const allSliders = slider.querySelectorAll('.swiper');

	allSliders.forEach(slider => {
		let swiper = new Swiper(slider, {
			slidesPerView: 'auto',
			spaceBetween: 10,
			centerInsufficientSlides: true,
			navigation: {
				nextEl: slider.parentNode.querySelector('.controls__next'),
				prevEl: slider.parentNode.querySelector('.controls__prev'),
			},
			pagination: {
				el: slider.querySelector('.pagination'),
				bulletClass: 'pagination__bullet',
				bulletActiveClass: 'active',
				clickable: true
			},
			breakpoints: {
				1441: {
					slidesPerView: 4,
				},
				1281: {
					slidesPerView: 4,
				},
				992: {
					slidesPerView: 3,
				},
				769: {
					slidesPerView: 2,
				}
			}
		});
	});
}

function initArticleSlider() {
	const slider = document.querySelector('.article-slider');

	if (!slider) return;

	const allSliders = slider.querySelectorAll('.swiper');

	allSliders.forEach(slider => {
		let swiper = new Swiper(slider, {
			slidesPerView: 'auto',
			spaceBetween: 10,
			centerInsufficientSlides: true,
			navigation: {
				nextEl: slider.parentNode.querySelector('.controls__next'),
				prevEl: slider.parentNode.querySelector('.controls__prev'),
			},
			pagination: {
				el: slider.querySelector('.pagination'),
				bulletClass: 'pagination__bullet',
				bulletActiveClass: 'active',
				clickable: true
			},
			breakpoints: {
				1440: {
					slidesPerView: 4,
				},
				1280: {
					slidesPerView: 4,
				},
				992: {
					slidesPerView: 3,
				},
				769: {
					slidesPerView: 2,
				}
			}
		});
	});
}

function initBrandsSlider() {
	const sliders = document.querySelectorAll('.brands-slider');

	if (!sliders) return;

	sliders.forEach(slider => {
		let swiper = new Swiper(slider.querySelector('.swiper'), {
			slidesPerView: 'auto',
			spaceBetween: 10,
			centerInsufficientSlides: true,
			navigation: {
				nextEl: slider.parentNode.querySelector('.controls__next'),
				prevEl: slider.parentNode.querySelector('.controls__prev'),
			},
			breakpoints: {
				1280: {
					slidesPerView: 10,
				},
				992: {
					slidesPerView: 7,
				},
				769: {
					slidesPerView: 6,
				}
			}
		});
	});
}

// ---------------------------------------------------------------- Header

function header() {
	const header = document.querySelector('.header');

	if (!header) return;

	const headerBurger = header.querySelector('.header__burger');
	const headerDrop = header.querySelector('.header__drop');

	const dropOpener = () => {
		header.classList.add('active');
		headerBurger.classList.add('active');
		headerDrop.style.maxHeight = headerDrop.scrollHeight + 'px';
		document.body.style.overflow = 'hidden';
	}

	const dropCloser = () => {
		header.classList.remove('active');
		headerBurger.classList.remove('active');
		headerDrop.style.maxHeight = 0;
		document.body.style.overflow = 'visible';
	}

	headerBurger.addEventListener('click', function() {
		if (this.classList.contains('active')) {
			dropCloser();
		} else {
			dropOpener();
		}
	})
}

function headerCatalogToggle() {
	const catalog = document.querySelector('.header__catalog');
	const catalogButton = document.querySelector('.header__catalog-btn');

	catalogButton.onclick = () => {
		catalogButton.classList.toggle('active');
		catalog.classList.toggle('active');
	}
}

function headerSmallCatsHandler() {
	const catsWrapper = document.querySelector('.header__small-cats');

	if (!catsWrapper) return;

	const catsWrapperStyles = window.getComputedStyle(catsWrapper);
	const catsWrapperColumns = catsWrapperStyles.getPropertyValue('grid-template-columns').split(' ').length;

	const cats = catsWrapper.querySelectorAll('.header__small-cat');
	const overflowCats = [];
	const btn = catsWrapper.querySelector('button');

	const checkHeight = () => {
		return catsWrapper.offsetHeight > 60;
	}

	if ((catsWrapperColumns <= (cats.length - 1))) {
		btn.classList.remove('hidden');
		for (let i = cats.length - 1; i > 0; i--) {
			cats[i].classList.add('hidden');
			overflowCats.push(cats[i]);
			if (!checkHeight()) break;
		}
	}

	btn.addEventListener('click', function () {
		if (this.classList.contains('active')) {
			overflowCats.forEach(cat => cat.classList.add('hidden'));
			this.classList.remove('active');
			this.textContent = 'Еще';
		} else {
			overflowCats.forEach(cat => cat.classList.remove('hidden'));
			this.classList.add('active');
			this.textContent = 'Скрыть';
		}
	});
}

// ---------------------------------------------------------------- Other
function mainTextHeightHandler() {
	const mainTextBlocks = document.querySelectorAll('.main-text');

	if (!mainTextBlocks) return;

	mainTextBlocks.forEach(block => {
		let textBlock = block.querySelector('.main-text__text');
		let textContent = textBlock.querySelector('.main-text__text-content');
		let btn = textBlock.querySelector('.btn');

		if (textContent.offsetHeight > 350) {
            textBlock.classList.add('overflow');
			textContent.style.maxHeight = 350 + 'px';
        } else {
			btn.classList.add('hidden');
		}

		btn.addEventListener('click', function() {
            textBlock.classList.toggle('overflow');

			if (textContent.offsetHeight === 350) {
				textContent.style.maxHeight = `${textContent.scrollHeight}px`;
			} else {
				textContent.style.maxHeight = 350 + 'px';
			}
        });
	});
}

document.addEventListener('DOMContentLoaded', function () {
	accordion();
	header();
	headerCatalogToggle();
	headerSmallCatsHandler();
	mainTextHeightHandler();
	setHeaderScrollClass();
	setFileName();
	setNameMask();
	sendForm();
	setTelMask();
	tabs();

	// Ajax
	showMorePosts();

	// Swiper
	initReviewSlider();
	initArticleSlider();
	initBrandsSlider();
});
