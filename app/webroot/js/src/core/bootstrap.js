(function(window, document, undefined) {
	'use strict';

	// Libs
	var hozen = window.hozen;

	var Bootstrap = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
			AOS.init();
		},

		init: function() {
			$(document).on('form:success form:error', this.resetCaptcha);
			this.scrollHeader();
			this.activeTabs();
		},

		resetCaptcha: function(e, response, form) {
			if (window.hozen.component && window.hozen.component.Recaptcha) {
				window.hozen.component.Recaptcha.reset(form);
			}
		},

		scrollHeader:function(){
			// Select the logo and the container using their respective selectors.
			const logo = document.querySelector('#star-header');
			const container = document.querySelector('.wrapper-menu');
			// Select the two elements prior to the logo
			const prevElement1 = document.querySelector('.modal-btn');
			const prevElement2 = document.querySelector('.menu-btn');
			
			const columnGapTotal = 40; // medida del gap

			/* 
			 Function to calculate the maximum horizontal
			 translation (movement) of the logo.
			 */
			function calculateMaxTranslation() {
				// Gets the width of the container
				const containerWidth = container.offsetWidth;
				// Gets the width of the logo.
				const logoWidth = logo.offsetWidth;
				// Calculate the total width of the elements prior to the logo
				const prevElementsWidth = prevElement1.offsetWidth + prevElement2.offsetWidth;

				/**
				 * 
					Returns the width available in the container for the movement of the logo,
					subtracting the width of the logo and the previous elements, as well as the spaces between columns.
				 */
				return containerWidth - logoWidth - prevElementsWidth - columnGapTotal;
			}

			
			window.addEventListener('scroll', function () {
				//Gets the current position of the vertical scroll.
				const scrollPosition = window.scrollY;
				//Calculate the maximum possible vertical scroll.
				const maxScroll = document.documentElement.scrollHeight - window.innerHeight;
				// Gets the maximum possible translation of the logo based on the width of the container.
				const maxLogoTranslation = calculateMaxTranslation();

				/**
				 * Calculates the translation of the logo 
				 * based on the percentage of the scroll made.
				 */
				const logoTranslation = (scrollPosition / maxScroll) * maxLogoTranslation;

				/**
				 * Apply the transformation to the logo 
				 * to move it horizontally.
				 */
				logo.style.transform = `translateX(${logoTranslation}px)`;
			});



		},
		activeTabs: function () {
            const tabs = document.querySelectorAll('.nav-link');
            const panels = document.querySelectorAll('.tab-pane ');
			const buttonsSelect = document.querySelectorAll('[data-tab]');
            // create Local Storage
            let activeTab = localStorage.getItem("activeTab");

            if(activeTab != null){
                tabs.forEach(element => {
                    if(element.getAttribute("aria-controls") == activeTab){
                        
                        element.classList.add('active');
                    }else{
                        element.classList.remove('active');
                    }
                });
    
                panels.forEach(element => {
                    if(element.id == activeTab){
                        element.classList.add('active');
                        element.classList.add('show');
                    }else{
                        element.classList.remove('active');
                        element.classList.remove('show');
                    }
                });
            }
           

            

           if(tabs){
			tabs.forEach(element => {
                element.addEventListener("click", () => {
                    
                    const tabValue = element.getAttribute("aria-controls");
                    activeTab = tabValue;
                    localStorage.setItem("activeTab", activeTab);
                });
            });
		   }

          
			buttonsSelect.forEach(item => {
				item.addEventListener('click',()=>{
					  
                    const tabValue = item.getAttribute("data-tab");
                    activeTab = tabValue;
                    localStorage.setItem("activeTab", activeTab);
				})
			})
            
        }
	};

	Bootstrap.load();

	hozen.core.Bootstrap = Bootstrap;
}(window, window.document));
