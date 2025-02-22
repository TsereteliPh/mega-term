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
		const accordionBreakpoint = parseInt(accordion.dataset.breakpoint) || 9999;

		const accordionBtnsClose = () => {
			for (let btn of accordionBtns) {
				btn.classList.remove('active');
				if (btn.nextElementSibling && (window.innerWidth <= accordionBreakpoint)) {
					btn.nextElementSibling.style.maxHeight = 0;
				}
			}
		}

		accordion.addEventListener('click', function(evt) {
			if (evt.target.nodeName !== 'BUTTON') return

			if (evt.target.classList.contains('active')) {
				accordionBtnsClose();
			} else {
				accordionBtnsClose();
				evt.target.classList.add('active');
				if (evt.target.nextElementSibling && (window.innerWidth <= accordionBreakpoint)) {
					slideToggle(evt.target.nextElementSibling);
				}
			}
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
			input.value = input.value.replace(/[^A-Za-zА-Яа-яЁё\s]/g, '');
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

function changeInputQuantity(form, dispatch = false) {
	const formEl = document.querySelectorAll(form);
	if (formEl) {
		formEl.forEach(form => {
			form.addEventListener('click', function (e) {
				if (e.target.classList.contains('quantity__btn')) {
					let input = e.target.closest('.quantity').querySelector('.quantity__input');
					let val = parseInt(input.value);
					let min = parseInt(input.getAttribute('min'));
					let max = parseInt(input.getAttribute('max'));
					let step = parseInt(input.getAttribute('step'));

					if (e.target.classList.contains('quantity__btn--add')) {
						if (max && (max <= val)) {
							input.value = max;
						} else {
							input.value = val + step;
						}
					} else {
						if ((min || min == 0) && (min >= val - step)) {
							input.value = min;
						} else if (val > 1) {
							input.value = val - step;
						}
					}

					const changeQuantityInput = new Event('change', {bubbles: true, cancelable: true});
					input.dispatchEvent(changeQuantityInput);
				}
			});
		});
	}
}

// ---------------------------------------------------------------- Ajax

function ajaxSearch() {
    const search = document.querySelector('#search');
    if (!search) return;

    const searchInput = search.querySelector('.search-panel__input');
    const searchResult = search.querySelector('.search-panel__result');
    let timeout = null;
    let controller = new AbortController();

    searchInput.addEventListener('input', function () {
        const querySearch = this.value.trim();
        searchResult.innerHTML = '';
        searchResult.classList.toggle('show', querySearch.length >= 3);

        if (querySearch.length < 3) return;

        searchResult.classList.add('loader');

        clearTimeout(timeout);
        controller.abort();
        controller = new AbortController();

        timeout = setTimeout(async () => {
            try {
                const response = await fetch(adem_ajax.url, {
                    method: 'POST',
                    headers: {
						'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
					},
                    body: new URLSearchParams({
						action: 'search',
						query: querySearch
					}),
                    signal: controller.signal,
                });

                const data = await response.json();
                searchResult.classList.remove('loader');
                searchResult.innerHTML = '';

                if (data.status === 'success' && data.markup) {
                    searchResult.classList.remove('no-result');
                    searchResult.innerHTML = data.markup;
                } else {
                    const searchErr = document.createElement('div');
                    searchErr.classList.add('search-panel__card');
                    searchErr.textContent = data.message || 'Результатов не найдено';
                    searchResult.classList.add('no-result');
                    searchResult.appendChild(searchErr);
                }
            } catch (error) {
                if (error.name !== 'AbortError') {
                    console.error('Ошибка:', error);
                    Fancybox.show([{
						src: '#failure',
						type: 'inline'
					}]);
                }
            }
        }, 500);
    });

    search.addEventListener('focusout', function (e) {
		if (!search.contains(e.relatedTarget)) {
			clearTimeout(timeout);
			controller.abort();
			searchResult.classList.remove('show');
			searchResult.innerHTML = '';
		}
    });
}

function changeCatalogView() {
	const catalogForm = document.querySelector('.catalog__view');

	if (!catalogForm) return;

	const radioBtns = catalogForm.querySelectorAll('input[name="catalog-view"]');
	let update_cart;

	radioBtns.forEach(radio => {
		radio.addEventListener('change', function (e) {
			if (update_cart != null) clearTimeout(update_cart);

			update_cart = setTimeout(() => {
				this.closest('form').querySelector('button').click();
			}, 1000);
		});
	});

	catalogForm.addEventListener('submit', function (e) {
		e.preventDefault();
		const catalogList = document.querySelector('.catalog__list');
		const catalogItems = catalogList.querySelectorAll('.catalog__item:not(.catalog__item--banner)');
		const noticeWrapper = document.querySelector('.woocommerce-notices-wrapper');

		catalogItems.forEach(item => item.classList.add('loader'));

		let formData = new FormData(this);
		formData.append('action', 'wc_catalog_view');

		const response = fetch(adem_ajax.url, {
			method: 'POST',
			body: formData
		})
		.then(response => response.text())
		.then(data => {
			try {
				data = JSON.parse(data);
			} catch (e) {
				noticeWrapper.innerHTML = data;
			}
			if (data.status == 'success') {
				if (data.view == 'flex') {
					catalogList.classList.add('catalog__list--flex');
					catalogItems.forEach(item => item.classList.add('product-card--large'));
				} else {
					catalogList.classList.remove('catalog__list--flex');
					catalogItems.forEach(item => item.classList.remove('product-card--large'));
				}

				catalogItems.forEach(item => item.classList.remove('loader'));
			}
		})
		.catch((error) => {
			console.error('Error:', error);
		});
	});
}

function favorites() {
	const favBtns = document.querySelectorAll('.btn-fav');
	const favCounter = document.querySelector('.header__fav-counter');

	if (!favBtns) return;

	favBtns.forEach(btn => {
		btn.addEventListener('click', function () {
			this.setAttribute('disabled', true);
			this.classList.add('btn-fav--loading');
			const options = {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
				},
				body: new URLSearchParams({
					action: this.classList.contains('active') ? 'remove_from_favorite' : 'add_to_favorite',
					id: this.dataset.id,
					user: this.dataset.user
				})
			};

			const response = fetch(adem_ajax.url, options)
				.then(response => response.json())
				.then(data => {
					this.classList.remove('btn-fav--loading');
					this.removeAttribute('disabled');

					if (data.status === 'success') {
						favCounter.textContent = data.count;
						data.count > 0
							? favCounter.classList.add('active')
							: favCounter.classList.remove('active');
						favBtns.forEach(btn => {
							if (btn.dataset.id === this.dataset.id) {
								btn.classList.contains('active')
									? btn.classList.remove('active')
									: btn.classList.add('active');
							}
						});
					} else {
						setTimeout(function () {
							Fancybox.show([
								{
									src: '#failure',
									type: 'inline',
								},
							]);
						}, 100);
					}
				})
				.catch(error => console.error('Error: ', error));
		})
	});
}

function sendForm() {
	document.querySelectorAll('form[name]').forEach(function (form) {
		if (form.name === 'checkout' ) return;

		if (form.name === 'login' || form.name === 'registration') {
			sendLoginForm(form);
			return;
		}

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

function sendLoginForm(form) {
	form.addEventListener('submit', function (e) {
		e.preventDefault();
		const form = this;
		form.classList.remove('invalid');
		form.classList.add('loader');
		let formData = new FormData(form);
		const formName = form.name;
		const formError = form.querySelector('.js-error');

		if (formName) {
			formData.append('action', formName);
			formData.append('form_name', formName);
		} else {
			return;
		}

		const response = fetch(adem_ajax.url, {
			method: 'POST',
			body: formData,
		})
			.then(response => response.json())
			.then(data => {
				form.classList.remove('loader');
				if (data.status == 'success') {
					Fancybox.close(true);
					location.reload();
				} else {
					form.classList.add('invalid');
					formError.textContent = data.message ? data.message : 'Что-то пошло не так. Пожалуйста, повторите попытку позже';
				}
			})
			.catch(error => console.error('Error:', error));
	});
}

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

function initProductGallerySlider() {
	const productGallery = document.querySelector('.product__gallery');

	if (!productGallery) return;

	let productThumb = productGallery.querySelector('.product__gallery-thumb-swiper');
	let productBig = productGallery.querySelector('.product__gallery-big');

	let thumbProductSlider = new Swiper(productThumb, {
		direction: 'horizontal',
		spaceBetween: 10,
		slidesPerView: 3,
		watchSlidesProgress: true,
		navigation: {
			nextEl: productThumb.parentNode.querySelector('.controls__next'),
			prevEl: productThumb.parentNode.querySelector('.controls__prev')
		},
		breakpoints: {
			577: {
				direction: 'vertical',
				slidesPerView: 4
			}
		}
	});

	let bigProductSlider = new Swiper(productBig, {
		slidesPerView: 'auto',
		spaceBetween: 10,
		thumbs: {
			swiper: thumbProductSlider,
		}
	});
}

function initCatalogCatsSlider() {
	const slider = document.querySelector('.catalog__cats');

	if (!slider) return;

	let swiper = new Swiper(slider.querySelector('.swiper'), {
		slidesPerView: 'auto',
		spaceBetween: 10,
		navigation: {
			nextEl: slider.querySelector('.controls__next'),
			prevEl: slider.querySelector('.controls__prev'),
		},
		pagination: {
			el: slider.querySelector('.pagination'),
			bulletClass: 'pagination__bullet',
			bulletActiveClass: 'active',
			clickable: true
		},
		breakpoints: {
			1440: {
				slidesPerView: 6,
			},
			1280: {
				slidesPerView: 5,
			},
			992: {
				slidesPerView: 4,
			},
			769: {
				slidesPerView: 3,
			}
		}
	});
}

function initProductSlider() {
	const sliders = document.querySelectorAll('.product-slider');

	if (!sliders) return;

	sliders.forEach(slider => {
		let swiper = new Swiper(slider.querySelector('.swiper'), {
			slidesPerView: 'auto',
			spaceBetween: 10,
			centerInsufficientSlides: true,
			pagination: {
				el: slider.querySelector('.pagination'),
				bulletClass: 'pagination__bullet',
				bulletActiveClass: 'active',
				clickable: true
			},
			navigation: {
				nextEl: slider.querySelector('.controls__next'),
				prevEl: slider.querySelector('.controls__prev'),
			},
			breakpoints: {
				1280: {
					slidesPerView: 4,
				},
				992: {
					slidesPerView: 3,
				}
			}
		});
	});
}

// ---------------------------------------------------------------- Header

function header() {
	const header = document.querySelector('.header');

	if (!header || window.innerWidth > 991) return;

	const headerBurger = header.querySelector('.header__burger');
	const headerMenu = header.querySelector('.header__menu');

	headerBurger.addEventListener('click', function() {
		this.classList.toggle('active');
        headerMenu.classList.toggle('active');
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
			btn.classList.remove('hidden');
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

function orderbyFormButtonsListener() {
	const orderbyForm = document.querySelector('.catalog__orderby-form');

    if (!orderbyForm) return;

    const buttons = orderbyForm.querySelectorAll('.catalog__orderby-btn');
	const select = orderbyForm.querySelector('.catalog__orberby-select');

	orderbyForm.addEventListener('click', function(evt) {
		if (evt.target.classList.contains('catalog__orderby-btn')) {
            buttons.forEach(btn => btn.classList.remove('active'));
            evt.target.classList.add('active');
            select.value = evt.target.dataset.value;
			this.submit();
        }
	});
}

function previousElementSiblingContentCopy() {
	const copyButtons = document.querySelectorAll('.js-copy');

	if (!copyButtons) return;

	copyButtons.forEach(button => {
		button.addEventListener('click', function() {
			let input = this.previousElementSibling;

            navigator.clipboard.writeText(input.textContent)
				.then(() => {
					Fancybox.show([
						{
							src: '#copy',
							type: 'inline',
						},
					]);
				})
				.catch(e => {
					Fancybox.show([
						{
							src: '#failure',
							type: 'inline',
						},
					]);
				});
		})
	});
}

document.addEventListener('DOMContentLoaded', function () {
	accordion();
	changeInputQuantity('.product__form');
	header();
	headerCatalogToggle();
	headerSmallCatsHandler();
	mainTextHeightHandler();
	orderbyFormButtonsListener();
	previousElementSiblingContentCopy();
	setHeaderScrollClass();
	setFileName();
	setNameMask();
	setTelMask();
	tabs();

	// Ajax
	ajaxSearch();
	changeCatalogView();
	favorites();
	sendForm();
	showMorePosts();

	// Swiper
	initReviewSlider();
	initArticleSlider();
	initBrandsSlider();
	initProductGallerySlider();
	initCatalogCatsSlider();
	initProductSlider();
});
