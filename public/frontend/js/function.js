(function($) {
	"use strict";
	var HT = {}; 
	var timer;

	HT.swiperOption = (setting) => {
		console.log("Swiper Settings:", setting); // Kiểm tra dữ liệu JSON đã parse
		let option = {};
	
		if (setting.animation) {
			option.effect = setting.animation.toLowerCase(); // Đảm bảo giá trị viết thường
		}
	
		if (setting.arrow === "accept") {
			option.navigation = {
				nextEl: ".swiper-button-next",
				prevEl: ".swiper-button-prev",
			};
		}
	
		if (setting.autoplay === "accept") {
			if(setting.pausehover === "accept"){
				if (setting.animationdelay === "0" || setting.animationdelay === null) {
					option.autoplay = {
						delay: 3000, // Thời gian chuyển slide
						disableOnInteraction: false,
					pauseOnMouseEnter: true,
					};
				}else{
					option.autoplay = {
						delay: setting.animationdelay,
						disableOnInteraction: true,
					pauseOnMouseEnter: true,
	
					};
					console.log(option);
					
				}
			}else{
				if (setting.animationdelay === 0 || setting.animationdelay === null) {
					option.autoplay = {
						delay: 3000, // Thời gian chuyển slide
						disableOnInteraction: false,
					pauseOnMouseEnter: false,
					};
				}else{
					option.autoplay = {
						delay: setting.animationdelay,
						disableOnInteraction: true,
					pauseOnMouseEnter: false,
	
					};
					console.log(option);
					
				}
			}
			
		}

		
	
		if (setting.navigate === "dots") {
			option.pagination = {
				el: ".swiper-pagination",
				clickable: true,
			};
		}

		// if (setting.pausehover === "accept") {
		// 	option.autoplay: {
		// 		disableOnInteraction: false,
		// 		pauseOnMouseEnter: true,
		// 	},
		// }

		
	
		console.log("Swiper Options:", option); // Kiểm tra cấu hình Swiper
		return option;
	};
	
	
	/* MAIN VARIABLE */
	HT.swiper = () => {
		if ($('.panel-slide .swiper-container').length) {
			let setting = JSON.parse($('.panel-slide').attr('data-setting'));
			let option = HT.swiperOption(setting);
	
			console.log("Initializing Swiper with options:", option);
	
			var swiper = new Swiper(".panel-slide .swiper-container", option);
	
			if (!swiper) {
				console.error("Swiper initialization failed.");
			}
		} else {
			console.error("Swiper container not found.");
		}
	};
	
	

	// HT.swiperCategory = () => {
	// 	var swiper = new Swiper(".panel-category .swiper-container", {
	// 		loop: false,
	// 		pagination: {
	// 			el: '.swiper-pagination',
	// 		},
	// 		spaceBetween: 20,
	// 		slidesPerView: 3,
	// 		breakpoints: {
	// 			415: {
	// 				slidesPerView: 3,
	// 			},
	// 			500: {
	// 			  slidesPerView: 3,
	// 			},
	// 			768: {
	// 			  slidesPerView: 6,
	// 			},
	// 			1280: {
	// 				slidesPerView: 10,
	// 			}
	// 		},
	// 		navigation: {
	// 			nextEl: '.swiper-button-next',
	// 			prevEl: '.swiper-button-prev',
	// 		},
			
	// 	});
	// }

	// HT.swiperBestSeller = () => {
	// 	var swiper = new Swiper(".panel-bestseller .swiper-container", {
	// 		loop: false,
	// 		pagination: {
	// 			el: '.swiper-pagination',
	// 		},
	// 		spaceBetween: 20,
	// 		slidesPerView: 2,
	// 		breakpoints: {
	// 			415: {
	// 				slidesPerView: 1,
	// 			},
	// 			500: {
	// 			  slidesPerView: 2,
	// 			},
	// 			768: {
	// 			  slidesPerView: 3,
	// 			},
	// 			1280: {
	// 				slidesPerView: 4,
	// 			}
	// 		},
	// 		navigation: {
	// 			nextEl: '.swiper-button-next',
	// 			prevEl: '.swiper-button-prev',
	// 		},
			
	// 	});
	// }
	
	
	

	HT.wow = () => {
		var wow = new WOW({
			boxClass: "wow",
			animateClass: "animated",
			offset: 0,
			mobile: true,
			live: true,
			resetAnimation: true,
		});
		wow.init();
	};

	HT.niceSelect = () => {
		if($('.nice-select').length){
			$('.nice-select').niceSelect();
		}
		
	}

	$(document).ready(function(){
		HT.wow()
		HT.swiper()
		HT.niceSelect()		
	});

})(jQuery);
